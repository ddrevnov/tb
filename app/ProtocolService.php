<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProtocolService
 *
 * @property integer        $id
 * @property integer        $admin_id
 * @property integer        $service_id
 * @property string         $author
 * @property string         $type
 * @property string         $old_value
 * @property string         $new_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereOldValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereNewValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolService whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Admin $admin
 * @property-read \App\Services $service
 */
class ProtocolService extends Model
{
	protected $table = 'protocol_services';
	protected $fillable = ['admin_id', 'service_id', 'author', 'type', 'old_value', 'new_value'];

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
	 * Relation one protocol has one service
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function service()
	{
		return $this->hasOne(\App\Services::class, 'id', 'service_id');
	}

	/**
	 * Protocol admin new service
	 *
	 * @param null|integer $admin_id
	 * @param null|Request $request
	 * @param string       $author
	 *
	 * @return bool
	 */
	public static function protocolAdminServiceCreate($admin_id = null, $service_id, $request = null, $author = 'admin')
	{
		if ($admin_id) {
			self::create([
				'admin_id'   => $admin_id,
				'service_id' => $service_id,
				'author'     => $author,
				'type'       => 'create_service',
				'new_value'  => $request['service_name'],
			]);

		}

		return false;
	}

	/**
	 * Protocol admin change service
	 *
	 * @param null|integer $admin_id
	 * @param null|integer $service_id
	 * @param null|array   $change_values
	 * @param null|Request $request
	 * @param string       $author
	 */
	public static function protocolAdminServiceChange($admin_id = null, $service_id = null, $change_values = null,
	                                                  $request = null, $author = 'admin')
	{
		if ($admin_id) {

			$old_values = Services::select($change_values)->find($service_id)->toArray();
			$new_values = $request->all();
			$diffs = array_keys(array_diff($old_values, $new_values));

			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'   => $admin_id,
						'service_id' => $service_id,
						'author'     => $author,
						'type'       => 'change_service_' . $diff,
						'old_value'  => $old_values[$diff],
						'new_value'  => $new_values[$diff],
					]);
				}
			}
		}
	}

	/**
	 * Protocol admin delete service
	 *
	 * @param null   $admin_id
	 * @param        $service_id
	 * @param null   $request
	 * @param string $author
	 *
	 * @return bool
	 */
	public static function protocolAdminCategoryDelete($admin_id = null, $service_id, $request = null, $author = 'admin')
	{
		if ($admin_id) {
			$service_name = Services::find($request->id)->service_name;
			self::create([
				'admin_id'   => $admin_id,
				'service_id' => $service_id,
				'author'     => $author,
				'type'       => 'delete_service',
				'new_value'  => $service_name,
			]);

		}

		return false;
	}
}
