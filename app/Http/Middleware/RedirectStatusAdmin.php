<?php

namespace App\Http\Middleware;

use App\Employee;
use App\User;
use Closure;
use Illuminate\Http\Request;
use App\Avatar;
use Auth;
use App\Admin;
use Illuminate\Support\Facades\App;

class RedirectStatusAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {

	    /**
	     * Set user locale globally
	     */
	    /** @var User $user */
	    $user = $request->user();
        $locale = $user->locale;
        \App::setLocale($locale);

        if ($user->status === 'admin') {
            $admin = $user->admin;

//	        if ($admin->tariffJournal->type === 'free'){
//				$today = date('Y-m-d');
//		        $created_day = date('Y-m-d', strtotime("+1 months", strtotime($admin->tariffJournal->created_at)));
//
//		        if ($created_day < $today && $request->path() !== 'office/tariff'){
//		        	return redirect('/office/tariff');
//		        }
//	        }
	        /**
	         * check admin status for blocked or freeze
	         */
            if($admin->status === 'blocked'){
                Auth::logout();
                return 'Sorry you are blocked. You must pay';
            }elseif ($admin->status === 'freeze'){
                Auth::logout();
                return 'Sorry you are freeze. Contact to director';
            }
	        /**
	         * check if current subdomain is own for admin
	         */
            if($admin->firmlink != $request->subdomain){
                Auth::logout();
                return 'Sorry, its not your domain';
            }
	        /**
	         * share admin avatar
	         */
            $avatar = $user->avatar;
            if($avatar){
                view()->share('avatar', $avatar);
            }
            return $next($request);
           /**
            * rules for admin employee
            */
        }elseif($user->status === 'admin_employee'){
            $employee = $user->employee;
            $admin = $user->employee->admin;

	        /**
	         * check
	         */
            if($admin->status === 'blocked'){
                Auth::logout();
                return 'Sorry your admin is blocked. Please contact to him';
            }elseif ($admin->status === 'freeze'){
                Auth::logout();
                return 'Sorry your admin freeze. Please contact to him';
            }

	        /**
	         * check if subdomain is owner for admin of current employee
	         */
            if($admin->firmlink != $request->subdomain){
                Auth::logout();
                return 'Sorry, its not your domain';
            }

	        /**
	         * check employee status
	         */
            if($employee->status !== "active"){
                Auth::logout();
                return 'Sorry, you are not active employee. Contact to your admin';
            }

	        /**
	         * share employee status
	         */
            $avatar = $user->avatar;
            if($avatar){
                view()->share('avatar', $avatar);
            }

            return $next($request);
        }
        Auth::logout();
	    return redirect()->back();
    }
}
