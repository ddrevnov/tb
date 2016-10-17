<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\State
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @method static \Illuminate\Database\Query\Builder|\App\State whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereCountryId($value)
 * @mixin \Eloquent
 */
class State extends Model
{
    protected $table = 'states';
    protected $fillable = ['id','name', 'country_id'];
}
