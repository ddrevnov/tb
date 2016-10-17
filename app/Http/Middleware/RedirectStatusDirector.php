<?php

namespace App\Http\Middleware;

use App\DirectorEmployee;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Avatar;

class RedirectStatusDirector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
          // if($_SERVER['HTTP_HOST'] != env('MAIN_DOMAIN')){
          //     Auth::logout();
          //     return redirect('http://' . env('MAIN_DOMAIN') . '/backend');
          // }

        $employeeLinks = ['backend/admins','backend/messages','backend/employees','backend/settings1','backend/clients'];
        if($request -> user() -> status == 'director') {
            $userId = Auth::id();

            $avatar = Avatar::getAvatar($userId);
            if($avatar){
                view()->share('avatar', $avatar);
            }
            return $next($request);
        }elseif($request->user()->status == 'director_employee'){
            $employee = DirectorEmployee::where('email',Auth::user()->email)->first();
            $userId = Auth::id();

            $avatar = Avatar::getAvatar($userId);
            if($avatar){
                view()->share('avatar', $avatar);
            }
             if($employee->status != "active"){
                 Auth::logout();
                 return 'Sorry you are not active employee. Please contact to your director';
             }
            return $next($request);
            /*if($employee->group == 'admin'){
                return $next($request);
            }
            if(in_array($request->path(),$employeeLinks)){
                return $next($request);
            }else{
                return redirect('backend/admins');
            }*/
        }
        return 'Sorry! You can not come here!';
    }

    private function checkStatus()
    {
        if(isset(Auth::user() -> status)){
            if(Auth::user() -> status == 'director') {
                return redirect() -> route('login');
            } elseif(Auth::user() -> status == 'admin'){
                return redirect() -> route('login');
            } else {
                return redirect() -> guest('login');
            }
        }
        return redirect() -> guest('login');
    }



}
