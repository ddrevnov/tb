<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreClient;
use App\ProtocolClient;
use DB;
use Illuminate\Http\Request;
use App\Client;
use App\Avatar;
use App\User;
use App\Admin;
use App\AdminsClients;
use Illuminate\Support\Facades\Auth;
use Mail;

class ClientProfilController extends ClientController
{
    public function settings()
    {
        $this->data['client'] = Client::where('user_id', $this->userId)->first();
        $this->data['avatar'] = Avatar::where('user_id', $this->userId)->first();
        return view('users.settings', $this->data);
    }

    public function registration()
    {
        return view('users.registration', $this->data);
    }

    public function checkEmail(Request $request)
    {
        $check = User::where('email', $request->email)->first() ? false : true;
        return json_encode($check);
    }

    public function store(StoreClient $request, $domain)
    {
        if (User::where('email', $request->email)->first()) {
            return redirect(url('/') . '/client/registration');
        }

        $data = $request->all();
        $password = str_random(8);

        DB::beginTransaction();
        try{
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $user = User::create(['name' => $data['first_name'], 'email' => $data['email'], 'password' => $passwordHash, 'status' => 'user']);
            $data['user_id'] = $user->id;
            $data['firmlink'] = $domain;
            $client = Client::create($data);

            $adminId = Admin::where('firmlink', $domain)->first()->id;
            AdminsClients::create(['client_id' => $client->id, 'admin_id' => $adminId]);

	        ProtocolClient::protocolClientCreate($adminId, $client->id, $request->first_name, 'client');

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

	        return redirect(url('/'));
        }

        Auth::attempt(['email' => $data['email'], 'password' => $password]);
        Mail::send('emails.welcome_client',
            ['password' => $password,
                'firstname' => $data['first_name'],
                'lastname' => $data['last_name'],
                'email' => $data['email'],
                'gender' => $data['gender'],
                'firmlink' => 'http://' . $_SERVER['HTTP_HOST'],
                'locale'    =>  session()->get('locale'),
            ],
            function ($message) use ($user, $client) {
                $message->to($user->email, $client->first_name . " " . $client->last_name)->subject('Registration succesfull');
            });

        return response()->json(["status" => true]);

    }

    public function check(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect(url('/') . '/client/settings');
        } else {
            return redirect(url('/') . '/client');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/') . '/client');
    }

    public function changeAvatar(Request $request)
    {
        Avatar::storeAvatar($this->userId, $request);
        return redirect(url('/') . '/client/settings');
    }

    public function update(Request $request)
    {
    	DB::beginTransaction();
	    try{
	    	ProtocolClient::protocolClientPersonalChange($this->adminId, $this->clientId,
			                                            array('first_name', 'last_name', 'telephone', 'mobile'), $request, 'client');

		    Client::find($this->clientId)->update($request->all());

	    	DB::commit();

		    return redirect(url('/') . '/client/settings');
	    }catch (\Exception $e){
	    	DB::rollBack();

		    return redirect(url('/') . '/client/settings');
	    }
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $user->password = password_hash($request->input('password'), PASSWORD_BCRYPT);
        $user->save();
        return redirect(url('/') . '/client/settings');
    }
}
