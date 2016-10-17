<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BankDetails
 *
 * @mixin \Eloquent
 * @property integer        $id
 * @property integer        $admin_id
 * @property string         $account_owner
 * @property string         $account_number
 * @property string         $bank_code
 * @property string         $bank_name
 * @property string         $iban
 * @property string         $bic
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereAccountOwner($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereAccountNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereBankCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereBankName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereIban($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereBic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereUpdatedAt($value)
 * @property boolean        $agreement
 * @property string         $firm_name
 * @property string         $first_last_name
 * @property string         $post_index
 * @property string         $street
 * @property string         $addition_address
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereAgreement($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereFirmName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereFirstLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails wherePostIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereAdditionAddress($value)
 * @property string         $legal_firm_name
 * @property integer        $legal_city
 * @property string         $legal_street
 * @property string         $legal_post_index
 * @property integer        $legal_state
 * @property integer        $legal_country
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereLegalFirmName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereLegalCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereLegalStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereLegalPostIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereLegalState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BankDetails whereLegalCountry($value)
 * @property-read \App\City $city
 * @property-read \App\State $state
 * @property-read \App\Country $country
 */
class BankDetails extends Model
{
	protected $table = 'bank_details';
	protected $fillable = ['id', 'admin_id', 'agreement', 'account_owner', 'bank_name', 'iban', 'bic',
		'legal_firm_name', 'legal_city', 'legal_street', 'legal_post_index', 'legal_state',
		'legal_country'];

	/**
	 * Relation bank details to legal city
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function city()
	{
		return $this->hasOne(\App\City::class, 'id', 'legal_city');
	}

	/**
	 * Relation bank details to legal state
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function state()
	{
		return $this->hasOne(\App\State::class, 'id', 'legal_state');
	}

	/**
	 * Relation bank details to legal country
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function country()
	{
		return $this->hasOne(\App\Country::class, 'id', 'legal_country');
	}


	public static function addNewBankDetails($idAdmin)
	{
		self::insert(['admin_id' => $idAdmin]);
	}

	public static function getBankDetails($idAdmin)
	{
		return self::where('bank_details.admin_id', $idAdmin)
			->leftJoin('countries', 'countries.id', '=', 'bank_details.legal_country')
			->leftJoin('states', 'states.id', '=', 'bank_details.legal_state')
			->leftJoin('cities', 'cities.id', '=', 'bank_details.legal_city')
			->select('bank_details.agreement', 'bank_details.account_owner', 'bank_details.bank_name',
				'bank_details.bic', 'bank_details.iban', 'bank_details.legal_firm_name',
				'cities.id as legal_city', 'states.id as legal_state', 'countries.id as legal_country',
				'cities.name as legal_city_name', 'states.name as legal_state_name',
				'countries.name as legal_country_name', 'bank_details.legal_street',
				'bank_details.legal_post_index')
			->first();
	}

}
