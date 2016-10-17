<?php

namespace App\Listeners\NewOrder;

use App\Calendar;
use App\Events\NewOrder;
use App\Services;

class CreateCalendarCart
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
	 * @param  NewOrder $event
	 *
	 * @return void
	 */
	public function handle(NewOrder $event)
	{
		$duration = Services::find($event->order_data->service_id)->duration;
		$time_end = \DateTime::createFromFormat('H:i', $event->order_data->time_start)->modify("+ $duration minutes")->format('H:i');

		$orderByClient = [
			'domain'      => $event->domain,
			'color'       => '#0F0F0F',
			'description' => 'ORDER FROM SITE',
			'time_from'   => $event->order_data->time_start,
			'time_to'     => $time_end,
			'date'        => $event->order_data->date,
			'employee_id' => $event->order_data->employee_id,
			'service_id'  => $event->order_data->service_id,
			'client_id'   => $event->client->id,
			'status'      => 'active',
			'site'        => 1,
			'sms'         => $event->order_data->sms,
			'email'       => $event->order_data->email,
		];

		$cart = Calendar::create($orderByClient);
		$event->cartId = $cart->id;
	}
}
