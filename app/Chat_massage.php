<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chat_massage
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $massage
 * @property integer $to
 * @property integer $from
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereMassage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chat_massage whereUpdatedAt($value)
 */
class Chat_massage extends Model
{
    protected $table = 'chat_massages';
    protected $fillable = ['id','massage','to','from','status'];

    /**
     * @param $user_id
     * @return mixed|null
     */
    public static function getMessageFromEmployee($user_id)
    {
        $message = self::where(['from' => $user_id, 'status' => 1])->select('massage', 'created_at')->first();
        return ! is_null($message) ? $message->toArray() : null;
    }


    /**
     * @param $id_post
     */
    public function setOldPost($id_post)
    {
        self::find($id_post)->update(['status' => 1]);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getDashboardLastMessages($user_id)
    {
        return self::where('chat_massages.to', $user_id)
                    ->leftJoin('avatars', 'avatars.user_id', '=', 'chat_massages.from')
                    ->leftJoin('admins', 'admins.user_id', '=', 'chat_massages.from')
                    ->leftJoin('employees', 'employees.user_id', '=', 'chat_massages.from')
                    ->leftJoin('director_employees', 'director_employees.user_id', '=', 'chat_massages.from')
                    ->select('chat_massages.from', 'avatars.path', 'admins.firstname as admin_first_name', 'admins.lastname as admin_last_name',
                            'employees.name as employee_first_name', 'employees.last_name as employee_last_name', 'director_employees.name as dir_first_name',
                            'director_employees.last_name as dir_last_name', 'chat_massages.massage', 'chat_massages.created_at'
                        )
                    ->orderBy('chat_massages.created_at', 'desc')->get()->take(5);
    }
}
