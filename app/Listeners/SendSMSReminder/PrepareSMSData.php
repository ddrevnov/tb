<?php

namespace App\Listeners\SendSMSReminder;

use App\Events\SendSMSReminder;

class PrepareSMSData
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
    	$event->sms_title = $event->admin->smsData->title ?: $event->admin->firmlink;
	    $event->sms_body = $this->replaceSMSBody($event->admin->smsData->body, $event->cart->client,
		                                        $event->cart->employee, $event->cart->admin->firm,
		                                        $event->cart->service, $event->cart);
    }

	private function replaceSMSBody($body, $client, $employee, $firm, $service, $cart)
	{
		$replacement = [
			'[FIRST_NAME]' => $client->first_name,
			'[LAST_NAME]'  => $client->last_name,
			'[FROM]'  => $cart->time_from,
			'[TO]'  => $cart->time_to,
			'[DATE]'  => $cart->date,
			'[COUNTRY]'  => $firm->countryInfo->name,
			'[CITY]'  => $firm->cityInfo->name,
			'[STREET]'  => $firm->street,
			'[FIRM_TELNUMBER]'  => $firm->firm_telnumber,
			'[E_FIRST_NAME]'  => $employee->name,
			'[E_LAST_NAME]'  => $employee->last_name,
			'[SERVICE_TITLE]'  => $service->service_name,
			'[SERVICE_PRICE]'  => $service->price,
		];

		return strtr($body, $replacement);
	}
}
