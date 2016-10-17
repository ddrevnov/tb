<?php

namespace App\Http\Controllers\Director\Orders;

use App\DirectorBankDetails;
use App\Events\ConfirmBill;
use App\Http\Controllers\Director\DirectorController;
use App\Order;
use App\Traits\OrderToPdfTrait;
use App\Traits\StoreLogoTrait;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use PDF;
use Illuminate\Support\Facades\Mail;

class DirectorOrdersController extends DirectorController
{
	use StoreLogoTrait, OrderToPdfTrait;

	protected $bank_details;

	public function __construct()
	{
		$this->bank_details = DirectorBankDetails::find(1);
		parent::__construct();
	}

	/**
	 * Page skeleton for all director orders
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function orders()
	{
		if (Gate::denies('director')) {
			return redirect()->route('admins');
		}
		$this->data['details'] = $this->bank_details;

		return view('director.orders', $this->data);
	}

	/**
	 * Get page of orders by ajax
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getOrders(Request $request)
	{
		$orders = Order::getOrdersForDirector($request->page);
		$orders->each(function (&$item) {
			return $item->order_number = sprintf('T%05u', $item->id);
		});

		return response()->json(['count' => $orders->count(), 'orders' => $orders]);
	}

	/**
	 * Get director bank details for edit
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getBankDetails()
	{
		return response()->json($this->bank_details);
	}

	/**
	 * Get director legal address for edit by ajax
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getLegalAddress()
	{
		return response()->json($this->bank_details);
	}

	/**
	 * Edit director bank details
	 *
	 * @param Requests\UpdateDirectorBankDetails $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setBankDetails(Requests\UpdateDirectorBankDetails $request)
	{
		$this->bank_details->update($request->all());

		return redirect()->back();
	}

	/**
	 * Edit director legal address
	 *
	 * @param Requests\UpdateDirectorLegalAddress $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setLegalAddress(Requests\UpdateDirectorLegalAddress $request)
	{
		$this->bank_details->update($request->all());

		return redirect()->back();
	}

	/**
	 * Edit director logo
	 *
	 * @param Requests\StoreLogo $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storeLogo(Requests\StoreLogo $request)
	{
		$logo = $this->uploadLogo($request);
		DirectorBankDetails::find(1)->update(['logo' => $logo]);

		return response()->json($logo, 200, [], JSON_UNESCAPED_SLASHES);
	}

	/**
	 * Multiple confirmed pay for orders
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function confirmOrder(Request $request)
	{
		\DB::beginTransaction();

		try{
			$today = date('Y-m-d H:i:s');
			foreach ($request->paid_id as $id) {
				$order = Order::find($id);
				$admin = $order->admin;

//				if ($order->orderSMS()->count()) {
					event(new ConfirmBill($order, $admin, $today));
//					break;
//				}

//				if ($order->status == 'cancel') {
//					$order->update(['status' => 'paid', 'paid_at' => $today]);
//				} else {
//
//					$order->update(['status' => 'paid', 'paid_at' => $today]);
//					$tariff = TariffAdminJournal::where('admin_id', $order->admin_id)->first();
//
//					$days = new \DateTime($order->created_at);
//					$balance = $order->price + $order->extra_price;
//					if ($tariff->duration <= 31) {
//						$days->add(new \DateInterval('P1M'));
//						$days = date('t', strtotime($days->format('Y-m-d')));
//						$tariff->increment('duration', $days);
//						$tariff->increment('balance', $balance);
//					} else {
//						$days->add(new \DateInterval('P2M'));
//						$days = date('t', strtotime($days->format('Y-m-d')));
//						$tariff->increment('balance', $balance);
//						$tariff->update(['duration' => $days]);
//					}
//					Admin::find($order->admin_id)->where('status', 'blocked')->update(['status' => 'active']);
//				}
			}

			\DB::commit();

			return response()->json(true);
		}catch (\Exception $e){
			\DB::rollBack();

			dd($e);

			return response()->json(false);
		}
	}

	/**
	 * Cancel order paid status
	 *
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function cancelOrder(Order $order)
	{
		$order->update(['status' => 'cancel']);

		return response()->json(true);
	}

	/**
	 * Download admin order in PDF
	 *
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function downloadOrder(Order $order)
	{
		$data = $this->dataOrderGenerate($order);
		$order_name = $this->nameOrderGenerate($order);
		$pdf = PDF::loadView('pdf.order', $data);

		return $pdf->download($order_name);
	}

	/**
	 * Send order for admin owner
	 *
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sendOrder(Order $order)
	{
		$data = $this->dataOrderGenerate($order);
		$order_name = $this->nameOrderGenerate($order);
		$pdf = PDF::loadView('pdf.order', $data);
		$locale = $order->admin->user->locale;
		$data_for_email = $order->admin;

		Mail::send('emails.new_order',
			array('firstname' => $data_for_email->firstname, 'locale' => $locale), function ($message) use ($data_for_email, $pdf, $order_name) {
				$message->from('director@timebox24.com');
				$message->to($data_for_email->email)->subject('Ihre Rechnung www.timebox24.com');
				$message->attachData($pdf->output(), $order_name);
			});

		return response()->json(true);
	}

	/**
	 * Search admin order
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function searchOrder(Request $request)
	{
		$from = ($request->from != '')
			? date('Y-m-d', strtotime($request->from . ' -1 days'))
			: date('Y-m-d', strtotime(Order::first()->created_at. ' -1 days'));

		$to = ($request->to != '')
			? date('Y-m-d', strtotime($request->to . ' +1 days'))
			: date('Y-m-d');

		$q = $request->q ?: '';
		/** @noinspection PrintfScanfArgumentsInspection */
		$qb = sscanf($q, 'T%05u')[0];

		$result = Order::join('admins', 'orders.admin_id', '=', 'admins.id')
			->whereBetween('orders.created_at', array($from, $to))
			->where(function ($query) use ($q, $qb) {
				$query->where('admins.firstname', 'LIKE', "%$q%")
					->orWhere('admins.lastname', 'LIKE', "%$q%")
					->orWhere('orders.id', $qb)
					->orWhere('admins.firmlink', 'LIKE', "%$q%");
			})
			->select('orders.id', 'admins.firstname', 'admins.lastname', 'admins.firmlink',
				'orders.price', 'orders.status', 'orders.created_at', 'orders.paid_at')
			->get();

		$result = $result->each(function (&$item) {
			return $item->order_number = sprintf('T%05u', $item->id);
		});

		return response()->json($result);
	}
}
