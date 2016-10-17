<?php

namespace App\Http\Controllers\Director;

use App\DirectorEmployee;
use App\User;
use App\Avatar;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;


class DirectorEmployeesController extends DirectorController
{
	/**
	 * List of all director employees
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function employees()
	{
		$this->data['employees'] = DirectorEmployee::exceptDirector()->paginate(10);

		return view('director.employees', $this->data);
	}

	/**
	 * Show single director employee info
	 *
	 * @param DirectorEmployee $directorEmployee
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function employeeInfo(DirectorEmployee $directorEmployee)
	{
		$this->data['personal_info'] = $directorEmployee;
		$this->data['employee_avatar'] = $directorEmployee->avatarEmployee;

		return view('director.employee_info', $this->data);
	}

	/**
	 * Page for creating new director employee
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		return view('director.employee_create', $this->data);
	}

	/**
	 * Store new director employee
	 *
	 * @param Requests\StoreDirectorEmployee $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function store(Requests\StoreDirectorEmployee $request)
	{
		$password = str_random(8);
		\DB::beginTransaction();
		try{
			$request['password'] = password_hash($password, PASSWORD_BCRYPT);
			$request['status'] = 'director_employee';
			$request['user_id'] = User::create($request->all())->id;
			DirectorEmployee::create($request->all());

			Avatar::storeAvatar($request->user_id, $request);

			\DB::commit();
		}catch (\Exception $e){
			\DB::rollBack();
			dd($e);
		}

		Mail::send('emails.welcome',
			[
				'firstname' => $request->name,
				'lastname'  => $request->last_name,
				'password'  => $password,
				'email'     => $request->email,
				'firmlink'  => 'http://' . $_SERVER['HTTP_HOST'] . '/backend',
				'locale'    =>  'de',
			],
			function ($message) use ($request) {
				$message->from('no-reply@timebox24.com');
				$message->to($request->email, $request->name)->subject('Registration succesfull');
			});

		return redirect('/backend/employees');
	}

	/**
	 * Edit director employee info
	 *
	 * @param Requests\UpdateEmployee $request
	 * @param DirectorEmployee        $directorEmployee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setEmployeeInfo(Requests\UpdateEmployee $request, DirectorEmployee $directorEmployee)
	{
		$directorEmployee->update($request->all());

		return response()->json(true);
	}

	/**
	 * Edit director employee password
	 *
	 * @param Requests\UpdatePassword $request
	 * @param DirectorEmployee        $directorEmployee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setPassword(Requests\UpdatePassword $request, DirectorEmployee $directorEmployee)
	{
		$oldPass = $request['old_password'];
		$newPass = $request['new_password-1'];

		if (User::changePassword($oldPass, $newPass, $directorEmployee->user_id)) {
			return response()->json(true);
		} else {
			return response()->json(false);
		}
	}

	/**
	 * Edit director employee email
	 *
	 * @param Requests\UpdateEmail $request
	 * @param DirectorEmployee     $directorEmployee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setEmail(Requests\UpdateEmail $request, DirectorEmployee $directorEmployee)
	{
		if (User::where('email', $request->email)->first()) {
			return response()->json(false);
		} else {
			User::find($directorEmployee->user_id)->update(['email' => $request->email]);
			$directorEmployee->update(['email' => $request->email]);

			return response()->json(true);
		}
	}

	/**
	 * Edit director employee avatar
	 *
	 * @param Requests\StoreAvatar $request
	 * @param DirectorEmployee     $directorEmployee
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storeAvatar(Requests\StoreAvatar $request, DirectorEmployee $directorEmployee)
	{
		$avatar = Avatar::storeAvatar($directorEmployee->user_id, $request);

		return response()->json($avatar, 200, [], JSON_UNESCAPED_SLASHES);
	}

	/**
	 * Get director employee info for edit
	 *
	 * @param DirectorEmployee $directorEmployee
	 *
	 * @return \Illuminate\Http\JsonResponse|mixed|string|void
	 */
	public function getEmployeeInfo(DirectorEmployee $directorEmployee)
	{
		return response()->json($directorEmployee);
	}
}
