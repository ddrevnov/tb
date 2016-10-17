<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


/**
 * App\ProtocolPersonal
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $author
 * @property string $type
 * @property string $old_value
 * @property string $new_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Admin $admin
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereOldValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereNewValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolPersonal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProtocolPersonal extends Model
{
	protected $table = 'protocol_personal';
	protected $fillable = ['admin_id', 'author', 'type', 'old_value', 'new_value'];

	public $protocol_types = ['change_firstname', 'change_lastname', 'change_mobile', 'change_email', 'change_tariff',
		'freeze_tariff', 'change_about_us', 'change_firm_name',
		'change_account_owner', 'change_bank_name', 'change_iban', 'change_bic', 'change_legal_firm_name'
		, 'create_employee', 'change_employee_name', 'change_employee_last_name', 'change_employee_status',
		'change_employee_group', 'change_employee_phone', 'create_category', 'change_category_name', 'change_category_status',
		'delete_category', 'create_service', 'edit_service_name', 'edit_service_price', 'edit_service_duration',
		'edit_service_description', 'edit_service_status', 'delete_service',
	];

	/**
	 * Relation one protocol has one admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function admin()
	{
		return $this->hasOne(\App\Admin::class, 'id', 'admin_id')->with('avatar');
	}

	/**
	 * Protocol all changed in admin personal info
	 *
	 * @param null|integer $admin_id
	 * @param null|Request $request
	 *
	 * @return bool
	 */
	public static function protocolAdminPersonalChange($admin_id = null, $change_values = null,
	                                                   $request = null, $author = 'admin')
	{
		if ($admin_id) {
			$old_values = Admin::select($change_values)->find($admin_id)->toArray();
			$new_values = $request->all();

			$diffs = array_keys(array_diff($old_values, $new_values));
			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'  => $admin_id,
						'author'    => $author,
						'type'      => 'change_' . $diff,
						'old_value' => $old_values[$diff],
						'new_value' => $new_values[$diff],
					]);
				}
			}

		}

		return false;
	}

	/**
	 * Protocol all changed in admin firm
	 *
	 * @param null|integer $admin_id
	 * @param null|array   $change_values
	 * @param null|Request $request
	 * @param string       $author
	 *
	 * @return bool
	 */
	public static function protocolAdminFirmChange($admin_id = null, $change_values = null,
	                                               $request = null, $author = 'admin')
	{
		if ($admin_id) {

			$old_values = Firm::where('firmlink', Admin::find($admin_id)->firmlink)->select($change_values)->first()->toArray();
			$new_values = $request->all();
			$diffs = array_keys(array_diff($old_values, $new_values));

			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'  => $admin_id,
						'author'    => $author,
						'type'      => 'change_' . $diff,
						'old_value' => $old_values[$diff],
						'new_value' => $new_values[$diff],
					]);
				}
			}

		}

		return false;
	}

	/**
	 * Protocol all change with admin bank details
	 *
	 * @param null|integer $admin_id
	 * @param null|array   $change_values
	 * @param null|Request $request
	 * @param string       $author
	 */
	public static function protocolAdminBankChange($admin_id = null, $change_values = null,
	                                               $request = null, $author = 'admin')
	{
		if ($admin_id) {

			$old_values = BankDetails::where('admin_id', $admin_id)->select($change_values)->first()->toArray();
			$new_values = $request->all();
			$diffs = array_keys(array_diff($old_values, $new_values));

			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'  => $admin_id,
						'author'    => $author,
						'type'      => 'change_' . $diff,
						'old_value' => $old_values[$diff],
						'new_value' => $new_values[$diff],
					]);
				}
			}
		}

		return false;
	}

	public static function protocolAdminTariffChange($admin_id = null, $old_tariff, $new_tariff, $author = 'admin')
	{
		if ($admin_id) {
			self::create([
				'admin_id'  => $admin_id,
				'author'    => $author,
				'type'      => 'change_tariff',
				'old_value' => $old_tariff->name,
				'new_value' => $new_tariff->name,
			]);
		}
	}

	public static function protocolAdminStore($admin_id = null, $author = 'director')
	{
		if ($admin_id){
			self::create([
				'admin_id' => $admin_id,
				'author' => $author,
				'type'  =>  'create_admin',
			]);
		}
	}

}
