<?php

namespace App\Listeners\SendSMSReminder;

use App\Events\SendSMSReminder;
use Bjrnblm\Messagebird\Facades\Messagebird;

class SendSMS
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
	    Messagebird::createMessage($event->sms_title, array($event->cart->client->mobile), $event->sms_body);
    }
}
