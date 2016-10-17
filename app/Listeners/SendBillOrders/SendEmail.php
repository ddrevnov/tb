<?php

namespace App\Listeners\SendBillOrders;

use App\AdminNotice;
use App\Events\SendBillOrders;
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
     * @param  SendBillOrders  $event
     * @return void
     */
    public function handle(SendBillOrders $event)
    {
        foreach ($event->admins as $admin){
	        $locale = $admin->user->locale;
	        AdminNotice::create(['notice_type' => 'new_bill', 'admin_id' => $admin->id]);
	        $pdf = PDF::loadView('pdf.order', $admin['pdf']);
	        $order_name = $admin['order_name'];
	        $email = $admin['email'];

	        Mail::send('emails.new_order',
		        array('firstname' => $admin->firstname, 'locale' => $locale), function ($message) use ($email, $pdf, $order_name) {
			        $message->from('no-reply@timebox24.com');
			        $message->to($email)->subject('Ihre Rechnung www.timebox24.com');
			        $message->attachData($pdf->output(), $order_name);
		        });
        }
    }
}
