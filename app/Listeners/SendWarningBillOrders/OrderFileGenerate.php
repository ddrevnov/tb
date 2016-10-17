<?php

namespace App\Listeners\SendWarningBillOrders;

use App\Events\SendWarningBillOrders;
use App\Order;
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
     * @param  SendWarningBillOrders  $event
     * @return void
     */
    public function handle(SendWarningBillOrders $event)
    {
	    /** @var Order $order */
	    foreach ($event->orders as $order) {
		    $order['pdf'] = $this->dataOrderGenerate($order);
		    $order['order_name'] = $this->nameOrderGenerate($order);
	    }
    }
}
