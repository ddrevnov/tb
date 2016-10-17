<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
	    \App\Events\ConfirmBill::class => [
		    \App\Listeners\ConfirmSMSBill::class,
		    \App\Listeners\ConfirmGeneralBill::class,
	    ],
	    \App\Events\NewOrder::class => [
		    \App\Listeners\NewOrder\LinkedClientToAdmin::class,
		    \App\Listeners\NewOrder\CreateCalendarCart::class,
		    \App\Listeners\NewOrder\WriteNoticeAndProtocol::class,
		    \App\Listeners\NewOrder\SendConfirmationEmail::class,
	    ],
	    \App\Events\SendSMSReminder::class => [
	        \App\Listeners\SendSMSReminder\PrepareSMSData::class,
		    \App\Listeners\SendSMSReminder\SendSMS::class,
		    \App\Listeners\SendSMSReminder\FixSendInDatabase::class,
		    \App\Listeners\SendSMSReminder\sendAdminNotify::class,
	    ],
	    \App\Events\SendBillOrders::class => [
		    \App\Listeners\SendBillOrders\CreateNewOrders::class,
		    \App\Listeners\SendBillOrders\OrderFileGenerate::class,
		    \App\Listeners\SendBillOrders\SendEmail::class,
	    ],
	    \App\Events\SendAttentionBillOrders::class => [
		    \App\Listeners\SendAttentionBillOrders\fixAttentionOrders::class,
		    \App\Listeners\SendAttentionBillOrders\OrderFileGenerate::class,
		    \App\Listeners\SendAttentionBillOrders\SendEmail::class,
	    ],
	    \App\Events\SendWarningBillOrders::class => [
		    \App\Listeners\SendWarningBillOrders\fixWarningOrders::class,
		    \App\Listeners\SendWarningBillOrders\OrderFileGenerate::class,
		    \App\Listeners\SendWarningBillOrders\SendEmail::class,
	    ],
	    \App\Events\SendBlockBillOrders::class => [
		    \App\Listeners\SendBlockBillOrders\fixBlockOrders::class,
		    \App\Listeners\SendBlockBillOrders\OrderFileGenerate::class,
		    \App\Listeners\SendBlockBillOrders\SendEmail::class,
	    ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
