<?php

namespace App\Http\Controllers\Client;

use App\User;
use Illuminate\Http\Request;
use App\Admin;
use App\Image;
use App\Slider;
use Illuminate\Support\Facades\Auth;
use App\Client;

class ClientController extends \App\Http\Controllers\Controller
{
    public $firmLink;
    public $adminId;
    public $data = array();
    public $userId;
    public $clientId;

    public function __construct(Request $request)
    {
        if (Auth::check()){
            $user = User::find(Auth::id());
            if ($user->status === 'user'){
                $this->userId = Auth::id();
                $this->clientId = Client::where('user_id', $this->userId)->first()->id;
            }
        }

        $this->firmLink = explode('.', $_SERVER['HTTP_HOST'])[0];
        $this->adminId = Admin::where('firmlink', $this->firmLink)->first()->id;;
        $this->data['firm_logo'] = Image::where('admin_id', $this->adminId)->first();
        $this->data['sliders'] = Slider::where(['admin_id' => $this->adminId, 'slide_status' => 1])->get();
        $this->data['locale'] = $request->session()->get('locale');
    }

    public function index()
    {
        return view('users.login', $this->data);
    }

    public function setLocale(Request $request)
    {
        if (Auth::check()){
            $user = User::find(Auth::id());
            $user->locale = $request->loc;
            $user->save();
            return redirect()->back();
        }else{
            \Session::put('locale', $request->loc);
            \Session::save();
        }
        return redirect()->back();
    }
}
