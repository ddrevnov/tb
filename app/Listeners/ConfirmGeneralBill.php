<?php

namespace App\Listeners;

use App\Events\ConfirmBill;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmGeneralBill
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
     * @param  ConfirmBill  $event
     * @return void
     */
    public function handle(ConfirmBill $event)
    {
	    if (!$event->order->orderSMS()->count()){
		    if ($event->order->status == 'cancel') {
			    $event->order->update(['status' => 'paid', 'paid_at' => $event->today]);
		    } else {
			    $event->order->update(['status' => 'paid', 'paid_at' => $event->today]);
			    $event->admin->update(['status' => 'active']);
		    }
	    }
    }
}
