<?php

namespace App\Listeners\SendBlockBillOrders;

use App\DirectorNotice;
use App\Events\SendBlockBillOrders;
use App\Order;

class fixBlockOrders
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
     * @param  SendBlockBillOrders  $event
     * @return void
     */
    public function handle(SendBlockBillOrders $event)
    {
	    /** @var Order $order */
	    foreach ($event->orders as $order) {
		    DirectorNotice::create(['admin_id' => $order->admin_id, 'notice_type' => 'admin_blocked']);
		    $order->admin->update(['status' => 'blocked']);
	    }
    }
}
