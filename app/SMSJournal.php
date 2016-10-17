<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SMSJournal
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property integer $client_id
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSJournal whereUpdatedAt($value)
 */
class SMSJournal extends Model
{
    protected $table = 'sms_journal';
	protected $fillable = ['admin_id', 'client_id', 'title', 'body'];
}
