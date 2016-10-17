<?php

namespace App\Listeners\NewOrder;

use App\Calendar;
use App\Events\NewOrder;
use App\User;
use Mail;

class SendConfirmationEmail
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
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
	    $data = Calendar::getInfoForConfirmEmail($event->cartId, $event->domain)->toArray();
	    $data['path'] = public_path() . $data['path'];
	    $data['locale'] = $locale = User::find($event->client->user_id)->locale;
	    $subject = trans('emails.create', [], $locale);

	    $client = $event->client;
	    $domain = $event->domain;

	    Mail::send('emails.confirm_order',
		    $data,
		    function ($message)
		    use ($client, $domain, $subject) {
			    $message->from($domain . '@timebox24.com', $domain);
			    $message->to($client->email)->subject($subject);
		    });

    }
}
