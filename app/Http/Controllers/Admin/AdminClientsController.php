<?php

namespace App\Http\Controllers\Admin;

use App\AdminsClients;
use App\Http\Requests;
use App\Client;
use App\Avatar;
use App\ProtocolClient;
use App\User;
use DB;

class AdminClientsController extends AdminController
{
	/**
	 * @var Client
	 */
	protected $client;

	public function __construct()
	{
		parent::__construct();
		$this->client = Client::find(\Route::current()->parameter('client'));
	}

	/**
	 * Page with all admin clients
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function clientsList()
	{
		$this->data['clients_info'] = $this->admin->clients()->paginate(15);

		return view('admin.clients_list', $this->data);
	}

	/**
	 * View for create new client
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		return view('admin.client_create', $this->data);
	}

	/**
	 * @param Requests\StoreAdminClient $request
	 * @param                           $domain
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception fail transaction
	 */
	public function store(Requests\StoreAdminClient $request, $domain)
	{
		$data = $request->all();

		DB::beginTransaction();
		try {

			$user_id = User::storeUser($data, $data['email'], $domain);
			$data['user_id'] = $user_id;
			$data['firmlink'] = $domain;
			$data['first_name'] = $request->name;
			$client = Client::create($data);
			Avatar::storeAvatar($client->user_id, $request);

			AdminsClients::create(['client_id' => $client->id, 'admin_id' => $this->idAdmin]);
			ProtocolClient::protocolClientCreate($this->idAdmin, $client->id, $request->name);

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();

			return redirect(url('/office'));
		}

		return redirect('/office/clients');
	}

	/**
	 * Show one client page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function clientInfo()
	{
		$this->data['client_info'] = $this->client;
		$this->data['orders'] = $this->client->ordersClient()->paginate(10);
		$this->data['protocols'] = $this->protocol();

		return view('admin.client_info', $this->data);
	}

	/**
	 * Get client info for edit
	 *
	 * @return mixed|
	 */
	public function getClientInfo()
	{
		return json_encode($this->client);
	}

	/**
	 * Update client info
	 *
	 * @param Requests\UpdateClientInfo $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception fail transaction
	 */
	public function setClientInfo(Requests\UpdateClientInfo $request)
	{
		DB::beginTransaction();
		try {
			ProtocolClient::protocolClientPersonalChange($this->idAdmin, $this->client->id, array_keys($request->all()), $request);
			$this->client->update($request->all());

			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Store client avatar
	 *
	 * @param Requests\StoreAvatar $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storeAvatar(Requests\StoreAvatar $request)
	{
		$avatar = Avatar::storeAvatar($this->client->user_id, $request);

		return response()->json($avatar, 200, [], JSON_UNESCAPED_SLASHES);
	}

	/**
	 * Change client password
	 *
	 * @param Requests\UpdatePassword $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setPassword(Requests\UpdatePassword $request)
	{
		$oldPass = $request['old_password'];
		$newPass = $request['new_password-1'];

		if (User::changePassword($oldPass, $newPass, $this->client->user_id)) {
			return response()->json(true);
		} else {
			return response()->json(false);
		}
	}

	/**
	 * Change client email
	 *
	 * @param Requests\UpdateEmail $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setEmail(Requests\UpdateEmail $request)
	{
		if (User::where('email', $request->email)->first()) {
			return response()->json(false);
		} else {
			$this->client->update(['email' => $request->email]);
			User::find($this->client->user_id)->update(['email' => $request->email]);

			return response()->json(true);
		}
	}

	private function protocol()
	{
		return $this->client->clientProtocol()->orderBy('created_at', 'desc')->paginate(15);
	}
}
