<?php

namespace App\Http\Controllers\Director\Admins;

use App\Avatar;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Requests\UpdateEmail;
use App\Http\Requests\UpdatePassword;
use App\ProtocolEmployee;
use DB;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Employee;
use App\Http\Requests\StoreAvatar;
use App\Http\Requests\StoreAdminEmployee;
use App\Http\Requests\UpdateEmployee;

class DirectorAdminEmployeeController extends DirectorController
{

	/**
	 * Create admin employee page by director
	 *
	 * @param Admin $admin
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createAdminEmployee(Admin $admin)
	{
		$this->data['services'] = $admin->services;

		return view('director.admin_empl_create', $this->data);
	}

	/**
	 * Store admin employee by director
	 *
	 * @param StoreAdminEmployee $request
	 * @param Admin              $admin
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function adminEmployeeStore(StoreAdminEmployee $request, Admin $admin)
	{
		\DB::beginTransaction();
		try {
			$request['admin_id'] = $admin->id;
			$request['user_id'] = User::storeAdminEmployee($request->all(), $request->email, $admin->firmlink);
			$employee = Employee::create($request->all());
			ProtocolEmployee::protocolAdminEmployeeCreate($admin->id, $employee->id, $request, 'director');
			Avatar::storeAvatar($employee->user_id, $request);
			$employee->servicesEmployee()->attach($request->services);

			\DB::commit();
		} catch (\Exception $e) {
			\DB::rollBack();

			return redirect()->back();
		}

		return redirect(route('admin_info', $request->id));
	}

	/**
	 * Get admin employee personal info for edit
	 *
	 * @param Employee $employee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAdminEmployee(Employee $employee)
	{
		return response()->json($employee);
	}

	/**
	 * Get all info for edit admin employee
	 *
	 * @param Employee $employee
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function editAdminEmployee(Employee $employee)
	{
		$this->data['employee'] = $employee;
		$this->data['services'] = $employee->admin->services()->active()->get();
		$this->data['employee_services'] = $employee->servicesEmployee()->lists('service_id')->toArray();

		return view('director.admin_employee_info', $this->data);
	}

	/**
	 * Update employee personal info
	 *
	 * @param UpdateEmployee $request
	 * @param Employee       $employee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminEmployee(UpdateEmployee $request, Employee $employee)
	{
		DB::beginTransaction();
		try {
			ProtocolEmployee::protocolAdminEmployeeChange($employee->admin_id, $employee->id,
				array('name', 'last_name', 'phone', 'birthday', 'group'), $request, 'director');

			$employee->update($request->all());
			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Update employee password with validation
	 *
	 * @param UpdatePassword $request
	 * @param Employee       $employee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminEmployeePassword(UpdatePassword $request, Employee $employee)
	{
		$oldPass = $request['old_password'];
		$newPass = $request['new_password-1'];

		if (User::changePassword($oldPass, $newPass, $employee->user_id)) {
			return response()->json(true);
		} else {
			return response()->json(false);
		}
	}

	/**
	 * Update employee email with validation
	 *
	 * @param UpdateEmail $request
	 * @param Employee    $employee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminEmployeeEmail(UpdateEmail $request, Employee $employee)
	{
		if (User::where('email', $request->email)->first()) {
			return response()->json(false);
		} else {
			DB::beginTransaction();
			try {
				ProtocolEmployee::protocolAdminEmployeeChange($employee->admin_id, $employee->id, array('email'), $request, 'director');
				User::find($employee->user_id)->update(['email' => $request->email]);
				$employee->update(['email' => $request->email]);
				DB::commit();

				return response()->json(true);
			} catch (\Exception $e) {
				DB::rollBack();

				return response()->json(false);
			}

		}
	}

	/**
	 * Store employee new avatar
	 *
	 * @param StoreAvatar $request
	 * @param Employee    $employee
	 *
	 * @return mixed
	 */
	public function storeAdminEmployeeAvatar(StoreAvatar $request, Employee $employee)
	{
		$avatar = Avatar::storeAvatar($employee->user_id, $request);

		return $avatar;
	}

	/**
	 * Synchronize employee services
	 *
	 * @param Request  $request
	 * @param Employee $employee
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateAdminEmployeeService(Request $request, Employee $employee)
	{
		$services = $request->services ?: [];
		$employee->servicesEmployee()->sync($services);

		return redirect()->back();
	}
}
