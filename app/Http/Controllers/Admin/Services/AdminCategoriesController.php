<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Controllers\Admin\AdminController;
use App\ProtocolCategory;
use App\ProtocolPersonal;
use DB;
use Illuminate\Http\Request;
use App\Services;
use App\ServicesCategory;
use App\Http\Requests\CreateUpdateServiceCategory;

class AdminCategoriesController extends AdminController
{
	/**
	 * Create new category of services
	 *
	 * @param CreateUpdateServiceCategory $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function addNewServiceCategory(CreateUpdateServiceCategory $request)
	{
		DB::beginTransaction();
		try {
			$category = $this->admin->categories()->create($request->all());
			ProtocolCategory::protocolAdminCategoryCreate($this->idAdmin, $category->id, $request);
			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}

	}

	/**
	 * Edit admin category of services
	 *
	 * @param CreateUpdateServiceCategory $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function editServiceCategory(CreateUpdateServiceCategory $request)
	{
		DB::beginTransaction();
		try {
			ProtocolCategory::protocolAdminCategoryChange($this->idAdmin, $request->id, array_keys($request->all()), $request);

			ServicesCategory::find($request->id)->update($request->all());
			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Set category delete status
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function removeServiceCategory(Request $request)
	{
		DB::beginTransaction();
		try {
			ProtocolPersonal::protocolAdminCategoryDelete($this->idAdmin, $request->id, $request);
			Services::deleteGroupServices($request->id);
			ServicesCategory::deleteServiceCategory($request->id);
			DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(false);
		}

	}
}
