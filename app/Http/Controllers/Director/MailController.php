<?php

namespace App\Http\Controllers\Director;

use App\Admin;
use App\Mail as DirectorMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class MailController extends DirectorController
{
    //вывод всех писем с отображение к-ва получателей или надписи all если получали все
    public function indexMail()
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }
        $mails = DirectorMail::orderBy('created_at', 'desc')->paginate(20);

        foreach($mails as $mail){
            $count = count(explode(',', $mail->to));
            if($count > 1){
                $mail->to = $count . ' receives';
            }
        }
        $this->data['mails'] = $mails;

        return view('director.newsletter', $this->data);
    }
    
    public function showMail(Request $request)
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }

        $this->data['editMail'] = DirectorMail::find($request->id);
        $emailsTo = explode(',', $this->data['editMail']->to);
        $this->data['admins'] = Admin::whereIn('email', $emailsTo)->select('id', 'email')->get();
        $this->data['von'] = 'director@timebox24.com';
        
        return view('director.newsletter2', $this->data);
    }

    //страница создания нового письма
    public function createMail()
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }
        $this->data['von'] = 'director@timebox24.com';
        
        return view('director.newsletter2', $this->data);
    }

    //редактирование письма
    public function editMail(Request $request)
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }

        $this->data['editMail'] = DirectorMail::find($request->id);
        $emailsTo = explode(',', $this->data['editMail']->to);
        $this->data['admins'] = Admin::whereIn('email', $emailsTo)->select('id', 'email')->get();
        $this->data['von']= 'director@timebox24.com';

        return view('director.newsletter2', $this->data);
    }

    //сохранение письма
    public function storeMail(Request $request)
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }

        $send = $request->input('send') ? 1 : 0;
        $file = $request->file('img');
        $admin_type = $request->input('admin_type');
        $id = $request->input('id') ?: false;

        //проверяем и сохраняем картинку для письма
        if ($request->hasFile('img')) {
            $path = 'images/mailImage/';
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $request->file('img')->move($path, $filename);
            $pathToImg = public_path() . '/'. $path . $filename;
        }elseif($id){
            $filename = DirectorMail::where('id', $id)->first()->img;
            $pathToImg = ($filename != '0') ? public_path() . '/images/mailImage/' . $filename : '';
        }else{
            $pathToImg = '';
        }

        //проверка получателей, все или несколько
        if ($admin_type === 'some') {
            $adminsId = explode(',', $request->input('admin_id_test'));
            $admins = Admin::whereIn('id', $adminsId)->get();
            $adminsToBase = $admins->implode('email', ',');
                $mailData = [
                    'to' => $adminsToBase,
                    'from' => $request->input('form'),
                    'title' => $request->input('title'),
                    'subject' => $request->input('subject'),
                    'text' => $request->input('text'),
                    'img' => isset($filename) ? $filename : 0,
                    'group' => isset($group) ? $group : 0,
                    'count' => $admins->count(),
                    'send' => $send,
                ];
                
                if($id){
                    $dir_mail = DirectorMail::find($id);
                        
                    if ($dir_mail->send){
                        DirectorMail::create($mailData);
                    }else{
                        $dir_mail->update($mailData);
                    }

                }else {
                    DirectorMail::create($mailData);
                }
                
                if (!$send) {
                    return redirect()->action('Director\MailController@indexMail');
                }

        } else {

            $admins = Admin::where('status', 'active')->get();

            $mailData = [
                'to' => $admins->count(),
                'from' => $request->input('form'),
                'title' => $request->input('title'),
                'subject' => $request->input('subject'),
                'text' => $request->input('text'),
                'img' => (isset($filename) && $filename != 0) ? $filename : 0,
                'group' => isset($group) ? $group : 1,
                'count' => $admins->count(),
                'send' => $send,
            ];

            if($id){
                DirectorMail::where('id', $id)->update($mailData);
            }else {
                DirectorMail::create($mailData);
            }

            if (!$send) {
                return redirect()->action('Director\MailController@indexMail');
            }

        }
        //отправка писем
        foreach ($admins as $admin) {

            $subject = $request->input('subject');
            $email = $admin->email;
            $fromWho = $request->input('form');

            Mail::send('emails.newsletter_director',
                array('content' => $request->input('text'), 'img' => $pathToImg, 'email'=> $email, 'subject' => $subject), 
                function ($message) use ($subject, $email, $fromWho) {
                    $message->from('no-reply@timebox24.com', $subject);
                    $message->to($email)->subject($subject);
                });
        }

        return redirect()->route('director_newsletter');
    }


    //ajax запрос email админов для автодополнения
    public function getAdminsEmail(Request $request)
    {
        $q = $request->q;

        $admins = Admin::where('email', 'like', "%$q%")
            ->where(['status' => 'active', 'email_send' => 1])
            ->select(['id', 'email as name'])->get();
        
        return $admins;
    }

}
