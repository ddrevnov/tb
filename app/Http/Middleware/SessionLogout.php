<?php

namespace App\Http\Middleware;

use Closure;

class SessionLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Session::has('LAST_ACTIVITY') && (time() - \Session::get('LAST_ACTIVITY') > 600 )) {
            \Session::forget('LAST_ACTIVITY');
            \Auth::logout();
            return redirect()->back();
        }else{
            \Session::put('LAST_ACTIVITY', time());

            return $next($request);
        }
    }
}
