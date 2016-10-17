<?php

namespace App\Http\Controllers\Director\Admins;

use App\Avatar;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Requests\StoreLogo;
use App\Http\Requests\UpdateAdminPersonalInfo;
use App\Http\Requests\UpdateEmail;
use App\Http\Requests\UpdatePassword;
use App\ProtocolPersonal;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Firm;
use App\WorkTime;
use App\Image;
use App\FirmType;
use App\Http\Requests\StoreAvatar;

class DirectorSingleAdminController extends DirectorController
{

	/**
	 * One admin info page
	 *
	 * @param Admin $admin
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function adminInfo(Admin $admin)
	{
		$this->data['days'] = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
		$this->data['admin'] = $admin;
		$this->data['bank_details'] = $admin->bankDetails;
		$this->data['firmType'] = FirmType::get();
		$this->data['employee'] = $admin->employees()->paginate(10);
		$this->data['orders'] = $admin->orders()->activeOrCancel()->get();
		$this->data['protocols'] = $this->protocol($admin);

		return view('director.admin_info', $this->data);
	}

	/**
	 * Get admin info for edit
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAdminPersonalInfo(Request $request)
	{
		$admin = Admin::getActiveAdminInfo($request->admin)->toArray();

		$firm = Firm::where('firmlink', $admin['firmlink'])
			->select(['street', 'city as city_id', 'state as state_id', 'country as country_id'])
			->first()->toArray();

		return response()->json(array_merge($admin, $firm));
	}

	/**
	 * Get admin work times for edit
	 *
	 * @param Admin $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAdminWorkTimes(Admin $admin)
	{
		$admin->workTimes->each(function ($item) {
			if ($item->from == '00:00:00' && $item->to == '00:00:00') {
				$item->close = true;
			}
		});

		return response()->json($admin->workTimes);
	}

	/**
	 * Store admin logo
	 *
	 * @param StoreLogo $request
	 * @param Admin     $admin
	 *
	 * @return string
	 */
	public function storeLogo(StoreLogo $request, Admin $admin)
	{
		$logo = Image::addLogo($admin->id, $request);

		return $logo;
	}

	/**
	 * Store admin avatar
	 *
	 * @param StoreAvatar $request
	 * @param Admin       $admin
	 *
	 * @return mixed|string
	 */
	public function storeAvatar(StoreAvatar $request, Admin $admin)
	{
		$avatar = Avatar::storeAvatar($admin->user_id, $request);

		return response()->json($avatar, 200, [], JSON_UNESCAPED_SLASHES);
	}

	/**
	 * Edit admin admin admin's firm info
	 *
	 * @param UpdateAdminPersonalInfo $request
	 * @param Admin                   $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminPersonalInfo(UpdateAdminPersonalInfo $request, Admin $admin)
	{
		\DB::beginTransaction();
		try {
			ProtocolPersonal::protocolAdminPersonalChange($admin->id, array('firstname', 'lastname', 'mobile'), $request, 'director');
			$admin->update($request->all());
			$admin->firm->update($request->all());

			\DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			\DB::rollBack();

			return response()->json(false);
		}

	}

	/**
	 * Edit admin work times
	 *
	 * @param Request $request
	 * @param Admin   $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminWorkTimes(Request $request, Admin $admin)
	{
		$editInfo = $request->worktimes;
		$admin->workTimes()->delete();
		for ($i = 0; $i < 7; $i++) {
			WorkTime::create(['from'      => $editInfo[$i]['from'],
			                  'to'        => $editInfo[$i]['to'],
			                  'index_day' => $i,
			                  'firmlink'  => $admin->firmlink]);
		}

		return response()->json(true);
	}

	/**
	 * Set new admin password
	 *
	 * @param UpdatePassword $request
	 * @param Admin          $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminPassword(UpdatePassword $request, Admin $admin)
	{
		$oldPass = $request['old_password'];
		$newPass = $request['new_password-1'];

		if (User::changePassword($oldPass, $newPass, $admin->user_id)) {
			return response()->json(true);
		} else {
			return response()->json(false);
		}
	}

	/**
	 * Change admin email with unique validation
	 *
	 * @param UpdateEmail $request
	 * @param Admin       $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setAdminEmail(UpdateEmail $request, Admin $admin)
	{
		if (User::where('email', $request->email)->first()) {
			return response()->json(false);
		} else {
			ProtocolPersonal::protocolAdminPersonalChange($admin->id, array('email'), $request, 'director');
			$admin->user()->update(['email' => $request->email]);
			$admin->update(['email' => $request->email]);

			return response()->json(true);
		}
	}

	/**
	 * Generate protocol
	 *
	 * @param $admin
	 *
	 * @return mixed
	 */
	private function protocol($admin)
	{
		$protocol['personal'] = $admin->personalProtocol()->orderBy('created_at', 'desc')->get();
		$protocol['categories'] = $admin->categoryProtocol()->orderBy('created_at', 'desc')->with('category')->get();
		$protocol['services'] = $admin->serviceProtocol()->orderBy('created_at', 'desc')->with('service')->get();
		$protocol['employees'] = $admin->employeeProtocol()->orderBy('created_at', 'desc')->with('employee')->get();
		$protocol['newsletters'] = $admin->newsletterProtocol()->orderBy('created_at', 'desc')->with('employee')->get();

		return $protocol;
	}
}
