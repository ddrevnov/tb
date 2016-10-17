<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AdminSMSData
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property string $title
 * @property string $body
 * @property integer $count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereUpdatedAt($value)
 * @property integer $sent
 * @property boolean $is_notify
 * @property string $notify_type
 * @property integer $sms_balance_notify
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereSent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereIsNotify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereNotifyType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminSMSData whereSmsBalanceNotify($value)
 */
class AdminSMSData extends Model
{
    protected $table = 'admin_sms_data';
	protected $fillable = ['admin_id', 'title', 'body', 'count'];
}
