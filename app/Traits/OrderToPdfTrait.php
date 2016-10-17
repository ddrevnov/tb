<?php

namespace App\Traits;

use App\DirectorBankDetails;
use App\DirectorEmployee;
use App\Firm;
use App\TariffAdminJournal;
use Illuminate\Support\Facades\Request;

trait OrderToPdfTrait
{
	/**
	 * Generate data for order pdf file
	 *
	 * @param Request $request
	 */
	public function dataOrderGenerate($order)
	{
		$data['bank_details'] = DirectorBankDetails::find(1);
		$data['order_details'] = $order;
		$data['admin_details'] = $order->admin;
		$data['firm_details'] = $order->admin->firm;
		$data['director_details'] = DirectorEmployee::where('group', 'main')->first();
		$data['additional_employees'] = $order->orderEmployees;
		$data['final_sum'] = $order->price + $order->tax + $order->orderEmployees()->sum('price');

		return $data;
	}

	/**
	 * Generate right order name file
	 *
	 * @param $order
	 *
	 * @return string
	 */
	public function nameOrderGenerate($order)
	{
		return sprintf('T%05u', $order->id) . '_' . $order->created_at . '_Rechung.pdf';
	}
}