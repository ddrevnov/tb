<?php

namespace App\Http\Controllers;

use App\Admin;
use App\DirectorNotice;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller {

    public static function register($request)
    {
        $email = $request->email;
        $newAdmin = $request->all();
        \DB::transaction(function () use ($newAdmin){
            $newAdmin = Admin::create($newAdmin);
            DirectorNotice::create(['admin_id' => $newAdmin->id, 'notice_type' => 'new_registration']);
        });

        Mail::send('emails.register', 
            [
                'firstname' => $request->firstname,
                'gender' => $request->gender,
                'locale'    =>  'de',
            ], 
            function($message) use ($email) {
            $message->to($email)->subject('Vielen Dank für Ihre Registrierung!');
            $message->from('no-reply@timebox24.com');
        });
    }

    public static function check(Request $request)
    {
        //запрос идет с сайта wp, который фактически является другим сайтом и срабатывает кросс-доменная защита браузеров
        //чтобы её обойти используется следующий код
        if (isset($_SERVER['HTTP_ORIGIN']))
        {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            header('Access-Control-Allow-Credentials: true');
        }
        else
        {
            header('Access-Control-Allow-Origin: *');
        }

        $validator = \Validator::make($request->all(), [
            'firstname'   =>  'required|string',
            'lastname'  =>  'required|string',
            'email'     =>  'required|email',
            'firmlink'  =>  'required|regex:/(^[A-Za-z0-9 ]+$)+/'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if(Admin::where('firmlink', $request->firmlink)->first()){
            if ($request->firmlink == 'www'){
                return response()->json(['status' => false, 'reason' => 'firmlink']);
            }
            return response()->json(['status' => false, 'reason' => 'firmlink']);
        }elseif(User::where('email', $request->email)->first()){
            return response()->json(['status' => false, 'reason' => 'email']);
        }else{
            self::register($request);
        }
        return response()->json(['status' => true]);
    }
}
