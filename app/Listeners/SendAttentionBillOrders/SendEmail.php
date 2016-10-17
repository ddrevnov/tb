<?php

namespace App\Listeners\SendAttentionBillOrders;

use App\Events\SendAttentionBillOrders;
use App\Order;
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
     * @param  SendAttentionBillOrders  $event
     * @return void
     */
    public function handle(SendAttentionBillOrders $event)
    {
	    /** @var Order $order */
	    foreach ($event->orders as $order){
		    $locale = $order->admin->user->locale;
		    $pdf = PDF::loadView('pdf.order', $order['pdf']);
		    $order_name = $order['order_name'];
		    $email = $order->admin->email;

		    Mail::send('emails.attention_order',
			    array('firstname' => $order->admin->firstname, 'locale' => $locale), function ($message) use ($email, $pdf, $order_name) {
				    $message->from('no-reply@timebox24.com');
				    $message->to($email)->subject('Attention order');
				    $message->attachData($pdf->output(), $order_name);
			    });
	    }
    }
}
