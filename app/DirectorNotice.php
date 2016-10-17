<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DirectorNotice
 *
 * @property integer $id
 * @property string $notice_type
 * @property integer $admin_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorNotice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorNotice whereNoticeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorNotice whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorNotice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorNotice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorNotice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DirectorNotice extends Model
{
    protected $table = 'director_notice';
    protected $fillable = ['notice_type', 'admin_id', 'status'];

    public static function getNotices()
    {
        return self::join('admins', 'admins.id', '=', 'director_notice.admin_id')
                    ->leftJoin('avatars', 'avatars.user_id', '=', 'admins.user_id')
                    ->select('director_notice.id', 'admins.id as admin_id', 'admins.firstname', 'admins.lastname', 
                        'director_notice.notice_type', 'director_notice.created_at', 'avatars.path');
    }
}
