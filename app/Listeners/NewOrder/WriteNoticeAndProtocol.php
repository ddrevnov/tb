<?php

namespace App\Listeners\NewOrder;

use App\AdminNotice;
use App\Events\NewOrder;
use App\ProtocolClient;

class WriteNoticeAndProtocol
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
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
	    AdminNotice::create(['notice_type' => 'new_order', 'admin_id' => $event->adminId]);
	    ProtocolClient::protocolClientOrder($event->adminId, $event->client->id, $event->cartId, 'client');
    }
}
