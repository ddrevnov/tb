<?php

namespace App\Http\Controllers\Director\Admins;

use App\Avatar;
use App\CalendarConfig;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Requests\StoreNewAdmin;
use App\ProtocolPersonal;
use App\Tarif;
use App\TariffAdminJournal;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Firm;
use App\BankDetails;
use App\FirmType;

class DirectorNewAdminController extends DirectorController
{
	/**
	 * Page with new admin info
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
    public function adminInfoNew(Request $request)
    {
        $newAdminId = $request->id;

        if (isset($_GET['status'])) {
            if ($_GET['status'] === 'active') {

                \DB::beginTransaction();
                try{
                    $adminData = Admin::find($newAdminId);
                    $userId = User::storeAdmin($adminData->toArray(), $adminData->email);
                    $adminData->update(['user_id' => $userId, 'status' => 'active']);
                    $adminData->save();
                    BankDetails::create(['admin_id' => $adminData['id']]);
                    Firm::create(['firmlink' => $adminData['firmlink']]);
                    CalendarConfig::create(['admin_id' => $newAdminId]);
                    \DB::commit();
                }catch (\Exception $e){
                    \DB::rollBack();
                    return redirect(route('director'))->with('status', 'Admin not store');
                }
                return redirect(route('director'))->with('status', 'Admin approved');
            } else {
                Admin::find($request->id)->delete();
                return redirect(route('director'))->with('status', 'Admin deleted');
            }
        }
        $this->data['newAdminInfo'] = Admin::find($newAdminId);

        return view('director.admin_info_new', $this->data);
    }

	/**
	 * Create new admin page by director
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function createAdmin()
    {
        $this->data['firmType'] = FirmType::get();
        $this->data['tariffs'] = Tarif::where('status', 1)->get();
        return view('director.admin_create', $this->data);
    }

	/**
	 * Store new admin by director
	 *
	 * @param StoreNewAdmin $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function newAdminStore(StoreNewAdmin $request)
    {
        $data = $request->all();
        $data['user_status'] = 'admin';

        \DB::beginTransaction();
        try {
            $userId = User::storeAdmin($data, $data['email']);
            $data['user_id'] = $userId;
            $admin = Admin::create($data);
            Avatar::storeAvatar($userId, $request);
            Firm::addNewFirm($data['firmlink']);
            BankDetails::addNewBankDetails($admin->id);
            $tariff = Tarif::find($request->tariff)->toArray();
            $tariff['admin_id'] = $admin->id;
            TariffAdminJournal::create($tariff);

	        ProtocolPersonal::protocolAdminStore($admin->id);

            \DB::commit();
        }catch (\Exception $e){
            \DB::rollBack();

            \Log::error($e);
        }

        return redirect('/backend/admins');
    }

}
