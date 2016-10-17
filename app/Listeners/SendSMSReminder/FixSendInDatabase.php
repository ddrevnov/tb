<?php

namespace App\Listeners\SendSMSReminder;

use App\Events\SendSMSReminder;

class FixSendInDatabase
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
     * @param  SendSMSReminder  $event
     * @return void
     */
    public function handle(SendSMSReminder $event)
    {
	    $sms_length = ceil(strlen($event->sms_body) / 140);
	    $event->admin->smsData()->decrement('count', $sms_length);
	    $event->admin->smsData()->increment('sent', $sms_length);
	    $event->admin->smsJournal()->create([
		    'title'     => $event->sms_title,
		    'body'      => $event->sms_body,
		    'client_id' => $event->cart->client_id,
	    ]);
    }
}
