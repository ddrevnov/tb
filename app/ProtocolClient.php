<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProtocolClient
 *
 * @property integer        $id
 * @property integer        $admin_id
 * @property integer        $client_id
 * @property string         $author
 * @property string         $type
 * @property string         $old_value
 * @property string         $new_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereOldValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereNewValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolClient whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Admin $admin
 * @property-read \App\Client $client
 */
class ProtocolClient extends Model
{
	protected $table = 'protocol_clients';
	protected $fillable = ['admin_id', 'client_id', 'author', 'type', 'old_value', 'new_value'];

	/**
	 * Relation one protocol has one admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function admin()
	{
		return $this->hasOne(\App\Admin::class, 'id', 'admin_id');
	}

	/**
	 * Relation one protocol has one client
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function client()
	{
		return $this->hasOne(\App\Client::class, 'id', 'admin_id');
	}

	/**
	 * Protocol all changed in admin personal info
	 *
	 * @param null|integer $admin_id
	 * @param null|Request $request
	 *
	 * @return bool
	 */
	public static function protocolClientPersonalChange($admin_id = null, $client_id, $change_values = null,
	                                                    $request = null, $author = 'admin')
	{
		if ($admin_id) {
			$old_values = Client::select($change_values)->find($client_id)->toArray();
			$new_values = $request->all();

			$diffs = array_keys(array_diff($old_values, $new_values));

			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'  => $admin_id,
						'client_id' => $client_id,
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

	public static function protocolClientOrder($admin_id = null, $client_id, $cart_id, $author = 'admin', $action = 'create')
	{
		if ($admin_id) {
			self::create([
				'admin_id'  => $admin_id,
				'client_id' => $client_id,
				'author'    => $author,
				'type'      => $action . '_order',
				'new_value' => 'order ' . $cart_id,
			]);
		}
	}

	public static function protocolClientCreate($admin_id = null, $client_id, $name, $author = 'admin')
	{
		if ($admin_id) {
			self::create([
				'admin_id'  => $admin_id,
				'client_id' => $client_id,
				'author'    => $author,
				'type'      => 'create_client',
				'new_value' => $name,
			]);
		return true;
		}
		return false;
	}
}
