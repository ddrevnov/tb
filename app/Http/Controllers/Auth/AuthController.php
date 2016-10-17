<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error_code' => User::VALIDATION_ERROR]);
        }

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], 1)) {
            \Session::put('LAST_ACTIVITY', time());
            $userStatus = User::where('email', $data['email'])->first()->status;

            if($userStatus === 'director' || $userStatus === 'director_employee'){
                return response()->json(['check' => 1, 'url' => 'backend']);
            }else{
                return response()->json(['check' => 1, 'url' => 'office']);
            }
        }
        return '0';
    }

    public function forgotpass(Request $request)
    {
        $password = '';
        $email = $request->input('forgotpass');

       if($user = User::where('email', "=", $email)->first()) {
           $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
           $max = count($characters) - 1;
           for ($i = 0; $i < 8; $i++) {
               $rand = mt_rand(0, $max);
               $password .= $characters[$rand];
           }
           $passwordHash = password_hash($password, PASSWORD_BCRYPT);
           $user->update(['password' => $passwordHash]);
           $subject = \Lang::get('emails.restore_password', [], $user->locale);

           Mail::send('emails.forgotpass',
               ['password' => $password, 'locale' => $user->locale],
               function ($message) use ($user, $subject) {
               $message->from('no-reply@timebox24.com');
               $message->to($user->email)->subject($subject);
              
           });
            return response()->json(['1']);
       }else{
           return response()->json(['0']);
       }
    }
}
