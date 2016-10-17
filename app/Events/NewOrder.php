<?php

namespace App\Events;

use App\Client;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrder extends Event
{
    use SerializesModels;

	public $order_data;
	public $client;
	public $domain;
	public $adminId;
	public $cartId;

	/**
	 * NewOrder constructor.
	 *
	 * @param $order_data
	 * @param $client Client
	 * @param $domain string
	 * @param $adminId integer
	 */
    public function __construct($order_data, $client, $domain, $adminId)
    {
        $this->order_data = $order_data;
        $this->client = $client;
        $this->domain = $domain;
	    $this->adminId = $adminId;
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
