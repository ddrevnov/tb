<?php

namespace App\Listeners\SendBlockBillOrders;

use App\Events\SendBlockBillOrders;
use App\Order;
use App\Traits\OrderToPdfTrait;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  SendBlockBillOrders  $event
     * @return void
     */
    public function handle(SendBlockBillOrders $event)
    {
	    /** @var Order $order */
	    foreach ($event->orders as $order) {
		    $order['pdf'] = $this->dataOrderGenerate($order);
		    $order['order_name'] = $this->nameOrderGenerate($order);
	    }
    }
}
