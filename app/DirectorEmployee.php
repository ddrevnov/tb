<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\DirectorEmployee
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property string $avatar
 * @property string $phone
 * @property string $email
 * @property string $gender
 * @property string $birthday
 * @property string $group
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $last_name
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee whereLastName($value)
 * @property-read \App\Avatar $avatarEmployee
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorEmployee exceptDirector()
 */
class DirectorEmployee extends Model
{
    protected $table = 'director_employees';
    protected $fillable = ['user_id','phone','email','gender','birthday','name','last_name', 'group','status'];

	/**
	 * Set director employee birthday in right format
	 *
	 * @param $value
	 */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = \DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

	/**
	 * Get director employee birthday in right format
	 *
	 * @param $value
	 *
	 * @return bool|string
	 */
    public function getBirthdayAttribute($value)
    {
        return date_format(date_create($value), "d/m/Y");
    }

	/**
	 * Scope return all director employees except main director
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeExceptDirector($query)
	{
		return $query->where('group', '!=', 'main');
    }

	/**
	 * Relation director employee to his avatar
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function avatarEmployee()
	{
		return $this->belongsTo(\App\Avatar::class, 'user_id', 'user_id');
    }

    public function getDirectorEmployeeNewMessage()
    {
        $employee = self::where('director_employees.status', 'active')
                        ->where('director_employees.user_id', '!=', Auth::id())
                        ->leftJoin('avatars', 'director_employees.user_id', '=', 'avatars.user_id')
                        ->join('users', 'director_employees.user_id', '=', 'users.id')
                        ->select('users.id', 'director_employees.name', 'director_employees.email',
                            'director_employees.user_id', 'avatars.path')->get();

        $employeeInfo = [];
        if(! $employee->isEmpty())
        {
            for ($i = 0; $i < count($employee); $i++)
            {
                $employeeInfo[$i]['id'] = $employee[$i]->id;
                $employeeInfo[$i]['name'] = $employee[$i]->name;
                $employeeInfo[$i]['email'] = $employee[$i]->email;
                $employeeInfo[$i]['path'] = $employee[$i]->path;
                $employeeInfo[$i]['last_new_message'] = Chat_massage::getMessageFromEmployee($employee[$i]->user_id);
                $employeeInfo[$i]['count_new_message'] = Chat_massage::where(['from' => $employee[$i]->id, 'to' => Auth::id(), 'status' => 1])->count();
            }
        }

        return $employeeInfo;
    }

//    public static function getDirectorEmployeeList()
//    {
//        return self::where('group', '!=', 'main')
//                    ->join('avatars', 'director_employees.user_id', '=', 'avatars.user_id')
//                    ->select('director_employees.id', 'director_employees.phone', 'director_employees.email',
//                    'director_employees.name','director_employees.group', 'director_employees.status', 'avatars.path')
//            ->paginate(15);
//    }
    
    public static function getDirectorPersonalInfo($userId)
    {
        return self::where('user_id', $userId)->first();    
    }

}
