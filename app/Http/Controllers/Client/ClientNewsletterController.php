<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Client;
use App\AdminsClients;

class ClientNewsletterController extends ClientController
{
    public function newsletter()
    {
        $client_id = Client::where('user_id', $this->userId)->first()->id;
        $this->data['subscribe'] = AdminsClients::getClientSubscribes($client_id);

        return view('users.newsletter', $this->data);
    }

    public function newsletterEdit(Request $request)
    {
        $client_id = Client::where('user_id', $this->userId)->first()->id;
        AdminsClients::where('client_id', $client_id)->update(['email_send' => 0]);
        if ($request->subscribe){
            AdminsClients::whereIn('admin_id', $request->subscribe)->update(['email_send' => 1]);
        }

        return redirect()->back();
    }
}
