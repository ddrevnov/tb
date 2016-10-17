<?php

namespace App\Http\Controllers\Admin\SMS;

use App\Country;
use App\Http\Controllers\Admin\AdminController;
use App\Order;
use App\SMSPackage;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class AdminSMSController extends AdminController
{
	const ORDER_TAX = 0.19;

	/**
	 * Index page with all sms packages
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		if (!$this->admin->smsData) {
			$this->admin->smsData()->create(['title' => $this->admin->firmlink]);
		}

		$this->data['sms_data']['sms_packages'] = SMSPackage::all();
		$this->data['sms_data']['bank_details'] = $this->admin->bankDetails;
		$this->data['sms_data']['sms_data'] = $this->admin->smsData;
		$this->data['sms_data']['orders'] = $this->admin->orders()->with('orderSMS')->has('orderSMS')->get();

		$this->data['countries'] = Country::all();

		return view('admin.sms.index', $this->data);
	}

	/**
	 * Buy sms package or sms calculate
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function buy(Request $request)
	{
		\DB::beginTransaction();
		try {
			$sms_package = isset($request->sms_package['id'])
				? SMSPackage::find($request->sms_package['id'])->toArray()
				: $request->sms_package;

			$sms_package['tax'] = $sms_package['price'] * self::ORDER_TAX;

			$order = $this->admin->orders()->create($sms_package);
			$order->orderSMS()->create($sms_package);
			$this->admin->bankDetails()->update($request->bank_details);

			\DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			\DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Change admin notify for how count sms
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function changeNotify(Request $request)
	{
		$data = $request->only(['is_notify', 'notify_type', 'sms_balance_notify']);
		$this->admin->smsData()->update($data);

		return response()->json(true);
	}

	/**
	 * Filter sms orders by date
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function filterOrders(Request $request)
	{
		$start_date = new DateTime($request->from);
		$end_date = (new DateTime($request->to))->add(new DateInterval('P1D'));

		$orders = Order::with('orderSMS')->whereHas('orderSMS', function ($query) use ($start_date, $end_date) {
			$query->whereBetween('created_at', [$start_date, $end_date]);
		})->get();

		return response()->json($orders);
	}

	/**
	 * Save sms content for individual sms data
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveSMSContent(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:11|regex:/(^[A-Za-z0-9]+$)+/',
			'body'  => 'required|max:1300',
		]);

		$data = $request->only(['title', 'body']);
		$this->admin->smsData()->update($data);

		return response()->json(true);
	}

	/**
	 * Show sms statistic in graph
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showSMSStatistic(Request $request)
	{
		if ($request->period === 'week') {
			$from = date('Y-m-d', strtotime('last Monday', time()));
			$to = date('Y-m-d', strtotime('Sunday', time()));
		} elseif ($request->period === 'month') {
			$from = date('Y-m-d', strtotime('first day of this month', time()));
			$to = date('Y-m-d', strtotime('last day of this month', time()));
		} else {
			$from = $this->admin->smsJournal->first()->created_at->format('Y-m-d');
			$to = (new \DateTime())->format('Y-m-d');
		}

		$i = 1;
		$journal = ['sms'];
		while ($from <= $to) {
			$journal[$i] = $this->admin->smsJournal()->whereDate('created_at', '=', $from)->count();
			$i++;
			$from = date('Y-m-d', strtotime($from . '+1 day'));
		}

		return response()->json($journal);
	}
}
