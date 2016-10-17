<?php

namespace App\Http\Controllers\Director\Admins;

use App\Http\Controllers\Director\DirectorController;
use App\Admin;

class DirectorAdminsController extends DirectorController
{
	/**
	 * All admins list
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function admins()
    {
        $this->data['admins'] = Admin::where('status', '!=', 'new')->paginate(15);
        $this->data['admins_new'] = Admin::where('status', 'new')->get();

        return view('director.admins', $this->data);
    }
}
