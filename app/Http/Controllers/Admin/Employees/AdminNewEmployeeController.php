<?php

namespace App\Http\Controllers\Admin\Employees;

use App\Avatar;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests;
use App\ProtocolEmployee;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminNewEmployeeController extends AdminController
{
	/**
	 * Create page new admin employee
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function employeeCreate()
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		if ($this->admin->tariffJournal->type === 'free' && $this->admin->employees()->count() >= 2){
			return redirect('/office/tariff');
		}

		$this->data['services'] = $this->admin->services()->active()->get();

		return view('admin.employee_create', $this->data);
	}

	/**
	 * Check unique email
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkEmail(Request $request)
	{
		if (User::where('email', $request->email)->first()) {
			return response()->json(false);
		}

		return response()->json(true);
	}

	/**
	 * Store new admin employee and check tariff
	 *
	 * @param Requests\UpdateEmployee $request
	 * @param                         $domain
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function employeeStore(Requests\UpdateEmployee $request, $domain)
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		\DB::beginTransaction();
		try {
			$request['user_id'] = User::storeAdminEmployee($request->all(), $request->email, $domain, $this->locale);
			$employee = $this->admin->employees()->create($request->all());
			Avatar::storeAvatar($request['user_id'], $request);
			$services = $request->input('services') ?: [];
			$employee->servicesEmployee()->attach($services);
			$this->saveToOrderNewEmployee($employee, $request);

			ProtocolEmployee::protocolAdminEmployeeCreate($this->idAdmin, $employee->id, $request);
			\DB::commit();
		} catch (\Exception $e) {
			\DB::rollBack();

			return response()->json(false);
		}

		return response()->json(true);
	}

	private function saveToOrderNewEmployee($employee, $request)
	{
		if ($this->admin->employees()->count() >= 2) {
			$today = new Carbon('today');
			$last_day = new Carbon('last day of this month');
			$request['price'] = 0.16 * $today->diffInDays($last_day);
			$this->admin->orderEmployees()->create($request->all());
		}
	}
}
