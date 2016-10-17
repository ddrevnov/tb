<?php

namespace App\Listeners;

use App\Events\ConfirmBill;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmSMSBill
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
	    if ($event->order->orderSMS()->count()){
		    if(!$event->admin->smsData()->count()){
			    $event->admin->smsData()->create([$event->order->orderSMS]);
		    }

		    $event->admin->smsData()->increment('count', $event->order->orderSMS->count);
		    $event->order->update(['status' => 'paid', 'paid_at' => $event->today]);
	    }
    }
}
