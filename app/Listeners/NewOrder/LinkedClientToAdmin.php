<?php

namespace App\Listeners\NewOrder;

use App\AdminsClients;
use App\Events\NewOrder;

class LinkedClientToAdmin
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
	    if (!AdminsClients::where(['client_id' => $event->client->id, 'admin_id' => $event->adminId])->first()) {
		    AdminsClients::create(['client_id' => $event->client->id, 'admin_id' => $event->adminId]);
	    }
    }
}
