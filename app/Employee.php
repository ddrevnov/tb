<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Employee
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property string $avatar
 * @property string $phone
 * @property string $email
 * @property string $gender
 * @property string $birthday
 * @property integer $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $last_name
 * @property string $group
 * @property string $status
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereStatus($value)
 * @property-read \App\Avatar $avatarEmployee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Services[] $servicesEmployee
 * @property-read \App\Admin $admin
 * @property-read \App\User $userEmployee
 */
class Employee extends Model {

    protected $table = 'employees';
    protected $fillable = ['user_id', 'phone', 'email', 'gender', 'birthday', 'admin_id', 'name', 'group', 'status', 'last_name'];

	/**
	 * Set employee birthday in right format
	 *
	 * @param $value
	 */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = \DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

	/**
	 * Get employee birthday in right format
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
	 * Relation employee to his avatar
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function avatarEmployee()
	{
		return $this->hasOne(\App\Avatar::class, 'user_id', 'user_id');
    }

	/**
	 * Relation many employee have many services
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function servicesEmployee()
	{
		return $this->belongsToMany(\App\Services::class, 'employee_servises', 'employee_id', 'service_id');
    }

	/**
	 * Relation employee to admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function admin()
	{
		return $this->belongsTo(\App\Admin::class, 'admin_id', 'id');
    }

	/**
	 * Relation employee to user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function userEmployee()
	{
		return $this->hasOne(\App\User::class, 'id', 'user_id');
    }


    public static function getEmployeeId($userId){
        return self::where('user_id', $userId)->first()->admin_id;
    }

    public static function getEmployeeInfo($employeeId){
        return self::where('employees.id', $employeeId)
                    ->leftJoin('avatars', 'employees.user_id', '=', 'avatars.user_id')
                    ->select('employees.id', 'avatars.path', 'employees.phone', 'employees.name',
                        'employees.email', 'employees.group', 'employees.status', 'employees.admin_id',
                        'employees.last_name', 'employees.gender', 'employees.birthday')
                    ->first();
    }

//    public static function getEmployeesList($adminId){
//        return self::where('employees.admin_id', $adminId)
//                            ->leftJoin('avatars', 'employees.user_id', '=', 'avatars.user_id')
//                            ->select('employees.id', 'avatars.path', 'employees.phone',
//                                    'employees.name', 'employees.email', 'employees.group', 'employees.status')
//                            ->paginate(15);
//    }

    public static function getEmployeesActive($adminId){
        return self::where(['employees.admin_id' => $adminId, 'employees.status' => 'active'])
                    ->leftJoin('avatars', 'employees.user_id', '=', 'avatars.user_id')
                    ->select('employees.id', 'avatars.path', 'employees.phone',
                            'employees.name', 'employees.email', 'employees.group', 'employees.status')
                    ->get();
    }

    public static function getAllEmployee($adminId){
        return self::where('employees.admin_id', $adminId)
            ->leftJoin('avatars', 'employees.user_id', '=', 'avatars.user_id')
            ->select('employees.id', 'avatars.path', 'employees.phone', 'employees.name', 'employees.email',
                'employees.group', 'employees.status')
            ->paginate(10);
    }

    public function getEmployeeNewMessage($adminId = 0)
    {
        if(!$adminId) {
            $admins = Admin::where('admins.status', 'active')
                            ->leftJoin('avatars', 'avatars.user_id', '=', 'admins.user_id')
                            ->select('admins.id', 'admins.user_id', 'admins.firstname', 'admins.lastname',
                                    'admins.firmlink', 'admins.email', 'avatars.path')
                            ->get();
        }else{
            $admins = Admin::where('admins.status', 'active')
                            ->where('admins.id', $adminId)
                            ->leftJoin('avatars', 'avatars.user_id', '=', 'admins.user_id')
                            ->select('admins.id', 'admins.user_id', 'admins.firstname', 'admins.lastname',
                                'admins.firmlink', 'admins.email', 'avatars.path')
                            ->get();
        }
        
        $employeeInfo = [];
        if(! $admins->isEmpty())
        {
            foreach ($admins as $admin)
            {
                $employeeInfo[$admin->firmlink]['dir_id'] = $admin->user_id;
                $employeeInfo[$admin->firmlink]['dir_name'] = $admin->firstname. "  " .$admin->lastname;
                $employeeInfo[$admin->firmlink]['dir_mail'] = $admin->email;
                $employeeInfo[$admin->firmlink]['path'] = $admin->path;
                $employeeInfo[$admin->firmlink]['count_new_massage'] = Chat_massage::where(['from' => $adminId, 'to' => Auth::id(), 'status' => 1])->count();
                $employeeInfo[$admin->firmlink]['employee'] = $this->getNewMessageEmployee($admin->id);
            }
        }

        return $employeeInfo;
    }

    private function getNewMessageEmployee($admin_id)
    {
        $employee = self::join('users', 'employees.user_id', '=',  'users.id')
                    ->leftJoin('avatars', 'users.id', '=', 'avatars.user_id')
                    ->where('admin_id', $admin_id)
                    ->select('users.id', 'employees.name', 'employees.email', 'avatars.path')->get();

        if(! $employee->isEmpty())
        {
            foreach ($employee as $item) {
                $item['last_new_massage'] = Chat_massage::getMessageFromEmployee($item->user_id);
                $item['count_new_massage'] = Chat_massage::where(['from' => $item->id, 'to' => Auth::id(), 'status' => 1])->count();
            }

            return $employee->toArray();
        }

        return null;
    }
}
