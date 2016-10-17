<?php

namespace App\Http\Middleware;

use App\Client;
use App\Avatar;
use Closure;
use App\Admin;
use Illuminate\Support\Facades\App;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $firmLink;

    public function handle($request, Closure $next)
    {
        $this->firmLink = explode('.', $_SERVER['HTTP_HOST']);
        $this->firmLink = array_shift($this->firmLink);
        if(!Admin::where('firmlink', $this->firmLink)->first()){
            return redirect('http://'.env('MAIN_DOMAIN') . '/404');
        }

        $admin_status = Admin::where('firmlink', $this->firmLink)->first()->status;

        if ($admin_status != 'active'){
            die('Sorry this salon not working');
        }

        if($request->user()){
            if($request->user()->status == 'user'){
                $user = $request->user();
                App::setLocale($user->locale);
                $request->session()->put('locale', $user->locale);
                $client = Client::where('user_id',$user->id)->first();
                if($client){
                    view()->share('client', $client);
                    $avatar = Avatar::where('user_id',$user->id)->first();
                    view()->share('avatar', $avatar);
                }
            }
        }else{
            if (\Session::has('locale')){
                App::setLocale($request->session()->get('locale'));
            }
        }
        return $next($request);
    }
}
