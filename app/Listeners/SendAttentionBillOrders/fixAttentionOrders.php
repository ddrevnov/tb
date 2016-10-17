<?php

namespace App\Listeners\SendAttentionBillOrders;

use App\AdminNotice;
use App\DirectorNotice;
use App\Events\SendAttentionBillOrders;
use App\Order;

class fixAttentionOrders
{
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
	 * @param  SendAttentionBillOrders $event
	 *
	 * @return void
	 */
	public function handle(SendAttentionBillOrders $event)
	{
		/** @var Order $order */
		foreach ($event->orders as $order) {
			DirectorNotice::create(['admin_id' => $order->admin_id, 'notice_type' => 'unpaid_order']);
			AdminNotice::create(['admin_id' => $order->admin_id, 'notice_type' => 'unpaid_order']);
			$order->update(['status' => 'attention']);
		}
	}
}
