<?php

namespace App\Http\Controllers\Client;

use App\Admin;
use Illuminate\Http\Request;
use App\Firm;
use App\Client;
use App\Comment;

class ClientGuestBookController extends ClientController
{
    public function gustebook()
    {
        $this->data['comments'] = Admin::find($this->adminId)->comments()->paginate(15);
        $this->data['client_id'] = $this->clientId;
        return view('users.gustebook', $this->data);
    }

    public function editgustebook(Request $request, $domain)
    {
        $time = $request->input('time');
        $heading = $request->input('heading');
        $text = $request->input('text');
        $star = $request->input('star');
        $idclient = Client::where('user_id', $this->userId)->first();
        $idfirm = Firm::where('firmlink', $domain)->first();
        $client = Client::where('firmlink', $domain)->first();

        if (!empty($client)) {
            Comment::create(['time' => $time, 'heading' => $heading, 'text' => $text, 'star' => $star,
                'id_clients' => $idclient->id, 'id_firm' => $idfirm->id, 'name_firm' => $client->firmlink]);

        }
        return redirect('/client/gustebook');
    }

    public function deletegustebook(Request $request)
    {
        Comment::find($request->id)->delete();
        return response()->json(["status" => true]);
    }

    public function editcommentsgustebook(Request $request, $domain, $id)
    {
        $heading = $request->input('heading');
        $text = $request->input('text');
        $stars = $request->input('stars');
        Comment::find($id)->update(['text' => $text, 'heading' => $heading, 'star' => $stars]);

        return response()->json(["status" => true]);
    }
}
