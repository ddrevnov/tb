<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CalendarConfig
 *
 * @property integer $id
 * @property integer $admin_id
 * @property integer $h_reminder
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereHReminder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property boolean $send_sms
 * @property integer $sms_reminder
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereSendSms($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereSmsReminder($value)
 * @property boolean $send_email
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarConfig whereSendEmail($value)
 */
class CalendarConfig extends Model
{
    protected $table = 'calendar_config';
    protected $fillable = ['admin_id', 'h_reminder', 'send_email','send_sms', 'sms_reminder'];

	/**
	 * Parse boolean send sms to int
	 *
	 * @param $value
	 *
	 * @return int
	 */
	public function getSendSmsAttribute($value)
	{
		return intval($value);
	}
}
