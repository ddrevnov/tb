<?php

namespace App\Listeners\SendWarningBillOrders;

use App\AdminNotice;
use App\DirectorNotice;
use App\Events\SendWarningBillOrders;
use App\Order;

class fixWarningOrders
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
     * @param  SendWarningBillOrders  $event
     * @return void
     */
    public function handle(SendWarningBillOrders $event)
    {
	    /** @var Order $order */
	    foreach ($event->orders as $order) {
		    DirectorNotice::create(['admin_id' => $order->admin_id, 'notice_type' => 'unpaid_order']);
		    AdminNotice::create(['admin_id' => $order->admin_id, 'notice_type' => 'unpaid_order']);
		    $order->update(['status' => 'warning']);
	    }
    }
}
