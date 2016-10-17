<?php

namespace App\Events;

use App\Events\Event;
use App\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendWarningBillOrders extends Event
{
    use SerializesModels;

	public $orders;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
	    $this->orders = Order::where('status', 'attention')->get();
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
