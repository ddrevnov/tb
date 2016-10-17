<?php

namespace App\Events;

use App\Events\Event;
use App\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendAttentionBillOrders extends Event
{
    use SerializesModels;

	public $orders = array();

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->orders = Order::where('status', 'new')->get();
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
