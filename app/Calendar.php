<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mail;

/**
 * App\Calendar
 *
 * @mixin \Eloquent
 * @property integer            $id
 * @property string             $domain
 * @property string             $color
 * @property string             $description
 * @property string             $time_from
 * @property string             $time_to
 * @property string             $date
 * @property string             $status
 * @property string             $date_deleted
 * @property integer            $employee_id
 * @property integer            $service_id
 * @property integer            $client_id
 * @property integer            $group_id
 * @property boolean            $site
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereTimeFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereTimeTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereDateDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereSite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereUpdatedAt($value)
 * @property-read \App\Services $service
 * @property boolean            $sms
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereSms($value)
 * @property-read \App\Client   $client
 * @property-read \App\Admin    $admin
 * @property boolean $email
 * @property-read \App\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\App\Calendar whereEmail($value)
 */
class Calendar extends Model
{
	protected $table = 'calendar';
	protected $fillable = ['id', 'color', 'description', 'time_from',
		'time_to', 'employee_id', 'service_id', 'client_id', 'group_id',
		'domain', 'date', 'status', 'date_deleted', 'site', 'sms', 'email'];

	/**
	 * Relation one order has one service
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function service()
	{
		return $this->hasOne(\App\Services::class, 'id', 'service_id');
	}

	/**
	 * Relation one calendar cart to client
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function client()
	{
		return $this->belongsTo(\App\Client::class, 'client_id', 'id');
	}

	/**
	 * Relation one calendar cart to admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function admin()
	{
		return $this->belongsTo(\App\Admin::class, 'domain', 'firmlink');
	}

	/**
	 * Relation one cart has one employee
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function employee()
	{
		return $this->belongsTo(\App\Employee::class, 'employee_id', 'id');
	}

	public function getCalendar($nameDomain, $dates, $id, $cart_id = 0)
	{
		if (Auth::user()->status == 'admin' || Auth::user()->status == 'admin_employee') {
			$calendar = self::where('domain', $nameDomain)
				->where('employee_id', $id)
				->where('calendar.id', '!=', $cart_id)
				->where('calendar.status', 'active')
				->whereIn('date', $dates)
				->join('employees', 'calendar.employee_id', '=', 'employees.id')
				->leftJoin('services', 'services.id', '=', 'calendar.service_id')
				->leftJoin('clients', 'calendar.client_id', '=', 'clients.id')
				->select('calendar.id', 'calendar.color', 'calendar.description', 'calendar.time_from',
					'calendar.time_to', 'calendar.date', 'employees.name', 'clients.first_name',
					'clients.last_name', 'clients.telephone', 'clients.mobile', 'clients.email',
					'calendar.service_id', 'services.service_name', 'calendar.group_id', 'calendar.email as send_email',
					'calendar.sms as send_sms')
				->get();

			return $calendar;
		}

		$calendar = self::where(['domain' => $nameDomain, 'employees.email' => Auth::user()->email])
			->join('employees', 'calendar.employee_id', '=', 'employees.id')
			->select('color', 'description', 'time_from', 'time_to', 'date', 'employees.name')
			->get();

		return $calendar;
	}

	public function getHoliday($nameDomain, $dates, $id, $group_id = 0)
	{
		$calendar = self::where('domain', $nameDomain)
			->where('employee_id', $id)
			->where('calendar.group_id', '!=', $group_id)
			->where('calendar.status', 'holiday')
			->whereIn('date', $dates)
			->join('employees', 'calendar.employee_id', '=', 'employees.id')
			->leftJoin('services', 'services.id', '=', 'calendar.service_id')
			->leftJoin('clients', 'calendar.client_id', '=', 'clients.id')
			->select('calendar.id', 'calendar.color', 'calendar.description', 'calendar.time_from',
				'calendar.time_to', 'calendar.date', 'employees.name', 'clients.first_name',
				'clients.last_name', 'clients.telephone', 'clients.mobile', 'clients.email',
				'calendar.service_id', 'services.service_name', 'calendar.group_id')
			->get();

		return $calendar;
	}

	public function checkTime($nameDomain, $date, $id)
	{
		$time = self::where(['domain' => $nameDomain, 'employee_id' => $id, 'status' => 'active'])
			->whereIn('date', $date)
			->select('time_from', 'time_to')
			->get();

		return $time;
	}

	public static function getInfoForConfirmEmail($cartId, $nameDomain)
	{
		$calendar = self::where('domain', $nameDomain)
			->where('calendar.id', $cartId)
			->join('employees', 'calendar.employee_id', '=', 'employees.id')
			->join('services', 'calendar.service_id', '=', 'services.id')
			->leftJoin('avatars', 'avatars.user_id', '=', 'employees.user_id')
			->join('firmdetails', 'firmdetails.firmlink', '=', 'calendar.domain')
			->leftJoin('clients', 'calendar.client_id', '=', 'clients.id')
			->join('users', 'users.id', '=', 'clients.user_id')
			->select('calendar.description', 'calendar.time_from', 'calendar.time_to', 'calendar.date', 'employees.name',
				'clients.first_name', 'clients.last_name', 'clients.email', 'services.service_name', 'services.price',
				'services.duration', 'services.description as service_description', 'avatars.path', 'firmdetails.street',
				'firmdetails.post_index', 'firmdetails.country', 'clients.gender', 'users.locale')
			->first();

		return $calendar;
	}

	public static function getCalendarOrders($domain)
	{
		return self::where('domain', $domain)
			->join('services', 'calendar.service_id', '=', 'services.id')
			->join('employees', 'calendar.employee_id', '=', 'employees.id')
			->join('clients', 'calendar.client_id', '=', 'clients.id')
			->select('calendar.id', 'calendar.domain', 'calendar.date', 'calendar.color',
				'calendar.description', 'calendar.time_from', 'calendar.time_to', 'calendar.employee_id',
				'calendar.client_id', 'services.price', 'clients.first_name', 'clients.last_name',
				'employees.name', 'services.service_name', 'calendar.status', 'calendar.date_deleted')
			->orderBy('calendar.created_at', 'desk')->paginate(15);
	}

	public static function getClientOrders($clientId)
	{
		return self::where('client_id', $clientId)
			->join('services', 'calendar.service_id', '=', 'services.id')
			->select('services.service_name', 'services.price')
			->paginate(10);
	}

	public static function getDashboardOrders($domain, $from, $to)
	{
		$from = date('Y-m-d', strtotime('-1 day', strtotime($from)));
		$to = date('Y-m-d', strtotime('+1 day', strtotime($to)));

		return self::where('calendar.domain', $domain)
			->whereNull('calendar.date_deleted')
			->whereNotNull('calendar.service_id')
			->whereBetween('calendar.created_at', array($from, $to))
			->leftJoin('services', 'services.id', '=', 'calendar.service_id')
			->leftJoin('employees', 'employees.id', '=', 'calendar.employee_id')
			->select('employees.id', 'employees.name as first_name', 'employees.last_name', 'services.price')
			->get();
	}

	public static function getPopularGoods($domain, $from, $to)
	{
		$from = date('Y-m-d', strtotime('-1 day', strtotime($from)));
		$to = date('Y-m-d', strtotime('+1 day', strtotime($to)));

		return self::where('calendar.domain', $domain)
			->whereNull('calendar.date_deleted')
			->whereNotNull('calendar.service_id')
			->whereBetween('calendar.created_at', array($from, $to))
			->leftJoin('services', 'services.id', '=', 'calendar.service_id')
			->lists('calendar.service_id')->sort()->toArray();
	}

	public static function reminderEmailForClient()
	{
		$admins = \App\Admin::where('status', 'active')->get();

		foreach ($admins as $admin) {
			$date = new \DateTime('today');
			$h_reminder = CalendarConfig::where(['admin_id' => $admin->id, 'send_sms' => 1])->first();
			$carts = self::where('domain', $admin->firmlink)->where('status', 'active')->where('email', 1)
				->where(function ($query) use ($date) {
					$query->where('date', $date->format('d/m/Y'))
						->orWhere('date', $date->add(new \DateInterval('P1D'))->format('d/m/Y'))
						->orWhere('date', $date->add(new \DateInterval('P1D'))->format('d/m/Y'));
				})
				->get();

			if (!$carts) {
				break;
			}

			foreach ($carts as $cart) {
				$order_unix_time = \DateTime::createFromFormat('d/m/Y H:i', $cart->date . ' ' . $cart->time_from)->getTimestamp();
				$current_unix_time = strtotime(date('Y-m-d H:i'));

				if ($current_unix_time + $h_reminder->h_reminder * 60 == $order_unix_time) {
					$data = Calendar::getInfoForConfirmEmail($cart->id, $cart->domain)->toArray();
					$data['path'] = public_path() . $data['path'];
					$subject = \Lang::get('emails.remind', [], $data['locale']);

					try {
						Mail::send('emails.remind_order',
							$data,
							function ($message)
							use ($cart, $data, $subject) {
								$message->from($cart->domain . '@timebox24.com', $cart->domain);
								$message->to($data['email'])->subject($subject);
							});
					} catch (\Exception $e) {
						\Log::error($e->getMessage());
					}
				}
			}
		}
	}
}
