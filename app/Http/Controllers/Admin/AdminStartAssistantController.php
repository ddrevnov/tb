<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Avatar;
use App\BankDetails;
use App\Firm;
use App\FirmType;
use App\Image;
use App\Tarif;
use App\TariffAdminJournal;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminStartAssistantController extends \App\Http\Controllers\Controller
{
    public $admin_id;

	/**
	 * Get admin id for start assistant
	 *
	 * AdminStartAssistantController constructor.
	 */
    public function __construct()
    {
        $this->admin_id = Admin::where('user_id', Auth::id())->first()->id;
    }

	/**
	 * Start assistant page with checking if admin need start assistant
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function startAssistant()
    {
//        if (TariffAdminJournal::where('admin_id', $this->admin_id)->first()){
//            return redirect('/office');
//        }

        return view('admin.start_assistant');
    }

	/**
	 * Get by ajax start data for start assistant
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getStartData()
    {
        $data['admin_data'] = Admin::where('user_id', Auth::id())->first();
        $data['firmtype'] = FirmType::get();
        $data['tariff'] = Tarif::where('status', 1)->get();
        
        return response()->json($data);
    }

	/**
	 * Store avatar in start assistant
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function storeAvatar(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'avatar'   =>  'image',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        Avatar::storeAvatar(Auth::id(), $request);
        return response()->json(true);
    }

	/**
	 * Store admin logo in start assistant
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function storeLogo(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'firm_logo'   =>  'image',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $request->admin_id = $this->admin_id;
        Image::addLogo($this->admin_id, $request);
        return response()->json(true);
    }

	/**
	 * Confirm new admin in start assistant
	 *
	 * @param Requests\StartAssistant $request
	 * @param                         $domain
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function confirm(Requests\StartAssistant $request, $domain)
    {
        \DB::beginTransaction();
        try{
            $admin = Admin::where('user_id', Auth::id())->first();
            $admin->update($request->all());
            $firm = Firm::where('firmlink', $domain)->first();
            $firm->update($request->all());
	        $admin->tariffJournal()->create(['type' => 'free']);
            BankDetails::where('admin_id', $admin->id)->first()->update($request->all());
            $admin->save();
            \DB::commit();
            return response()->json(true);
        }catch (\Exception $e){
            \DB::rollBack();
            return response()->json(false);
        }
    }
}
