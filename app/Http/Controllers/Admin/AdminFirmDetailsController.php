<?php

namespace App\Http\Controllers\Admin;

use App\ProtocolPersonal;
use App\WorkTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Firm;
use App\Image;
use Illuminate\Support\Facades\Gate;

class AdminFirmDetailsController extends AdminController
{
	/**
	 * Firm info page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function firmdetails()
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}
		$this->data['firm_info'] = Firm::getFirmDetails($this->firmLink);
		$this->data['about_us'] = Firm::where('firmlink', $this->firmLink)->first();
		$this->data['firmlogo'] = Image::where('admin_id', $this->idAdmin)->first();

		return view('admin.firmdetails', $this->data);
	}

	/**
	 * Get firm info data for edit
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getFirmDetails()
	{
		$firm_details = Firm::getFirmDetails($this->firmLink);

		return response()->json($firm_details);
	}

	/**
	 * Set firm info data
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setFirmDetails(Request $request)
	{
		\DB::beginTransaction();
		try {
			ProtocolPersonal::protocolAdminFirmChange($this->idAdmin, array('firm_name', 'firm_telnumber'), $request);
			Firm::where('firmlink', $this->firmLink)->first()->update($request->all());

			\DB::commit();

			return redirect()->back();
		} catch (\Exception $e) {
			\DB::rollBack();

			return redirect()->back();
		}
	}

	/**
	 * Update about us block
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function editAboutUs(Request $request)
	{
		\DB::beginTransaction();
		try {
			ProtocolPersonal::protocolAdminFirmChange($this->idAdmin, array('about_us'), $request);
			Firm::where('firmlink', $this->firmLink)->first()->update($request->all());
			\DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			\DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Edit firm logo
	 *
	 * @param Requests\StoreLogo $request
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed|string
	 */
	public function editLogo(Requests\StoreLogo $request)
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		if (!Image::addLogo($this->idAdmin, $request)) {
			return response()->json(false);
		};

		return Image::where('admin_id', $this->idAdmin)->first()->firm_logo;
	}

	/**
	 * Get work times for edit
	 *
	 * @param Request $request
	 * @param         $domain
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getWorkTimes($domain)
	{
		$work_times = WorkTime::where('firmlink', $domain)->get();

		$work_times->each(function ($item) {
			if ($item->from === '00:00:00' && $item->to === '00:00:00') {
				return $item->close = true;
			}
		});

		return response()->json($work_times);

	}

	/**
	 * Update firm work times
	 *
	 * @param Request $request
	 * @param         $domain
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setWorkTimes(Request $request, $domain)
	{
		$editInfo = $request->worktimes;
		WorkTime::where('firmlink', $domain)->delete();
		for ($i = 0; $i < 7; $i++) {
			WorkTime::create(['from'      => $editInfo[$i]['from'],
			                  'to'        => $editInfo[$i]['to'],
			                  'index_day' => $i,
			                  'firmlink'  => $domain]);
		}

		return response()->json(true);
	}

	/**
	 * Update firm Address
	 *
	 * @param Request $request
	 */
	public function editAdress(Request $request)
	{
		Firm::where('firmlink', $this->firmLink)->update(array($request->all()));
	}
}
