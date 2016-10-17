<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\City
 *
 * @property integer $id
 * @property string $name
 * @property integer $state_id
 * @method static \Illuminate\Database\Query\Builder|\App\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereStateId($value)
 * @mixin \Eloquent
 * @property-read \App\Firm $firm
 */
class City extends Model
{
    protected $table = 'cities';
    protected $fillable = ['id','name', 'state_id'];

	public function firm()
	{
		return $this->belongsTo(\App\Firm::class, 'city', 'id');
	}
}
