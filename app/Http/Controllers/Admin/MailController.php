<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\AdminMail;
use App\AdminsClients;
use App\Client;
use App\Employee;
use App\ProtocolNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Validator;

/**
 * Class MailController
 * @package App\Http\Controllers\Admin
 */
class MailController extends AdminController {

	/**
	 * Index of all emails
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function indexMail() {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $mails = AdminMail::getAllAdminMails($this->idAdmin);
        foreach($mails as $mail){
            $count = count(explode(',', $mail->to));
            if($count > 1){
                $mail->to = $count;
            }
        }

        $this->data['mails'] = $mails;
        return view('admin.newsletter', $this->data);
    }

    //просмотр отправленного письма с возможностью на базе него создать и отправить новое
    public function showMail(Request $request, $domain)
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $this->data['editMail'] = AdminMail::find($request->id);
        $emailsTo = explode(',', $this->data['editMail']->to);
        $this->data['clients'] = Client::whereIn('email', $emailsTo)->select('id', 'email')->get();
        $this->data['von'] = $domain;

        return view('admin.newsletter2', $this->data);
    }

    /**
     * @param $domain
     * @return mixed
     */
    //страница редактора нового письма
    public function createMail($domain)
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $this->data['von'] = $domain;
        return view('admin.newsletter2', $this->data);
    }

    /**
     * @param Request $request
     * @param $domain
     * @return mixed
     */
    //страница редактирования черновика
    public function editMail(Request $request, $domain)
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $editMail = AdminMail::find($request->id);
        $emailsTo = explode(',', $editMail->to);
        $clients = Client::whereIn('email', $emailsTo)->select(['id', 'email'])->get();
        $this->data += [ 'clients' => $clients, 'von' => $domain, 'editMail' => $editMail];
        return view('admin.newsletter2', $this->data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    //запись в базу нового письма
    public function storeMail(Request $request) {
        if (Gate::denies('admin')) {
            return redirect('/office/order_list');
        }

        $rules = [
            'id'                =>  'integer',
            'subject'           =>  'required|string|max:255',
            'title'             =>  'required|string|max:255',
            'form'              =>  'required|string',
            'client_type'       =>  'required|string',
            'client_id_test'    =>  'string',
            'text'              =>  'required',
            'img'               =>  'image'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            echo $validator->errors();
            return response()->json(false);
        }

        $send = $request->input('send') ? 1 : 0;
        $file = $request->file('img');

        if($request->input('id')){
            $id = $request->input('id');
        }else{
            $id = false;
        }

        if ($request->hasFile('img')) {
            $path = 'images/mailImage/';
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $request->file('img')->move($path, $filename);
            $pathToImg = public_path() . '/'. $path . $filename;
        }elseif($id){
            $filename = AdminMail::where('id', $id)->first()->img;
            $pathToImg = ($filename != '0') ? public_path() . '/images/mailImage/' . $filename : '';
        }else{
            $pathToImg = '';
        }

        $client_type = $request->input('client_type');

        $admin = Admin::where('user_id', Auth::user()->id)->first();
        if (!$admin) {
            $admin = Admin::find(Employee::where('user_id', Auth::id())->first()->admin_id);
        }
        if ($client_type == 'some') {
            $clientsId = explode(',', $request->input('client_id_test'));
            $clients = Client::whereIn('id', $clientsId)->get();

            $clientsToBase = $clients->implode('email', ',');
                $mailData = [
                    'to' => $clientsToBase,
                    'from' => $request->input('form'),
                    'title' => $request->input('title'),
                    'subject' => $request->input('subject'),
                    'text' => $request->input('text'),
                    'img' => isset($filename) ? $filename : 0,
                    'send' => $send,
                    'count' => $clients->count(),
                    'admin_id' => $admin->id,
                ];

                if($id){
                    $admin_mail = AdminMail::find($id);

                    if ($admin_mail->send){
                        AdminMail::create($mailData);
                    }else{
                        $admin_mail->update($mailData);
                    }
                }else {
                    AdminMail::create($mailData);
                }

                if (!$send) {
                    return redirect('/office/newsletter');
                }


        } else {
            $clients_id = AdminsClients::where(['admin_id' => $this->idAdmin, 'email_send' => 1])
                                        ->select('client_id')->get()->toArray();
            $clients = Client::whereIn('id', $clients_id)->get();

            $mailData = [
                'to' => $clients->count(),
                'from' => $request->input('form'),
                'title' => $request->input('title'),
                'subject' => $request->input('subject'),
                'text' => $request->input('text'),
                'img' => (isset($filename) && $filename != 0) ? $filename : 0,
                'group' => isset($group) ? $group : 1,
                'send' => $send,
                'count' => $clients->count(),
                'admin_id' => $admin->id,
            ];

            if($id){
                AdminMail::where('id', $id)->update($mailData);
            }else {
                AdminMail::create($mailData);
            }

            if (!$send) {
                return redirect('/office/newsletter');
            }
        }

        
        foreach ($clients as $client) {
            
            $subject = $request->input('subject');
            $email = $client->email;
            $fromWho = $request->input('form');

            Mail::send('emails.newsletter_admin',
                array('content' => $request->input('text'), 'img' => $pathToImg, 'email' => $email, 'subject' => $subject), 
                function ($message) use ($subject, $email, $fromWho) {
                    $message->from('admin@timebox24.com', $fromWho);
                    $message->to($email)->subject($subject);
            });
        }

	    ProtocolNewsletter::protocolAdminSendNewsletter($this->idAdmin, $request->input('title'), $this->employeeId);

        return redirect('/office/newsletter');
    }

    /**
     * @param Request $request
     * @return array
     */
    //получение email клиента для автозаполнения
    public function getClientEmail(Request $request) {
        $q = $request->input('q');
        $clients_id = AdminsClients::where(['admin_id' => $this->idAdmin, 'email_send' => 1])
                                    ->lists('client_id')->toArray();

        $clients = Client::where('email', 'like', "%$q%")
                        ->whereIn('id', $clients_id)
                        ->select('id', 'email as name')->get();
        return $clients;
    }

    /**
     * @param Request $request
     * @param AdminMail $mail
     * @return mixed
     */
    //просмотр письма в списке писем
    public function getMail(Request $request, AdminMail $mail)
    {
        if ($request->ajax()) {
            $mail = $mail->find($request->id);
            return response()->json($mail);
        }

        return response()->json(false);
    }


    /**
     * @param Request $request
     * @param $domain
     * @return mixed
     */
    //сохранение письма
    public function saveMail(Request $request, $domain) {
        if (Gate::denies('admin')) {
            return redirect('/office/order_list');
        }
        $client_type = $request->input('client_type');
        $admin = Admin::where('user_id', Auth::user()->id)->first();
        if ($client_type == 'some') {
            $clientsId = explode(',', $request->input('client_id_test'));
            $clients = Client::whereIn('id', $clientsId)->get();
        } else {
            $clients = Client::getAdminClients($domain);
        }
        foreach ($clients as $client) {
            $mailData = [
                'to' => $client->email,
                'subject' => $request->input('subject'),
                'text' => $request->input('text'),
                'admin_id' => $admin->id
            ];
            AdminMail::create($mailData);
        }

        return redirect('/office/newsletter');
    }

}
