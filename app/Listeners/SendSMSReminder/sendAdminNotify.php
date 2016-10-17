<?php

namespace App\Listeners\SendSMSReminder;

use App\Events\SendSMSReminder;
use Bjrnblm\Messagebird\Facades\Messagebird;
use Illuminate\Support\Facades\Mail;

class sendAdminNotify
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
    	$sms_data = $event->admin->smsData;
        if ($sms_data->count == $sms_data->sms_balance_notify + 1){
			if ($sms_data->notify_type === 'email'){
				$this->emailNotify($event->admin);
			}elseif ($sms_data->notify_type === 'sms'){
				$this->smsNotify($event->admin);
			}else{
				$this->smsNotify($event->admin);
				$this->emailNotify($event->admin);
			}
        }
    }

    private function emailNotify($admin)
    {
    	$email = $admin->email;
	    Mail::send('emails.sms_balance_notify', array(),
		    function ($message) use($email){
			    $message->from('no-reply@timebox24.com', 'SMS notify balance');
			    $message->to($email)->subject('SMS notify balance');
		    });
    }

    private function smsNotify($admin)
    {
    	$mobile = $admin->mobile;
	    Messagebird::createMessage('timebox', array($mobile), 'sms balance notify');
    }
}
