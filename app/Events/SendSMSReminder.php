<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendSMSReminder extends Event
{
    use SerializesModels;

	public $admin;
	public $cart;

	public $sms_title;
	public $sms_body;
	public $recipient;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($admin, $cart)
    {
        $this->admin = $admin;
	    $this->cart = $cart;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
