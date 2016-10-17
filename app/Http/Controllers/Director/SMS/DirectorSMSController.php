<?php

namespace App\Http\Controllers\Director\SMS;

use App\AdminSMSData;
use App\Http\Controllers\Director\DirectorController;
use App\Order;
use App\SMSJournal;
use App\SMSPackage;
use App\Http\Requests;
use Illuminate\Http\Request;
use Bjrnblm\Messagebird\Facades\Messagebird;

class DirectorSMSController extends DirectorController
{
	/**
	 * list of all sms packages
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$this->data['data']['sms_packages'] = SMSPackage::all();
		$this->data['data']['balance'] = Messagebird::getBalance();
		$this->data['data']['current_month'] = SMSJournal::where(\DB::raw('MONTH(created_at)'), date('m'))->count();
		$this->data['data']['last_month'] = SMSJournal::where(\DB::raw('MONTH(created_at)'), date('m', strtotime('-1 months')))->count();
		$this->data['data']['today'] = SMSJournal::where(\DB::raw('DAY(created_at)'), date('d'))->count();
		$this->data['data']['yesterday'] = SMSJournal::where(\DB::raw('DAY(created_at)'), date('d', strtotime('yesterday')))->count();
		$this->data['data']['sms_count'] = (int)AdminSMSData::sum('count');
		$this->data['data']['paid_orders'] = Order::has('orderSMS')->where('status', 'paid')->count();
		$this->data['data']['unpaid_orders'] = Order::has('orderSMS')->where('status', '!=', 'paid')->count();

		return view('director.sms.index', $this->data);
	}

	/**
	 * Store new sms package
	 *
	 * @param Requests\CreateOrUpdateSMSPackage $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Requests\CreateOrUpdateSMSPackage $request)
	{
		SMSPackage::create($request->all());

		return redirect('/backend/sms');
	}

	/**
	 * Edit current sms package
	 *
	 * @param SMSPackage                        $package
	 * @param Requests\CreateOrUpdateSMSPackage $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function edit(SMSPackage $package, Requests\CreateOrUpdateSMSPackage $request)
	{
		$package->update($request->all());

		return redirect()->back();
	}

	/**
	 * Delete sms package
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function delete(SMSPackage $package)
	{
		$package->delete();

		return redirect()->back();
	}

	public function showSMSStatistic(Request $request)
	{
		if ($request->period === 'week') {
			$from = date('Y-m-d', strtotime('last Monday', time()));
			$to = date('Y-m-d', strtotime('Sunday', time()));
		} elseif ($request->period === 'month') {
			$from = date('Y-m-d', strtotime('first day of this month', time()));
			$to = date('Y-m-d', strtotime('last day of this month', time()));
		} else {
			$from = SMSJournal::first()->created_at->format('Y-m-d');
			$to = (new \DateTime())->format('Y-m-d');
		}

		$i = 1;
		$journal = ['sms'];
		while ($from <= $to) {
			$journal[$i] = SMSJournal::whereDate('created_at', '=', $from)->count();
			$i++;
			$from = date('Y-m-d', strtotime($from . '+1 day'));
		}

		return response()->json($journal);
	}
}
