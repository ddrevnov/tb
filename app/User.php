<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $status
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @property string $locale
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLocale($value)
 * @property-read \App\Admin $admin
 * @property-read \App\Avatar $avatar
 * @property-read \App\Employee $employee
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * Relation user to admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function admin()
	{
		return $this->hasOne(\App\Admin::class, 'user_id', 'id');
	}

	/**
	 * Relation user to avatar
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function avatar()
	{
		return $this->hasOne(\App\Avatar::class, 'user_id', 'id');
	}

	/**
	 * Relation user to admin employee
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function employee()
	{
		return $this->hasOne(\App\Employee::class, 'user_id', 'id');
	}

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
    
    public static function getEmail($email){
        return self::where('email', $email)->first();
    }

    /**
     * @param $newUserData array
     * @param $passwordHash string
     * @return int
     */
    public static function addNewUser($newUserData, $passwordHash){
        return self::create([
            'name' => $newUserData['firstname'],
            'email' => $newUserData['email'],
            'password' => $passwordHash,
            'status' => $newUserData['user_status']
        ])->id;
    }

    /**
     * @param $oldPass string
     * @param $newPass string
     * @param $userId  int
     * @return bool
     */
    public static function changePassword($oldPass, $newPass, $userId){
        $basePassHash = self::find($userId)->password;

        if(password_verify($oldPass, $basePassHash)){
            $newPassHash = password_hash($newPass, PASSWORD_BCRYPT);
            self::find($userId)->update(['password' => $newPassHash]);
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $newAdminData array
     * @param $email string
     * @return int
     */
    public static function storeAdmin($newAdminData, $email, $locale = 'de')
    {
        $password = str_random(8);

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $id = self::create(['name' => $newAdminData['firstname'], 'email' => $newAdminData['email'],
        'password' => $passwordHash, 'status' => 'admin'])->id;

        Mail::send('emails.welcome',
            [
                'password' => $password,
                'firstname' => $newAdminData['firstname'],
                'lastname' => $newAdminData['lastname'],
                'email' => $newAdminData['email'],
                'gender' => $newAdminData['gender'],
                'firmlink' => $newAdminData['firmlink'] .'.' .env('MAIN_DOMAIN'),
                'locale'    =>  $locale,
            ],
            function($message) use ($newAdminData, $email) {
                $message->from('no-reply@timebox24.com');

                $message->to($email)->subject('Ihr Account wurde erfolgreich aktiviert!');
            });

        return $id;
    }

    /**
     * @param $newUserData array
     * @param $email string
     * @param $fromWho string
     * @return int
     */
    public static function storeUser($newUserData, $email, $fromWho, $locale = 'de')
    {
        $password = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 8; $i++) {
            $rand = mt_rand(0, $max);
            $password .= $characters[$rand];
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $newUserData['password'] = $passwordHash;
        $id = self::create($newUserData)->id;
        $subject = \Lang::get('emails.client_register_subject', [], $locale);
        Mail::send('emails.welcome_client',
            [
                'password' => $password,
                'firstname' => $newUserData['name'],
                'email' => $newUserData['email'],
                'gender' => isset($newUserData['gender']) ? $newUserData['gender'] : '',
                'firmlink' => $fromWho . '.' . env('MAIN_DOMAIN'),
                'locale'    => $locale,
            ],
            function($message) use ($newUserData, $email, $fromWho, $subject) {
            $message->from($fromWho . '@timebox24.com', $fromWho . '@timebox24.com');

            $message->to($email, $newUserData['name'])->subject($subject);
        });

        return $id;
    }

    /**
     * @param $newEmplData array
     * @param $email string
     * @param $fromWho string
     * @return int
     */
    public static function storeAdminEmployee($newEmplData, $email, $fromWho, $locale = 'de'){
        $password = str_random(8);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $newEmplData['password'] = $passwordHash;
        
        if($newEmplData['group'] == 'admin'){
            $newEmplData['status'] = 'admin';
        }else{
            $newEmplData['status'] = 'admin_employee';
        }

        $id = self::create($newEmplData)->id;

        Mail::send('emails.welcome_empl',
            [
                'password' => $password,
                'name' => $newEmplData['name'],
                'gender' => $newEmplData['gender'],
                'email' => $newEmplData['email'],
                'firmlink' => $fromWho . '.' . env('MAIN_DOMAIN'),
                'locale'   => $locale,
            ],
            function($message) use ($newEmplData, $email, $fromWho) {
                $message->from($fromWho . '@timebox24.com', $fromWho . '@timebox24.com');

                $message->to($email, $newEmplData['name'])->subject('emails.employee_register_subject');
            });

        return $id;
    }
    
}
