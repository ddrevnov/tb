<?php

namespace App\Listeners\SendBlockBillOrders;

use App\Events\SendBlockBillOrders;
use App\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use PDF;

class SendEmail
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
	    foreach ($event->orders as $order){
		    $locale = $order->admin->user->locale;
		    $pdf = PDF::loadView('pdf.order', $order['pdf']);
		    $order_name = $order['order_name'];
		    $email = $order->admin->email;

		    Mail::send('emails.warning_order',
			    array('firstname' => $order->admin->firstname, 'locale' => $locale), function ($message) use ($email, $pdf, $order_name) {
				    $message->from('no-reply@timebox24.com');
				    $message->to($email)->subject('Blocked order');
				    $message->attachData($pdf->output(), $order_name);
			    });
	    }
    }
}
