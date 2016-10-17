<?php

namespace App\Listeners\SendBillOrders;

use App\Events\SendBillOrders;
use App\Traits\OrderToPdfTrait;

class OrderFileGenerate
{
	use OrderToPdfTrait;
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  SendBillOrders $event
	 *
	 * @return void
	 */
	public function handle(SendBillOrders $event)
	{
		foreach ($event->admins as $admin) {
			$admin['pdf'] = $this->dataOrderGenerate($admin['order']);
			$admin['order_name'] = $this->nameOrderGenerate($admin['order']);
		}
	}
}
