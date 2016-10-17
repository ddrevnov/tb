<?php

namespace App\Console;

use App\Calendar;
use App\Console\Commands\SendSMSReminderForClient;
use App\Events\SendAttentionBillOrders;
use App\Events\SendBillOrders;
use App\Events\SendBlockBillOrders;
use App\Events\SendWarningBillOrders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		Commands\Inspire::class,
		Commands\SendSMSReminderForClient::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 *
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function () {
			Calendar::reminderEmailForClient();

			$this->call('sms:send');
		})->cron('*/15 * * * * *');

		$schedule->call(function () {
			event(new SendBillOrders());
		})->monthly();

		$schedule->call(function (){
			event(new SendAttentionBillOrders());
		})->cron('* * * * 0/2');

		$schedule->call(function (){
			event(new SendWarningBillOrders());
		})->cron('* * 21 * *');

		$schedule->call(function (){
			event(new SendBlockBillOrders());
		})->monthly();
	}
}
