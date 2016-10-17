<?php

namespace App\Http\Controllers\Client;

use App\Firm;

class ClientAboutController extends ClientController
{
	/**
	 * Page with admin about us text
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function about()
    {
        $this->data['about_us'] = Firm::where('firmlink', $this->firmLink)->first()->about_us;

        return view('users.about', $this->data);
    }
}
