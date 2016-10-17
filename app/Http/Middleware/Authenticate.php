<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @param  string|null              $guard
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{

		if (preg_match('/backend\/?/', $request->path())) {
			if ($_SERVER['HTTP_HOST'] != env('MAIN_DOMAIN')) {
				Auth::logout();

				return redirect('http://' . env('MAIN_DOMAIN') . '/backend');
			}
		}

		if (Auth::guard($guard)->guest()) {
			if ($request->ajax() || $request->wantsJson()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->guest('login');
			}
		}

		return $next($request);
	}
}
