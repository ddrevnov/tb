<?php

namespace App\Http\Controllers\Admin;

use App\Calendar;
use App\Client;
use App\Employee;
use App\ProtocolClient;
use App\Services;
use App\User;
use App\WorkTime;
use Mockery\Exception;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\ServicesCategory;
use App\EmployeeService;
use Illuminate\Support\Facades\Mail;
use App\AdminsClients;

class CalendarController extends AdminController
{

	//вывод календаря
	public function indexCalendar()
	{
		$this->data['services'] = Services::getServicesList($this->idAdmin);
		$this->data['categories'] = ServicesCategory::getActiveServicesCategoryList($this->idAdmin);
		$this->data['employees'] = Employee::getEmployeesActive($this->idAdmin);
		$this->data['employee_id'] = $this->data['idEmployee'] = $this->employeeId;
		$this->data['work_days'] = WorkTime::where(['firmlink' => $this->firmLink, 'from' => '00:00:00', 'to' => '00:00:00'])
			->lists('index_day');

		return view('admin.kalendar', $this->data);
	}

	//получение всех активных сотрудников
	public function getEmployees(Request $request)
	{
		if (!$request->all()) {
			$result = Employee::where('admin_id', $this->idAdmin)->where('status', 'active')
				->select('id', 'name')->get();
		} else {
			$result = EmployeeService::getEmployees($request->service_id);
		}

		return json_encode($result);
	}

	//получение всех активных услуг салона
	public function getServices(Request $request)
	{
		if (!$request->employee_id) {
			$result = Services::getActiveServicesList($this->idAdmin)->groupBy('category_name');
		} else {
			$result = EmployeeService::getServicesForEmployee($request->employee_id);
		}

		if ($result->isEmpty()) {
			return json_encode(false);
		}

		return json_encode($result);
	}

	// добавление новой карточки в календарь с проверкой, создается ли карточка для нового клиента или для старого
	// если для нового, проходит процедура регистрации и записи клиента в журнал салона
	// по итогу заказа высылается письмо
	public function addCalendar(Request $request, $domain)
	{
		\DB::beginTransaction();
		try {
			//if add cart for new client
			if ($request->new) {
				$newUserData = [
					'name'     => $request->vorname,
					'email'    => $request->email,
					'status'   => 'user',
					'password' => '',
				];
				$user_id = User::storeUser($newUserData, $request->email, $domain);
				$newClientData = [
					'first_name' => $request->vorname,
					'last_name'  => $request->nachname,
					'telephone'  => $request->phone,
					'email'      => $request->email,
					'mobile'     => $request->mobil,
					'user_id'    => $user_id,
				];
				$client = Client::create($newClientData);
				AdminsClients::create(['client_id' => $client->id, 'admin_id' => $this->idAdmin]);
				ProtocolClient::protocolClientCreate($this->idAdmin, $client->id, $request->vorname);
			} else {
				//add new calendar if user in DB and update his data
				$clientData = [
					'first_name' => $request->vorname,
					'last_name'  => $request->nachname,
					'telephone'  => $request->phone,
				];
				Client::where('email', $request->email)->first()->update($clientData);
				$idClient = Client::where('email', $request->email)->first()->id;
				if (!AdminsClients::where(['client_id' => $idClient, 'admin_id' => $this->idAdmin])->first()) {
					AdminsClients::create(['client_id' => $idClient, 'admin_id' => $this->idAdmin]);
				}

			}

			if ($request->has('email')) {
				//add calendar with order
				$client = Client::where('email', $request->email)->first();
				$calendarData = [
					'color'       => $request->input('color'),
					'description' => $request->input('description'),
					'time_from'   => $request->input('time_from'),
					'time_to'     => $request->input('time_to'),
					'date'        => $request->input('date'),
					'employee_id' => $request->input('employee'),
					'service_id'  => $request->input('service'),
					'client_id'   => $client->id,
					'domain'      => $domain,
					'status'      => 'active',
					'sms'         => $request->input('send_sms') ?: 0,
					'email'         => $request->input('send_email') ?: 0,
				];
			} else {
				return response()->json(false);
			}

			$locale = User::find($client->user_id)->locale;

			//check action for cart
			if ($request->action == 'create') {
				$cartId = Calendar::create($calendarData)->id;
				$subject = \Lang::get('emails.create', [], $locale);
				$data = Calendar::getInfoForConfirmEmail($cartId, $domain);
				ProtocolClient::protocolClientOrder($this->idAdmin, $client->id, $cartId, 'admin', 'create');
			} elseif ($request->action == 'edit') {
				Calendar::where('id', $request->cartId)->update($calendarData);
				$subject = \Lang::get('emails.edit', [], $locale);
				$cartId = $request->cartId;
				$data = Calendar::getInfoForConfirmEmail($cartId, $domain);
				ProtocolClient::protocolClientOrder($this->idAdmin, $client->id, $cartId, 'admin', 'edit');
			} else {
				$cartId = $request->cartId;
				$data = Calendar::getInfoForConfirmEmail($cartId, $domain);
				$nowDate = date('d/m/Y');
				Calendar::where('id', $request->cartId)->update(['status' => 'deleted', 'date_deleted' => $nowDate]);
				$subject = \Lang::get('emails.delete', [], $locale);
				ProtocolClient::protocolClientOrder($this->idAdmin, $client->id, $cartId, 'admin', 'delete');
			}

			\DB::commit();
		} catch (Exception $e) {
			\DB::rollBack();

			return response($e);
		};

		$data = $data->toArray();
		$email = $client->email;

		//need full path for employee avatar
		$avatar = $data['path'] ?: '/images/default_avatar.png';
		$data['path'] = public_path() . $avatar;
		$data['locale'] = $locale;
		//send approve with subject
		Mail::send('emails.confirm_order',
			$data,
			function ($message)
			use ($email, $domain, $subject, $data) {
				$message->from($domain . '@timebox24.com', $domain);
				$message->to($email)->subject($subject);
			});

		return response()->json([true]);
	}

	//добавление в календарь отпуска или выходного для сотрудника. отпуска на несколько дней групируются параметром group
	public static function addHoliday(Request $request, $domain)
	{
		//delete holiday group cart
		if ($request->action == 'delete') {
			Calendar::where('group_id', $request->groupId)->delete();

			return response()->json(true);
		}

		$rules = [
			'time_from'   => 'required',
			'time_to'     => 'required',
			'date_from'   => 'required',
			'date_to'     => 'required',
			'description' => 'required',
			'employee'    => 'required',
			'color'       => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(false);
		}

		//check free time for create or edit holiday
		$start_date = Carbon::createFromFormat('d/m/Y', $request->date_from);
		$end_date = Carbon::createFromFormat('d/m/Y', $request->date_to);

		if ($start_date > $end_date) {
			return response()->json(['check' => false, 'reason' => 'wrong date']);
		}

		while ($start_date <= $end_date) {

			$start_time = \DateTime::createFromFormat('H:i', $request->time_from);
			$end_time = \DateTime::createFromFormat('H:i', $request->time_to);

			if ($start_time > $end_time) {
				return response()->json(['check' => false, 'reason' => 'wrong time']);
			}

			$empl_id = $request->employee;
			$group_id_base = isset($request->cartId) ? Calendar::where('id', $request->cartId)->first()->group_id : 0;

			$calendar = new Calendar();
			$start_date_2 = $start_date->format('d/m/Y');

			$calendarInfo = $calendar->getCalendar($domain, array($start_date_2), $empl_id, $group_id_base);
			$holidayInfo = $calendar->getHoliday($domain, array($start_date_2), $empl_id, $group_id_base);

			//check free time from orders
			foreach ($calendarInfo as $info) {
				$from = \DateTime::createFromFormat('H:i', $info->time_from);
				$to = \DateTime::createFromFormat('H:i', $info->time_to);

				if (($start_time >= $from && $start_time < $to) || ($start_time < $from && $end_time > $to)) {
					return response()->json(['check' => false, 'reason' => 'order']);
				} else {
					if (($end_time > $from && $end_time <= $to) || ($start_time > $from && $end_time < $to)) {
						return response()->json(['check' => false, 'reason' => 'order']);
					}
				}
			}

			//check free time from holiday
			foreach ($holidayInfo as $info) {
				$from = \DateTime::createFromFormat('H:i', $info->time_from);
				$to = \DateTime::createFromFormat('H:i', $info->time_to);

				if (($start_time >= $from && $start_time < $to) || ($start_time < $from && $end_time > $to)) {
					return response()->json(['check' => false, 'reason' => 'holiday']);
				} else {
					if (($end_time > $from && $end_time <= $to) || ($start_time > $from && $end_time < $to)) {
						return response()->json(['check' => false, 'reason' => 'holiday']);
					}
				}
			}
			$start_date->addDay();

		}

		//edit holiday cart without current group
		$start_date = Carbon::createFromFormat('d/m/Y', $request->date_from);
		$end_date = Carbon::createFromFormat('d/m/Y', $request->date_to);

		$group = Calendar::whereNotNull('group_id')->orderBy('group_id', 'desk')->first();
		if ($group) {
			$group_id = $group->group_id + 1;
		} else {
			$group_id = 1;
		}

		if ($request->action == 'edit') {
			Calendar::where('group_id', $group_id_base)->delete();

			while ($start_date <= $end_date) {
				$calendarData = [
					'color'       => $request->input('color'),
					'description' => $request->input('description'),
					'time_from'   => $request->input('time_from'),
					'time_to'     => $request->input('time_to'),
					'date'        => $start_date->format('d/m/Y'),
					'employee_id' => (int)$request->input('employee'),
					'domain'      => $domain,
					'status'      => 'holiday',
					'group_id'    => $group_id,
				];

				Calendar::create($calendarData);
				$start_date->addDay();
			}

			return response()->json(true);
		}

		//create new holiday group
		while ($start_date <= $end_date) {
			$calendarData = [
				'color'       => $request->input('color'),
				'description' => $request->input('description'),
				'time_from'   => $request->input('time_from'),
				'time_to'     => $request->input('time_to'),
				'date'        => $start_date->format('d/m/Y'),
				'employee_id' => (int)$request->input('employee'),
				'domain'      => $domain,
				'status'      => 'holiday',
				'group_id'    => $group_id,
			];
			Calendar::create($calendarData);
			$start_date->addDay();
		}

		return response()->json(true);
	}

	//получение через ajax всех карточек календаря для текущего сотрудника
	public function getCalendar(Request $request, Calendar $calendar)
	{
		$start = Carbon::createFromFormat('d/m/Y', $request->from);
		$end = Carbon::createFromFormat('d/m/Y', $request->to);

		if ($request->ajax()) {

			$dates = [];

			for ($date = $start; $date->lte($end); $date->addDay()) {
				$dates[] = $date->format('d/m/Y');
			}
			$calendarInfo = $calendar->getCalendar($request->data, $dates, $request->id);
			$holidayInfo = $calendar->getHoliday($request->data, $dates, $request->id)->groupBy('group_id');

			if (isset($holidayInfo)) {
				foreach ($holidayInfo as $holiday) {
					$date_from = \DateTime::createFromFormat('d/m/Y', $holiday->first()->date);
					$date_to = \DateTime::createFromFormat('d/m/Y', $holiday->last()->date);
					$days = $date_to->diff($date_from)->days + 1;
					$holiday = $holiday->shift()->toArray();
					$holiday['date_from'] = $date_from->format('d/m/Y');
					$holiday['date_to'] = $date_to->format('d/m/Y');
					$holiday['days'] = $days;
					$calendarInfo->push($holiday);
				}
			}

			return response()->json($calendarInfo);

		}

		return false;
	}

	//проверка свободного времени сотрудника перед создание карточки-заказа
	public function checkEmployee(Request $request, $domain, Calendar $calendar)
	{
		//когда создают карточку с 0, то посылают запрос на этот метод. при отсутствии времени начала, надо возвращать 0
		if ($request->start_time == '') {
			return 0;
		}

		$duration = $request->duration ? $request->duration : 0;
		$start_time = \DateTime::createFromFormat('H:i', $request->start_time);
		$interval = "PT" . $duration . "M";
		$end_time = \DateTime::createFromFormat('H:i', $request->start_time)->add(new \DateInterval($interval));
		$date = array($request->date);

		//проверяем рабочее время салона. если время не рабоее, возвразщаем false
		$week_index_day = \DateTime::createFromFormat('d/m/Y', $request->date)->modify('-1 day')->format('w');
		$work_time = WorkTime::where(['firmlink' => $domain, 'index_day' => $week_index_day])->first();

		if (!$work_time) {
			response()->json(['check' => false, 'reason' => 'not_work_time']);
		}

		$work_time_from = \DateTime::createFromFormat('H:i:s', $work_time->from)->format('H:i');
		$work_time_to = \DateTime::createFromFormat('H:i:s', $work_time->to)->format('H:i');

		if ($start_time->format('H:i') < $work_time_from || $end_time->format('H:i') > $work_time_to) {
			return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false, 'reason' => 'worktime']);
		}

		//проверяем, свободен ли сотрудник в запрашиваемое время
		$empl_id = $request->id;
		//если карточку редактируют, то берем её id чтобы игнорировать эту карточку при проверке
		$cart_id = isset($request->cartId) ? $request->cartId : 0;
		$calendarInfo = $calendar->getCalendar($domain, $date, $empl_id, $cart_id);
		$holidayInfo = $calendar->getHoliday($domain, $date, $empl_id, $cart_id);

		//если на текущий день вообще нет заказов, возвращаем true без проверки по времени
		if ($calendarInfo->isEmpty() && $holidayInfo->isEmpty()) {
			return response()->json(['end_time' => $end_time->format('H:i'), 'check' => true]);
		}

		//проверка по времени, нет ли у сотрудника заказов
		foreach ($calendarInfo as $info) {
			$from = \DateTime::createFromFormat('H:i', $info->time_from);
			$to = \DateTime::createFromFormat('H:i', $info->time_to);

			if (($start_time >= $from && $start_time < $to) || ($start_time < $from && $end_time > $to)) {
				return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false, 'reason' => 'order']);
			} else {
				if (($end_time > $from && $end_time <= $to) || ($start_time > $from && $end_time < $to)) {
					return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false, 'reason' => 'order']);
				}
			}
		}

		//проверка по времени, нет ли у сотрудника выходного
		foreach ($holidayInfo as $info) {
			$from = \DateTime::createFromFormat('H:i', $info->time_from);
			$to = \DateTime::createFromFormat('H:i', $info->time_to);

			if (($start_time >= $from && $start_time < $to) || ($start_time < $from && $end_time > $to)) {
				return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false, 'reason' => 'holiday']);
			} else {
				if ($end_time > $from && $end_time <= $to) {
					return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false, 'reason' => 'holiday']);
				}
			}
		}

		//возвращаем время окончания для отрисовки в календаре и конечном сайте
		return response()->json(['end_time' => $end_time->format('H:i'), 'check' => true]);
	}

	//проверка свободен ли email при создании карточки с новым клиентом (регистрация нового клиента)
	public function checkEmail(Request $request)
	{
		$email = $request->email;

		if (User::where('email', $email)->first()) {
			if (User::where(['email' => $email, 'status' => 'user'])->first()) {
				$client = Client::where('email', $email)->first();

				return json_encode($client);
			} else {
				return response()->json([1]);
			}
		}

		return response()->json([0]);
	}

	/**
	 * Get all admin clients for autocomplete
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getClients()
	{
		$clients = $this->admin->clients;

		return response()->json($clients);
	}

}
