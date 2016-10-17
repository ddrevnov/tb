<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\DirectorEmployee;
use App\DirectorNotice;
use App\Employee;
use App\ProtocolPersonal;
use App\Services;
use App\Tarif;
use App\TariffAdminJournal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AdminTariffController extends AdminController
{
	/**
	 * Current tariff page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function currentTariff()
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }
        $tariff = TariffAdminJournal::where('admin_id', $this->idAdmin)->first();

        //проверка условий тарифа
        if($tariff->letters_unlimited){
            $this->data['letters'] = 'Unlimited';
        }else{
            $this->data['letters'] = $tariff->letters_count;
        }

        if($tariff->employee_unlimited){
            $this->data['employee'] = 'Unlimited';
        }else{
            $this->data['employee'] = $tariff->employee_count + Employee::where('admin_id', $this->idAdmin)->count();
        }

        if($tariff->services_unlimited){
            $this->data['services'] = 'Unlimited';
        }else{
            $this->data['services'] = $tariff->services_count + Services::where('admin_id', $this->idAdmin)->count();
        }

        if($tariff->dashboard_unlimited){
            $this->data['dashboard'] = 'Unlimited';
        }else{
            $this->data['dashboard'] = $tariff->dashboard_count;
        }

        $this->data['registered_from'] = date('d-m-Y', strtotime(Admin::find($this->idAdmin)->created_at));
        $this->data['tariff_from'] = $tariff->created_at;
        $this->data['tariff_to_year'] = $tariff->valid_before;
        $this->data['price'] = $tariff->price;
        $this->data['tariff_name'] = $tariff->name;
        $this->data['tariff_type']  =  $tariff->type;
        $this->data['tariff_description']  =  $tariff->description;
        $this->data['admin'] = Admin::find($this->idAdmin);

        return view('admin.tariff', $this->data);
    }

	/**
	 * Get all tariff for change
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getTariffs()
    {
        $tariffs = Tarif::where(['status' => 1, 'type' => 'paid'])->get();
        return response()->json($tariffs, 200, [], JSON_NUMERIC_CHECK);
    }

	/**
	 * Change tariff with recalculate admin balance
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function changeTariff(Request $request)
    {
        $new_tariff = Tarif::find($request->id);
        $old_tariff = TariffAdminJournal::where('admin_id', $this->idAdmin)->first();

        $active_employee = Employee::where(['admin_id' => $this->idAdmin, 'status' => 'active'])->get()->count('id');
        $active_services = Services::where(['admin_id' => $this->idAdmin, 'service_status' => 1])->get()->count('id');

        if(!$new_tariff->employee_unlimited){
            if ($new_tariff->employee_count < $active_employee){
                return response()->json(['status' => false, 'reason' => 'employee']);
            }else{
                $new_tariff->employee_count = $new_tariff->employee_count - $active_employee;
            }
        }

        if (!$new_tariff->services_unlimited){
            if ($new_tariff->services_count < $active_services){
                return response()->json(['status' => false, 'reason' => 'services']);
            }else{
                $new_tariff->services_count = $new_tariff->services_count - $active_services;
            }
        }

        if($old_tariff->type === 'free'){
            $new_tariff->created_at = date('Y-m-d H:i:s');
            $new_tariff->balance = $new_tariff->price;
            $new_tariff->next_order = date('Y-m-d', strtotime('+1 month'));
            $new_tariff->duration = (new \DateTime())->diff((new \DateTime())->add(new \DateInterval('P2M')))->days;
            $new_tariff->valid_before = date('Y-m-d', strtotime('+1 year'));
        }else{
        	$new_tariff->created_at = date('Y-m-d', strtotime($old_tariff->created_at));
            $new_tariff->duration = $old_tariff->duration;
        }

        \DB::beginTransaction();
        try{
	        ProtocolPersonal::protocolAdminTariffChange($this->idAdmin, $old_tariff, $new_tariff);
	        DirectorNotice::create(['admin_id' => $this->idAdmin, 'notice_type' => 'change_tariff']);
	        TariffAdminJournal::updateOrCreate(['admin_id' => $this->idAdmin], $new_tariff->toArray());

	        \DB::commit();
        }catch (\Exception $e){
        	\DB::rollBack();

	        return response()->json(['status' => false]);
        }

        return response()->json(['status' => true]);
    }

	/**
	 * Freeze admin profile
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function freezeProfil()
    {
        DirectorNotice::create(['admin_id' => $this->idAdmin, 'notice_type' => 'admin_freeze']);
        $phone = DirectorEmployee::where('group', 'main')->first()->phone;
        
        return response()->json('Thank you for your attention. You must phone to director on number ' . $phone);
    }
}
