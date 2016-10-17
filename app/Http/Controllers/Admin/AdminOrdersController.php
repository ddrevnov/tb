<?php

namespace App\Http\Controllers\Admin;

use App\Calendar;

class AdminOrdersController extends AdminController
{
	/**
	 * Order list
	 *
	 * @param $domain
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function ordersList($domain)
    {
        $this->data['calendarData'] = Calendar::getCalendarOrders($domain);

        return view('admin.orders_list', $this->data);
    }
}
