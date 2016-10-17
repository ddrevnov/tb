<?php

namespace App\Events;

use App\Admin;
use App\Order;
use Illuminate\Queue\SerializesModels;

class ConfirmBill extends Event
{
    use SerializesModels;

	public $order;
	public $admin;
	public $today;

	/**
	 * ConfirmBill constructor.
	 *
	 * @param Order $order
	 * @param Admin $admin
	 * @param       $today
	 */
    public function __construct(Order $order, Admin $admin, $today)
    {
        $this->order = $order;
	    $this->admin = $admin;
	    $this->today = $today;
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
