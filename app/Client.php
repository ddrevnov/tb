<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Client
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $gender
 * @property string $first_name
 * @property string $last_name
 * @property string $telephone
 * @property string $mobile
 * @property string $birthday
 * @property string $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $user_id
 * @property string $firmlink
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereFirmlink($value)
 * @property-read \App\Avatar $avatarClient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Calendar[] $ordersClient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProtocolClient[] $clientProtocol
 */
class Client extends Model {

    protected $table = 'clients';
    protected $fillable = ['gender', 'first_name', 'last_name', 'telephone', 'mobile', 'birthday', 'email', 'user_id'];

	/**
	 * Parse client birthday to right format
	 *
	 * @param $value
	 */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = \DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

	/**
	 * Get client birthday in right format
	 *
	 * @param $value
	 *
	 * @return bool|string
	 */
    public function getBirthdayAttribute($value)
    {
    	if ($value != '0000-00-00'){
		    return  date_format(date_create($value), "d/m/Y");
	    }
	    return '';
    }

	/**
	 * Get client created at attribute in right format
	 *
	 * @param $value
	 *
	 * @return bool|string
	 */
	public function getCreatedAtAttribute($value)
	{
		return date_format(date_create($value), "d-m-Y");
    }

	/**
	 * Relation client to his avatar
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function avatarClient()
	{
		return $this->hasOne(\App\Avatar::class, 'user_id', 'user_id');
    }

	/**
	 * Relation one client has many orders
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function ordersClient()
	{
		return $this->hasMany(\App\Calendar::class, 'client_id', 'id');
    }

	/**
	 * Relation one client has many protocols
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function clientProtocol()
	{
		return $this->hasMany(\App\ProtocolClient::class, 'client_id', 'id');
    }

    public static function getLastFiveClietns($from, $to)
    {
        $from = date('Y-m-d', strtotime('-1 day', strtotime($from)));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($to)));
        return self::whereBetween('created_at', array($from, $to))
                    ->select('first_name', 'last_name')
                    ->orderBy('created_at', 'desc')->get()->take(5);
    }

    public static function getClients($amount)
    {
            return self::orderBy('created_at', 'desc')
                        ->take($amount)
                        ->select('first_name', 'last_name')
                        ->get();
    }
}
