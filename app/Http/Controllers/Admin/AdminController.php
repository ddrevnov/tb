<?php

namespace App\Http\Controllers\Admin;

use App\AdminsClients;
use App\Client;
use App\Employee;
use App\Order;
use App\User;
use Auth;
use App\Admin;
use Illuminate\Support\Facades\Gate;
use App\Chat_massage;
use App\Country;
use App\State;
use App\City;
use Illuminate\Http\Request;
use App\AdminMail;

/**
 * @property integer $idAdmin
 * @property string $firmLink
 * @property integer $userId
 * @property integer $employeeId
 * @property array $data
 * @property string $locale
 * @property Admin $admin
 */

class AdminController extends \App\Http\Controllers\Controller
{
	/**
	 * @var integer $idAdmin Id of current admin
	 */
	public $idAdmin;
	/**
	 * @var string $firmLink String with subdomain
	 */
	public $firmLink;
	/**
	 * @var integer $userId Id of auth user
	 */
	public $userId;
	/**
	 * @var integer $employeeId Id of auth employee if exist
	 */
	public $employeeId;
	/**
	 * @var array $data Array with all data for render page
	 */
	public $data = array();
	/**
	 * @var string $locale String with locale like en,de,ru
	 */
	public $locale;
	/**
	 * @var Admin $admin
	 */
	public $admin;

	/**
	 * Init admin or admin employee. Init adminId and userId
	 *
	 * AdminController constructor.
	 */
	public function __construct()
	{
		$this->userId = Auth::id();
		$this->idAdmin = Admin::where('user_id', $this->userId)->first();
		if (!$this->idAdmin) {
			$employee = Employee::where('user_id', $this->userId)->first();
			if ($employee) {
				$this->employeeId = Employee::where('user_id', $this->userId)->first()->id;
				if ($this->employeeId) {
					$this->idAdmin = Employee::where('user_id', $this->userId)->first()->admin_id;
					$this->data['employee_id'] = $this->employeeId;
				}
			}
		} else {
			$this->middleware('startAssistant');
			$this->idAdmin = $this->idAdmin->id;
		}
		$this->admin = Admin::find($this->idAdmin);

		$this->firmLink = $this->admin->firmlink;
		$this->data['locale'] = $this->locale = $this->admin->user->locale;
	}

	/**
	 * Dashboard page with last messages
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function index()
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}
		$this->data['last_chat_messages'] = Chat_massage::getDashboardLastMessages($this->userId);

		return view('admin.dashboard', $this->data);
	}

	public function gastebuch()
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		$this->data['comments'] = $this->admin->comments()->paginate(10);

		return view('admin.gastebuch', $this->data);
	}

	/**
	 * Get admin location on any page
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getLocation(Request $request)
	{
		if (!$request->all()) {
			$countries = Country::select('id as country_id', 'name')->get();

			return response()->json($countries);
		} elseif ($request->country_id) {
			$states = State::where('country_id', $request->country_id)->select('id as state_id', 'name')->get();

			return response()->json($states);
		} elseif ($request->state_id) {
			$cities = City::where('state_id', $request->state_id)->select('id as city_id', 'name')->get();

			return response()->json($cities);
		}

		return response()->json(false);
	}

	//живой поиск для админа
	public function search(Request $request)
	{
		$q = $request->q;
		//будем искать только среди тех клиентов, которые подвязаны к админу
		$clients_id = AdminsClients::where('admin_id', $this->idAdmin)->lists('client_id')->toArray();
		//$result['orders'] = TariffAdminJournal::where('admin_id', $this->idAdmin)->where('id', 'LIKE', "%$q%")->get();

		//поиск клиентов
		$result['clients'] = Client::whereIn('id', $clients_id)
			->where(function ($query) use ($q) {
				$query->where('first_name', 'LIKE', "%$q%")
					->orWhere('last_name', 'LIKE', "%$q%")
					->orWhere('email', 'LIKE', "%$q%")
					->orWhere('mobile', 'LIKE', "%$q%");
			})->select('clients.id', 'clients.first_name as client_first_name', 'clients.last_name as client_last_name',
				'clients.email as client_email', 'clients.mobile as client_mobile')->get()->toArray();

		//поиск сотрудников
		$result['employees'] = Employee::where('admin_id', $this->idAdmin)->where(function ($query) use ($q) {
			$query->where('name', 'LIKE', "%$q%")
				->orWhere('last_name', 'LIKE', "%$q%")
				->orWhere('email', 'LIKE', "%$q%")
				->orWhere('phone', 'LIKE', "%$q%");
		})->select('employees.id', 'employees.name as employee_first_name', 'employees.last_name as employee_last_name',
			'employees.email as employee_email', 'employees.phone as employee_telnumber')->get()->toArray();

		//поиск писем
		$result['letters'] = AdminMail::where(function ($query) use ($q) {
			$query->where('subject', 'LIKE', "%$q%");
		})->select('id', 'subject')->get()->toArray();

		//поиск выставленных счетов по шаблону Т0000№ где № - id счета в таблице
		$qb = sscanf($q, 'T%05u')[0];
		if ($qb) {
			$result['bills'] = Order::where(function ($query) use ($qb) {
				$query->where('admin_id', $this->idAdmin)
					->where('id', 'like', "%$qb%");
			})
				->select('id')->get()->toArray();
		} else {
			$result['bills'] = [];
		}


		//приведение всех результатов поиска к виду, корректному для фронтенда
		$search_res = array();
		foreach ($result as $key => $res) {
			$search_res[$key] = array();
			foreach ($res as $r) {
				$r = array_filter($r, function ($item) use ($q) {
					if (is_int($item)) {
						return true;
					} else {
						return preg_match("/" . $q . "/i", $item);
					}
				});
				$search_res[$key][] = $r;
			}
		}

		return response()->json($search_res);
	}

	public function setLocale(Request $request)
	{
		$user = User::find(Auth::id());
		$user->locale = $request->loc;
		$user->save();

		return redirect()->back();
	}
}
