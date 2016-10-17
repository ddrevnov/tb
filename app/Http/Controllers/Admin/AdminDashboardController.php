<?php

namespace App\Http\Controllers\Admin;

use App\AdminMail;
use App\Services;
use App\TariffAdminJournal;
use Illuminate\Http\Request;
use App\Calendar;

class AdminDashboardController extends AdminController
{
	/**
	 * Get all static parameters for dashboard
	 *
	 * @param Request $request
	 * @param         $domain
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getDashboard(Request $request, $domain)
	{
		/**
		 * Get all statistic or piece
		 */
		if (!$request->all()) {
			$to = (new \DateTime())->format('Y-m-d');
			$from = Calendar::where('domain', $domain)->first()->created_at->format('Y-m-d');
		} else {
			$to = (new \DateTime($request->to))->format('Y-m-d');
			$from = (new \DateTime($request->from))->format('Y-m-d');
		}

		$dashboard['first_data'] = $from;

		$dashboardOrders = Calendar::getDashboardOrders($domain, $from, $to);
		$goods = array_count_values(Calendar::getPopularGoods($domain, $from, $to));
		$popular_goods = array_keys(array_slice($goods, 0, 5, true));
		$dashboard['popular_goods'] = Services::whereIn('id', $popular_goods)->select('service_name')->get();

		//сбор всей статистики в необходимый для фронта формат
		$i = 0;
		while ($from <= $to) {
			$dashboard['subdomain_orders'][$i] = Calendar::where(['site' => 1, 'domain' => $domain])
				->whereDate('created_at', '=', $from)->count();
			$dashboard['calendar_orders'][$i] = Calendar::where(['site' => 0, 'domain' => $domain, 'status' => 'active'])
				->whereDate('created_at', '=', $from)->count();
			$dashboard['deleted_orders'][$i] = Calendar::where('domain', $domain)->whereNotNull('date_deleted')
				->whereDate('created_at', '=', $from)->count();

			$dashboard['orders_sum'][$i] = (int)Calendar::where('domain', $domain)
				->whereNull('calendar.date_deleted')
				->whereNotNull('calendar.service_id')
				->whereDate('calendar.created_at', '=', $from)
				->leftJoin('services', 'services.id', '=', 'calendar.service_id')
				->select('services.price')->sum('price');

			$dashboard['send_emails'][$i] = (int)AdminMail::where(['admin_id' => $this->idAdmin, 'send' => 1])
				->whereDate('created_at', '=', $from)->sum('count');
			$i++;
			$from = date('Y-m-d', strtotime($from . '+1 day'));
		}

		/**
		 * Sums of sales by employees
		 */
		$employee_sum = $dashboardOrders->groupBy('first_name')->toArray();

		/**
		 * Parse sums for right format for front
		 */
		foreach ($employee_sum as $name => $value) {
			foreach ($value as $val) {
				$val['price'] += $val['price'];
			}
			$result[] = $val;
		}
		$dashboard['employee_sum'] = isset($result) ? $result : null;

		return response()->json($dashboard);
	}
}
