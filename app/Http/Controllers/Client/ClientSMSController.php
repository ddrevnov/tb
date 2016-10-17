<?php

namespace App\Http\Controllers\Client;


use Bjrnblm\Messagebird\Facades\Messagebird;

class ClientSMSController extends ClientController
{
	public function index()
	{
		try {
			$res = Messagebird::getBalance();
//			$res = Messagebird::createMessage('test', array('4915779046033'), 'test');

			return response()->json($res);

		} catch (\Exception $e) {
			dd($e);
		}
	}
}
