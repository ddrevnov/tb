<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Firm
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $firmlink
 * @property string $about_us
 * @property string $logo
 * @property string $firm_name
 * @property string $street
 * @property string $city
 * @property string $post_index
 * @property string $country
 * @property string $firm_telnumber
 * @property string $firm_email
 * @property string $firm_website
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereFirmlink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereAboutUs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereFirmName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm wherePostIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereFirmTelnumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereFirmEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereFirmWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereUpdatedAt($value)
 * @property integer $state
 * @method static \Illuminate\Database\Query\Builder|\App\Firm whereState($value)
 * @property-read \App\Admin $admin
 * @property-read \App\Country $countryInfo
 * @property-read \App\State $stateInfo
 * @property-read \App\City $cityInfo
 */
class Firm extends Model {

    protected $table = 'firmdetails';
    protected $fillable = ['id', 'firmlink', 'about_us', 'firm_name', 'post_index', 'street', 'state', 'city', 'country', 
                            'firm_telnumber', 'firm_email', 'firm_website'];


	/**
	 * Relation firm to admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function admin()
	{
		return $this->belongsTo(\App\Admin::class, 'firmlink', 'firmlink');
	}

	/**
	 * Relation firm to country
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function countryInfo()
	{
		return $this->hasOne(\App\Country::class, 'id', 'country');
	}

	/**
	 * Relation firm to state
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function stateInfo()
	{
		return $this->hasOne(\App\State::class, 'id', 'state');
	}

	/**
	 * Relation firm to city
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function cityInfo()
	{
		return $this->hasOne(\App\City::class, 'id', 'city');
	}

    public static function addNewFirm($firmlink){
        self::insert(['firmlink' => $firmlink]);
    }

    public static function getFirmDetails($firmLink) {
        return self::where('firmlink', $firmLink)
                    ->leftJoin('countries', 'countries.id', '=', 'firmdetails.country')
                    ->leftJoin('states', 'states.id', '=', 'firmdetails.state')
                    ->leftJoin('cities', 'cities.id', '=', 'firmdetails.city')
                    ->select('firmdetails.firm_name', 'firmdetails.about_us', 'firmdetails.post_index',
                        'firmdetails.street', 'countries.name as country', 'states.name as state', 'cities.name as city', 'countries.id as country_id', 'states.id as state_id', 'cities.id as city_id',
                        'firmdetails.firm_telnumber')
                    ->first();
    }
    
//    public static function setAboutUs($firmLink, $editInfo) {
//        $firm = self::where('firmlink', $firmLink)->first();
//        if ($firm) {
//            $firm->update(['about_us' => $editInfo['aboutus']]);
//            $firm->save();
//        }
//    }

    public static function getFirms()
    {
        return self::leftJoin('countries', 'countries.id', '=', 'firmdetails.country')
            ->leftJoin('states', 'states.id', '=', 'firmdetails.state')
            ->leftJoin('cities', 'cities.id', '=', 'firmdetails.city')
            ->select('countries.name as country', 'states.name as state', 'cities.name as city')
            ->get()->toArray();
    }
}
