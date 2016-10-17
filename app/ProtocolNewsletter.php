<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProtocolNewsletter
 *
 * @property integer $id
 * @property integer $admin_id
 * @property integer $employee_id
 * @property string $author
 * @property string $type
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Admin $admin
 * @property-read \App\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolNewsletter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProtocolNewsletter extends Model
{
	protected $table = 'protocol_newsletters';
	protected $fillable = ['admin_id', 'employee_id', 'author', 'type', 'title'];

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

	public static function protocolAdminSendNewsletter($admin_id = null, $title, $employee_id = null, $author = 'admin', $type = 'send_newsletter')
	{
		if ($admin_id){
			self::create([
				'admin_id'=> $admin_id,
				'employee_id'=> $employee_id,
				'author'=> $author,
				'type'=> $type,
				'title'=> $title,
			]);
		}
	}
}
