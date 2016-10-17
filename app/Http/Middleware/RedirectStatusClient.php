<?php

namespace App\Http\Middleware;

use Closure;

class RedirectStatusClient
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
        if($request->user()){
            if($request->user() -> status == 'user') {
                return $next($request);
            }
        }
        return redirect(url('/').'/client');
    }
}
