<?php

namespace App\Http\Controllers\Client;

use App\Calendar;
use App\Client;
use App\Employee;
use App\EmployeeService;
use App\Events\NewOrder;
use App\Firm;
use App\Services;
use App\ServicesCategory;
use App\WorkTime;
use Auth;
use Illuminate\Http\Request;


class ClientBookingController extends ClientController
{
	/**
	 * Const how minutes has step in check employee
	 */
	const BLOCK_INTERVAL_MINUTES = 15;

	/**
	 * Booking page
	 *
	 * @param $domain
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function booking($domain)
	{
		$this->data['categoryList'] = ServicesCategory::getActiveServicesCategoryList($this->adminId);
		$this->data['servicesList'] = Services::getActiveServicesList($this->adminId);
		$this->data['employees'] = Employee::getEmployeesActive($this->adminId);
		$this->data['firm_details'] = Firm::where('firmlink', $domain)->first();

		return view('users.booking', $this->data);
	}

	/**
	 * Get employees for choose service
	 *
	 * @param Request $request
	 *
	 * @return mixed|string|void
	 */
	public function getEmployees(Request $request)
	{
		$result = EmployeeService::getEmployees($request->service_id);

		return json_encode($result);
	}

	/**
	 * Get firm work times for generate right calendar
	 *
	 * @param Request $request
	 * @param         $domain
	 *
	 * @return mixed|string|void
	 */
	public function getWorkTimes($domain)
	{
		$result = WorkTime::where('firmlink', $domain)->select(['from', 'to', 'index_day'])->get();

		return json_encode($result);
	}

	/**
	 * Check employee for free to order
	 *
	 * @param Request  $request
	 * @param          $domain
	 * @param Calendar $calendar
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkEmployee(Request $request, $domain, Calendar $calendar)
	{
		$result = array();
		$service_id = $request->service_id;

		$index_day = date('N', \DateTime::createFromFormat('d/m/Y', $request->date)->getTimestamp()) - 1;
		$work_times = WorkTime::where(['firmlink' => $domain, 'index_day' => $index_day])->select('from', 'to')->first();
		$service_duration = Services::find($service_id)->duration;

		$calendarInfo = $calendar->checkTime($domain, array($request->date), $request->id);
		$from = \DateTime::createFromFormat('H:i:s', $work_times->from);
		$to = \DateTime::createFromFormat('H:i:s', $work_times->to)->modify("- $service_duration minutes");

		if ($calendarInfo->isEmpty()) {

			while ($from < $to) {
				$result[] = $from->format('H:i');
				$from->modify('+ ' . self::BLOCK_INTERVAL_MINUTES . ' minutes');
			}

			return response()->json($result);
		} else {

			while ($from <= $to) {

				foreach ($calendarInfo as $info) {
					$calendar_from = \DateTime::createFromFormat('H:i', $info->time_from);
					$calendar_to = \DateTime::createFromFormat('H:i', $info->time_to);

					$to2 = clone $from;
					$to2->modify("+ $service_duration minutes");

					if (($from >= $calendar_from && $from < $calendar_from) || ($from < $calendar_from && $to2 > $calendar_to)) {
						$from->modify('+ ' . (self::BLOCK_INTERVAL_MINUTES + $service_duration) . ' minutes');
						break;
					} else {
						if (($to2 > $calendar_from && $to2 <= $calendar_to) || ($from > $calendar_from && $to2 < $calendar_to)) {
							$from->modify('+ ' . (self::BLOCK_INTERVAL_MINUTES + $service_duration) . ' minutes');
							break;
						}
					}
				}
				$result[] = $from->format('H:i');
				$from->modify('+ ' . self::BLOCK_INTERVAL_MINUTES . ' minutes');
			}

			return response()->json($result);
		}
	}

	/**
	 * Confirm new order for client
	 *
	 * @param Request $request
	 * @param         $domain
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function newOrder(Request $request, $domain)
	{
		$client = Client::where('user_id', Auth::id())->first();

		\DB::beginTransaction();
		try{
			event(new NewOrder($request, $client, $domain, $this->adminId));

			\DB::commit();
			return response()->json(true);
		}catch (\Exception $e){
			\DB::rollBack();

			return response()->json(false);
		}
	}
}
