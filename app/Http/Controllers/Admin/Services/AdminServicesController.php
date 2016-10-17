<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\CreateUpdateService;
use App\ProtocolService;
use App\Services;
use DB;
use Illuminate\Http\Request;

class AdminServicesController extends AdminController
{
	/**
	 * Page skeleton for services and categories
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function services()
	{
		return view('admin.services', $this->data);
	}

	/**
	 * Get admin's services and categories by ajax
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategoryAndServices()
	{
		$this->data['categoryList'] = $this->admin->categories()->active()->get();
		$this->data['servicesList'] = Services::getServicesList($this->idAdmin);

		return response()->json($this->data);
	}

	/**
	 * Create new serivce
	 *
	 * @param CreateUpdateService $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function addNewService(CreateUpdateService $request)
	{
		DB::beginTransaction();
		try {

			$service = $this->admin->services()->create($request->all());
			ProtocolService::protocolAdminServiceCreate($this->idAdmin, $service->id, $request);
			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Set service status delete
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function removeService(Request $request)
	{
		DB::beginTransaction();
		try {
			Services::find($request->id)->update(['service_delete' => 1, 'service_status' => 0]);
			ProtocolService::protocolAdminCategoryDelete($this->idAdmin, $request->id, $request);

			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Edit service witch check tariff
	 *
	 * @param CreateUpdateService $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function editService(CreateUpdateService $request)
	{
		DB::beginTransaction();
		try {

			ProtocolService::protocolAdminServiceChange($this->idAdmin, $request->id, array_keys($request->all()), $request);
			Services::find($request->id)->update($request->all());

			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}
	}
}
