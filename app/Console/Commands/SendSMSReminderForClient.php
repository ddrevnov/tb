<?php

namespace App\Console\Commands;

use App\Admin;
use App\Calendar;
use App\Events\SendSMSReminder;
use Bjrnblm\Messagebird\Facades\Messagebird;
use Illuminate\Console\Command;

class SendSMSReminderForClient extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sms:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send sms reminder for client';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$admins = Admin::whereHas('calendarConfig', function ($q) {
							$q->where('send_sms', '1');
						})->whereHas('smsData', function ($q) {
							$q->where('count', '!=', 0);
						})->where('status', 'active')->pluck('firmlink');

		$current_unix_time = strtotime(date('Y-m-d H:i'));
		$date = new \DateTime('today');

		$carts = Calendar::whereIn('domain', $admins)->where(['status' => 'active', 'sms' => 1])
			->where(function ($query) use ($date) {
				$query->where('date', $date->format('d/m/Y'))
					->orWhere('date', $date->add(new \DateInterval('P1D'))->format('d/m/Y'))
					->orWhere('date', $date->add(new \DateInterval('P1D'))->format('d/m/Y'));
			})->get();

		if ($carts) {
			foreach ($carts as $cart) {
				$admin = $cart->admin;
				$sms_length = ceil($admin->smsData->body % 140);
				$order_unix_time = \DateTime::createFromFormat('d/m/Y H:i', $cart->date . ' ' . $cart->time_from)->getTimestamp();

				if ($current_unix_time + $admin->calendarConfig->sms_reminder * 60 === $order_unix_time
					&& $admin->smsData->count >= $sms_length) {

					\DB::beginTransaction();
					try {
						event(new SendSMSReminder($admin, $cart));
						\DB::commit();
					} catch (\Exception $e) {
						\DB::rollBack();
						\Log::error($e->getMessage());
					}

				}
			}
		}

		return $this->info('Complete sms sending');
	}
}
