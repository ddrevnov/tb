<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;
use Auth;

class RedirectStartAssistant
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$admin = Admin::where('user_id', Auth::id())->first();
//		dd($admin->tariffJournal);
		if ($admin->tariffJournal === null) {
//			dd($_SERVER['REQUEST_URI']);
			if ($_SERVER['REQUEST_URI'] !== '/office/get_location') {
				return redirect('/office/start_assistant');
			}

//			return redirect('/office/start_assistant');
		}
//        if (!\App\TariffAdminJournal::where('admin_id', $admin->id)->first()){
//            if ($_SERVER['REQUEST_URI'] != '/office/get_location'){
//                return redirect('/office/start_assistant');
//            }
//        }

		return $next($request);
	}
}
