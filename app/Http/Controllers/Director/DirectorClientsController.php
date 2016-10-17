<?php

namespace App\Http\Controllers\Director;

use App\Client;

class DirectorClientsController extends DirectorController 
{
	/**
	 * Page with all clients
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function clients() 
    {
        $this->data['clients_list'] = Client::paginate(15);
        
        return view('director.clients', $this->data);
    }

	/**
	 * Show one client page
	 *
	 * @param $client Client
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function clientInfo(Client $client)
	{
		$this->data['client_info'] = $client;
		$this->data['orders'] = $client->ordersClient()->paginate(10);
		$this->data['protocols'] = $client->clientProtocol()->orderBy('created_at', 'desc')->paginate(15);

		return view('director.client_info', $this->data);
	}
}
