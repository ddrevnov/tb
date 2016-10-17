<?php

namespace App\Http\Controllers\Client;

use App\Firm;
use App\Admin;
use App\WorkTime;

class ClientContactsController extends ClientController
{
    public function kontact()
    {
        $this->data['firm_details'] = Firm::getFirmDetails($this->firmLink);
        $this->data['admin_details'] = Admin::getActiveAdminInfo($this->adminId);
        $this->data['firmShedule'] = WorkTime::getFirmShedule($this->firmLink);
        $this->data['days'] = [trans('common.monday'), trans('common.thursday'),trans('common.wednesday'),
            trans('common.tuesday'),trans('common.friday'),trans('common.saturday'),trans('common.sunday')];

        return view('users.kontact', $this->data);
    }
}
