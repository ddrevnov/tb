<?php

namespace App\Listeners\SendBillOrders;

use App\Events\SendBillOrders;

class CreateNewOrders
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
     * @param  SendBillOrders  $event
     * @return void
     */
    public function handle(SendBillOrders $event)
    {
    	foreach ($event->admins as $admin){
    		$order['employee_count'] = $admin->employees()->count();
		    $order['price'] = $event::ORDER_FIX_RATE + $event::ORDER_PER_EMPLOYEE_RATE * $order['employee_count'];
		    $order['tax']   = $order['price'] * $event::ORDER_TAX;

		    $admin['order'] = $admin->orders()->create($order);

		    $admin->orderEmployees()
			        ->whereMonth('created_at', '=', $event->last_month)
			        ->update(['order_id' => $admin['order']['id']]);
	    }
    }
}
