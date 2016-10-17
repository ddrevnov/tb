<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use Mail as OrderMail;

/**
 * App\Order
 *
 * @property integer $id
 * @property integer $admin_id
 * @property integer $price
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float $extra_price
 * @property string $paid_at
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereExtraPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePaidAt($value)
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order activeOrCancel()
 * @property-read \App\Admin $admin
 * @property-read \App\OrderSMS $orderSMS
 * @method static \Illuminate\Database\Query\Builder|\App\Order new()
 * @method static \Illuminate\Database\Query\Builder|\App\Order old()
 * @property float $tax
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTax($value)
 * @property integer $employee_count
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereEmployeeCount($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderEmployee[] $orderEmployees
 */
class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['admin_id', 'price', 'tax', 'employee_count', 'extra_price', 'status', 'name', 'paid_at'];

	/**
	 * Get created order date in right format
	 *
	 * @param $value
	 *
	 * @return string
	 */
    public function getCreatedAtAttribute($value)
    {
        return (new \DateTime($value))->format('d-m-Y');
    }

	/**
	 * Scope for new and canceled orders for admin
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActiveOrCancel($query)
	{
		return $query->where('status', 'new')
				->orWhere('status', 'cancel');
    }

	/**
	 * Get only new orders
	 *
	 * @param $query
	 */
	public function scopeNew($query)
	{
		$query->where('status', '!=', 'paid')->orderBy('created_at', 'desc');
    }

	/**
	 * Get only old orders
	 *
	 * @param $query
	 */
	public function scopeOld($query)
	{
		$query->where('status', 'paid')->orderBy('created_at', 'desc');
	}

	/**
	 * Relation order to his admin owner
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function admin()
	{
		return $this->belongsTo(\App\Admin::class, 'admin_id', 'id');
    }

	/**
	 * Relation one order can be has one order sms
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function orderSMS()
	{
		return $this->hasOne(\App\OrderSMS::class, 'order_id', 'id');
    }

	/**
	 * Relation one order has many order employees
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orderEmployees()
	{
		return $this->hasMany(\App\OrderEmployee::class, 'order_id', 'id');
    }

    public static function warningOrders()
    {
        $admins = TariffAdminJournal::where('duration', 20)->get();
        if ($admins) {
            foreach ($admins as $admin) {
                $admin->extra_price = ($admin->balance < 0) ? $admin->balance * -1 : 0;
                $order = self::where(['admin_id' => $admin->admin_id, 'status' => 'attention'])->first();
                if ($order) {
                    $order->update(['status' => 'warning']);

                    $data_for_email = Admin::find($admin->admin_id);
                    $data['bank_details'] = DirectorBankDetails::find(1);
                    $data['order_details'] = Order::find($order->id);

                    $data['tariff_name'] = TariffAdminJournal::where('admin_id', $data['order_details']->admin_id)->first()->name;
                    $data['admin_details'] = Admin::find($data['order_details']->admin_id);
                    $data['firm_details'] = Firm::getFirmDetails($data['admin_details']->firmlink);
                    $data['director_details'] = DirectorEmployee::where('group', 'main')->first();
                    $data['extra_price'] = ($admin->extra_price) ? $admin->extra_price : 0;
                    $data['final_sum']  = $data['order_details']->price + $data['extra_price'];
                    if ($data['final_sum'] < 0 ){
                        $data['final_sum']  = 0;
                    }

                    $locale = User::find($data_for_email->user_id)->locale;
                    AdminNotice::create(['notice_type' => 'new_bill', 'admin_id' => $admin->admin_id]);
                    $pdf = PDF::loadView('pdf.order', $data);
                    $order_name = sprintf('T%05u', $order->id) . '_' . $order->created_at . '_Rechung.pdf';

                    OrderMail::send('emails.warning_order',
                        array('firstname' => $data_for_email->firstname, 'locale' => $locale), function ($message) use ($data_for_email, $pdf, $order_name) {
                            $message->from('no-reply@timebox24.com');
                            $message->to($data_for_email->email)->subject('Warning order');
                            $message->attachData($pdf->output(), $order_name);
                        });
                } else {
                    break;
                }

            }
        }
        return true;
    }

    public static function blockingOrders()
    {
        $admins = TariffAdminJournal::where('duration', 1)->get();
        if ($admins) {
            foreach ($admins as $admin) {
                $admin->extra_price = ($admin->balance < 0) ? $admin->balance * -1 : 0;
                $order = self::where(['admin_id' => $admin->admin_id, 'status' => 'warning'])->first();
                if ($order) {

                    $data_for_email = Admin::find($admin->admin_id);
                    $data['bank_details'] = DirectorBankDetails::find(1);
                    $data['order_details'] = Order::find($order->id);

                    $data['tariff_name'] = TariffAdminJournal::where('admin_id', $data['order_details']->admin_id)->first()->name;
                    $data['admin_details'] = Admin::find($data['order_details']->admin_id);
                    $data['firm_details'] = Firm::getFirmDetails($data['admin_details']->firmlink);
                    $data['director_details'] = DirectorEmployee::where('group', 'main')->first();
                    $data['extra_price'] = ($admin->extra_price) ? $admin->extra_price : 0;
                    $data['final_sum']  = $data['order_details']->price + $data['extra_price'];
                    if ($data['final_sum'] < 0 ){
                        $data['final_sum']  = 0;
                    }

                    $locale = User::find($data_for_email->user_id)->locale;
                    $pdf = PDF::loadView('pdf.order', $data);
                    $order_name = sprintf('T%05u', $order->id) . '_' . $order->created_at . '_Rechung.pdf';

                    OrderMail::send('emails.warning_order',
                        array('firstname' => $data_for_email->firstname, 'locale'=> $locale), function ($message) use ($data_for_email, $pdf, $order_name) {
                            $message->from('no-reply@timebox24.com');
                            $message->to($data_for_email->email)->subject('Last order to blocking');
                            $message->attachData($pdf->output(), $order_name);
                        });
                } else {
                    break;
                }

            }
        }
        return true;
    }

    public static function getOrdersForDirector($page)
    {
        return self::join('admins', 'admins.id', '=', 'orders.admin_id')
            ->select('orders.id', 'orders.price', 'orders.status', 'orders.created_at', 'orders.paid_at', 
                'admins.firstname', 'admins.lastname', 'admins.firmlink')
            ->orderBy('created_at', 'desc')->skip(15 * ($page - 1))->take(15)->get();
    }
}
