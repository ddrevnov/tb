<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\ProtocolPersonal;
use App\Traits\OrderToPdfTrait;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\BankDetails;
use Illuminate\Support\Facades\Gate;
use PDF;

class AdminBillingController extends AdminController
{
	use OrderToPdfTrait;

	/**
	 * Page with orders and bank data
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function billing()
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		$this->data['orders_new'] = $this->admin->orders()->new()->get();
		$this->data['orders_old'] = $this->admin->orders()->old()->get();

		return view('admin.billing', $this->data);
	}

	/**
	 * Download order pdf file
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
	 */
	public function downloadOrder(Request $request)
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		$order = Order::find($request->id);
		$data = $this->dataOrderGenerate($order);
		$order_name = $this->nameOrderGenerate($order);
		$pdf = PDF::loadView('pdf.order', $data);

		return $pdf->download($order_name);
	}

	/**
	 * Get admin bank details for edit
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getBankDetails()
	{
		$bank_details = BankDetails::getBankDetails($this->idAdmin);

		return response()->json($bank_details);
	}

	/**
	 * Update admin bank details
	 *
	 * @param Requests\UpdateBankDetails $request
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception fail transaction
	 */
	public function setBankDetails(Requests\UpdateBankDetails $request)
	{
		if (Gate::denies('admin')) {
			return redirect('/office/orders_list');
		}

		\DB::beginTransaction();
		try {
			ProtocolPersonal::protocolAdminBankChange($this->idAdmin, array_keys($request->all()), $request);
			BankDetails::where('admin_id', $this->idAdmin)->update($request->all());
			\DB::commit();

			return response()->json(true);
		} catch (\Exception $e) {
			\DB::rollBack();

			return response()->json(false);
		}
	}

	/**
	 * Discard admin for bank auto withdraw
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refusal()
	{
		BankDetails::where('admin_id', $this->idAdmin)->update(['agreement' => 0]);

		return response()->json(true);
	}


	/**
	 * Download document
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function document()
	{
		$pdf = PDF::loadView('pdf.document');

		return $pdf->download('document.pdf');
	}
}
