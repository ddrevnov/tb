<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AdminCalendarConfigController extends AdminController
{
	/**
	 * Page with calendar configs
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function config()
    {
        $this->data['config'] = $this->admin->calendarConfig;

        return view('admin.calendar_config', $this->data);
    }

	/**
	 * Get calendar config for edit
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getConfig()
    {
        return response()->json($this->admin->calendarConfig);
    }

	/**
	 * Set calendar config for admin
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function setConfig(Request $request)
    {
	    $this->admin->calendarConfig()->update($request->all());

        return response()->json(true);
    }
}
