<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $telnumber
 * @property string $email
 * @property string $firmname
 * @property string $firmlink
 * @property string $firmtype
 * @property string $tariff
 * @property string $status
 * @property integer $user_id
 * @property string $mobile
 * @property string $skype
 * @property string $gender
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $birthday
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereTelnumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereFirmname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereFirmlink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereFirmtype($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereTariff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereSkype($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedAt($value)
 * @property boolean $email_send
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereEmailSend($value)
 * @property-read \App\Firm $firm
 * @property-read \App\FirmType $firmTypeInfo
 * @property-read \App\TariffAdminJournal $tariffJournal
 * @property-read \App\BankDetails $bankDetails
 * @property-read \App\Image $logo
 * @property-read \App\Avatar $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServicesCategory[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Services[] $services
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\WorkTime[] $workTimes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Slider[] $slides
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProtocolPersonal[] $personalProtocol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProtocolEmployee[] $employeeProtocol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProtocolCategory[] $categoryProtocol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProtocolService[] $serviceProtocol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProtocolNewsletter[] $newsletterProtocol
 * @property-read \App\CalendarConfig $calendarConfig
 * @property-read \App\AdminSMSData $smsData
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SMSJournal[] $smsJournal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderEmployee[] $orderEmployees
 */
class Admin extends Model {

    protected $table = 'admins';
    protected $fillable = ['id', 'firstname', 'lastname', 'telnumber', 'email', 'firmname', 'firmlink', 'firmtype', 'tariff',
        'status', 'user_id', 'mobile', 'skype', 'gender', 'birthday'];

	/**
	 * Change firmlink and domain in lower case for right work
	 *
	 * @param $value
	 */
    public function setFirmlinkAttribute($value)
    {
        $this->attributes['firmlink'] = strtolower($value);
    }

	/**
	 * Set admin birthday in right format
	 *
	 * @param $value
	 */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = \DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

	/**
	 * Get admin birthday in right format
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
	 * Relation admin to user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

	/**
	 * Get firminfo for admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function firm()
	{
		return $this->hasOne(\App\Firm::class, 'firmlink', 'firmlink');
    }

	/**
	 * Relation admin to firmtype
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function firmTypeInfo()
	{
		return $this->hasOne(\App\FirmType::class, 'id', 'firmtype');
    }

	/**
	 * Relation one admin has one tariff
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function tariffJournal()
	{
		return $this->hasOne(\App\TariffJournal::class, 'admin_id', 'id');
    }

	/**
	 * Relation admin to his bank details
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function bankDetails()
	{
		return $this->hasOne(\App\BankDetails::class, 'admin_id', 'id');
    }

	/**
	 * Relation admin to his logo
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function logo()
	{
		return $this->hasOne(\App\Image::class, 'admin_id', 'id');
    }

	/**
	 * Relation admin to his avatar
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function avatar()
	{
		return $this->hasOne(\App\Avatar::class, 'user_id', 'user_id');
	}

	/**
	 * One admin has many employees
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function employees()
	{
		return $this->hasMany(\App\Employee::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many orders
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orders()
	{
		return $this->hasMany(\App\Order::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many order employees rows for calculate total price in next month order
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orderEmployees()
	{
		return $this->hasMany(\App\OrderEmployee::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many categories
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function categories()
	{
		return $this->hasMany(\App\ServicesCategory::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many services
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function services()
	{
		return $this->hasMany(\App\Services::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many work times
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function workTimes()
	{
		return $this->hasMany(\App\WorkTime::class, 'firmlink', 'firmlink');
	}

	/**
	 * Relation one admin has many comments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comments()
	{
		return $this->hasMany(\App\Comment::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many clients
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function clients()
	{
		return $this->belongsToMany(\App\Client::class, 'admins_clients', 'admin_id', 'client_id')->withPivot('email_send');
	}

	/**
	 * Relation one admin has many slides
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function slides()
	{
		return $this->hasMany(\App\Slider::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has one calendar config
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function calendarConfig()
	{
		return $this->hasOne(\App\CalendarConfig::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many protocols
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function personalProtocol()
	{
		return $this->hasMany(\App\ProtocolPersonal::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many employee protocols
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function employeeProtocol()
	{
		return $this->hasMany(\App\ProtocolEmployee::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many categories protocol
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function categoryProtocol()
	{
		return $this->hasMany(\App\ProtocolCategory::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many services protocol
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function serviceProtocol()
	{
		return $this->hasMany(\App\ProtocolService::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many newsletter protocol
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function newsletterProtocol()
	{
		return $this->hasMany(\App\ProtocolNewsletter::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has one sms data
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function smsData()
	{
		return $this->hasOne(\App\AdminSMSData::class, 'admin_id', 'id');
	}

	/**
	 * Relation one admin has many sms journal data
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function smsJournal()
	{
		return $this->hasMany(\App\SMSJournal::class, 'admin_id', 'id');
	}

    public static function getAdminId($userId) {
        return self::where('user_id', $userId)->pluck('id')->first();
    }

    public static function getPersonalInfo($idAdmin) {

        return self::where('id', $idAdmin)->first();
    }

    public static function getAdminIdFromFirmLink($firmLink) {
        return self::where('firmlink', $firmLink)->first()->id;
    }

    public static function setPersonalInfo($idAdmin, $data) {

        $admin = self::where('id', $idAdmin)->first();
        if ($admin) {
            $admin->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'street' => $data['street'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'telnumber' => $data['telnumber'],
                'mobile' => $data['mobile'],
                'email' => $data['email'],
                'skype' => $data['skype'],
                'gender' => $data['gender'],
            ]);
        }
    }

    public static function getFirmLink($idAdmin) {
        return self::where('id', $idAdmin)->pluck('firmlink')->first();
    }

    public static function editContactInfo($idAdmin, $editInfo) {

        $admin = self::where('id', $idAdmin);
        if ($admin) {
            $admin->update([
                'telnumber' => $editInfo['telnumber'],
                'mobile' => $editInfo['mobile'],
                'email' => $editInfo['email'],
                'skype' => $editInfo['skype'],
                'gender' => $editInfo['gender']
            ]);
        }
    }

    public static function editPersonalInfo($idAdmin, $editInfo) {

        $admin = self::where('id', $idAdmin);
        if ($admin) {
            $admin->update([
                'firstname' => $editInfo['firstname'],
                'lastname' => $editInfo['lastname'],
                'street' => $editInfo['street'],
                'city' => $editInfo['city'],
                'state' => $editInfo['state'],
                'country' => $editInfo['country']
            ]);
        }
    }

    public static function editPersonalInfoByDirector($idAdmin, $editInfo) {
        $admin = self::where('id', $idAdmin);

        if ($admin) {
            $admin->update([
                'firstname' => $editInfo['firstname'],
                'lastname' => $editInfo['lastname'],
                'telnumber' => $editInfo['telnumber'],
                'email' => $editInfo['email'],
                'gender' => $editInfo['gender'],
                'birthday' => $editInfo['birthday'],
                'firmtype' => $editInfo['firmtype'],
                'created_at' => $editInfo['created_at'],
                'status' => $editInfo['status'],
                'street' => $editInfo['street'],
                'city' => $editInfo['city'],
                'state' => $editInfo['state'],
                'country' => $editInfo['country']
            ]);
        }
    }

    public static function getNotActiveAdminsList() {
        return self::where('status', 'not active')->orderBy('created_at', 'desc')->get();
    }

    public static function getActiveAdminsList() {
        return self::whereIn('status', ['active', 'blocked'])->paginate(15);
    }

    public static function getActiveAdminInfo($adminId) {
        return self::where('admins.id', $adminId)
                    ->leftJoin('tariffs_admin_journal', 'tariffs_admin_journal.admin_id', '=', 'admins.id')
                    ->leftJoin('firmtype', 'admins.firmtype', '=', 'firmtype.id')
                    ->select('admins.id', 'admins.firstname', 'admins.lastname', 'admins.mobile', 'admins.email',
                            'admins.gender', 'admins.birthday', 'admins.created_at', 'admins.status',
                            'tariffs_admin_journal.name as tariff', 'firmtype.id as firmtype_id', 'firmtype.firmtype',
                            'admins.firmlink', 'admins.firmname', 'admins.email_send')
                    ->first();
    }

    public static function getLastFiveAdmins($from, $to){
        $from = date('Y-m-d', strtotime('-1 day', strtotime($from)));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($to)));
        
        return self::whereBetween('admins.created_at', array($from,$to))
                                ->where('status', '!=','notactive')
                                ->join('firmtype', 'firmtype.id', '=', 'admins.firmtype')
                                ->select('admins.id', 'admins.firstname as first_name', 'admins.lastname as last_name',
                                        'firmtype.firmtype')
                                ->orderBy('created_at', 'desc')
                                ->get()->take(5);
    }

    public static function getAdmins($amount){

            return self::where('status', '!=','notactive')
                ->join('firmtype', 'firmtype.id', '=', 'admins.firmtype')
                ->select('admins.id', 'admins.firstname as first_name', 'admins.lastname as last_name', 'firmtype.firmtype')
                ->orderBy('created_at', 'desc')
                ->get()
                ->take($amount);
        }

}
