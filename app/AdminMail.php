<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AdminMail
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $to
 * @property string $from
 * @property string $subject
 * @property string $text
 * @property string $img
 * @property boolean $group
 * @property boolean $send
 * @property integer $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereSubject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereSend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereUpdatedAt($value)
 * @property string $title
 * @property integer $count
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminMail whereCount($value)
 */
class AdminMail extends Model
{
    protected $table = 'admin_mails';
    protected $fillable = ['id', 'to', 'from', 'title','subject', 'text','img', 'group', 'send', 'count', 'admin_id'];
    
    public static function getAllAdminMails($idAdmin){
        return self::where('admin_id', $idAdmin)->orderBy('created_at', 'desk')->paginate(15);
    }
}
