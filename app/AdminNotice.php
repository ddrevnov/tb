<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AdminNotice
 *
 * @property integer $id
 * @property string $notice_type
 * @property integer $admin_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\AdminNotice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminNotice whereNoticeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminNotice whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminNotice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminNotice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminNotice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminNotice extends Model
{
    protected $table = 'admin_notice';
    protected $fillable = ['notice_type', 'admin_id', 'status'];
}
