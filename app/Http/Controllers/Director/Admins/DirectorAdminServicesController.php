<?php

namespace App\Http\Controllers\Director\Admins;

use App\Admin;
use App\Http\Controllers\Director\DirectorController;
use Illuminate\Http\Request;
use App\Services;
use App\ServicesCategory;
use App\Http\Requests\CreateUpdateService;
use App\Http\Requests\CreateUpdateServiceCategory;

class DirectorAdminServicesController extends DirectorController
{
	/**
	 * Get admin services and categories for edit
	 *
	 * @param Admin $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getAdminCategoryServices(Admin $admin)
    {
        $this->data['categoryList'] = $admin->categories()->active()->get();
        $this->data['servicesList'] = $admin->services->each(function ($item){
        	                                                $item->category_name = $item->category->category_name;});

        return response()->json($this->data);
    }

	/**
	 * Create new admin category
	 *
	 * @param CreateUpdateServiceCategory $request
	 * @param Admin                       $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function createServiceCategory(CreateUpdateServiceCategory $request, Admin $admin)
    {
        $admin->categories()->create($request->all());
        return response()->json(true);
    }

	/**
	 * Edit admin category
	 *
	 * @param CreateUpdateServiceCategory $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function editServiceCategory(CreateUpdateServiceCategory $request)
    {
        ServicesCategory::find($request->id)->update($request->all());
        return response()->json(true);
    }

	/**
	 * Set admin category delete value to 1 and status to 0
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function removeServiceCategory(Request $request)
    {
        ServicesCategory::deleteServiceCategory($request->id);
        return response()->json(true);
    }

	/**
	 * Create new admin service
	 *
	 * @param CreateUpdateService $request
	 * @param Admin               $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function createService(CreateUpdateService $request, Admin $admin)
    {
        $admin->services()->create($request->all());
        return response()->json(true);
    }

	/**
	 * Edit admin service
	 *
	 * @param CreateUpdateService $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function editService(CreateUpdateService $request)
    {
        Services::find($request->id)->update($request->all());
        return response()->json(true);
    }

	/**
	 * Update admin service status delete to 1 and status to 0
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function removeService(Request $request)
    {
        Services::deleteService($request->id);
        return response()->json(true);
    }

}
