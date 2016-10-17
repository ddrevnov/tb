<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ProtocolEmployee
 *
 * @property integer        $id
 * @property integer        $admin_id
 * @property integer        $employee_id
 * @property string         $author
 * @property string         $type
 * @property string         $old_value
 * @property string         $new_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereOldValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereNewValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolEmployee whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Admin $admin
 * @property-read \App\Employee $employee
 */
class ProtocolEmployee extends Model
{
	protected $table = 'protocol_employees';
	protected $fillable = ['admin_id', 'employee_id', 'author', 'type', 'old_value', 'new_value'];

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
	 * Relation one protocol has one employee
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function employee()
	{
		return $this->hasOne(\App\Employee::class, 'id', 'employee_id');
	}

	/**
	 * Protocol new admin employee
	 *
	 * @param null|integer $admin_id
	 * @param null|Request $request
	 * @param string       $author
	 *
	 * @return bool
	 */
	public static function protocolAdminEmployeeCreate($admin_id = null, $employee_id,
	                                                   $request = null, $author = 'admin')
	{
		if ($admin_id) {
			self::create([
				'admin_id'  => $admin_id,
				'employee_id' => $employee_id,
				'author'    => $author,
				'type'      => 'create_employee',
				'new_value' => $request['name'],
			]);

		}

		return false;
	}

	/**
	 * Protocol all changes from admin employee
	 *
	 * @param null|integer $admin_id
	 * @param null|array   $change_values
	 * @param null|Request $request
	 * @param string       $author
	 */
	public static function protocolAdminEmployeeChange($admin_id = null, $employee_id = null, $change_values = null,
	                                                   $request = null, $author = 'admin')
	{
		if ($admin_id) {

			$old_values = Employee::select($change_values)->find($employee_id)->toArray();
			$new_values = $request->all();
			$diffs = array_keys(array_diff($old_values, $new_values));

			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'    => $admin_id,
						'employee_id' => $employee_id,
						'author'      => $author,
						'type'        => 'change_employee_' . $diff,
						'old_value'   => $old_values[$diff],
						'new_value'   => $new_values[$diff],
					]);
				}
			}
		}
	}
}
