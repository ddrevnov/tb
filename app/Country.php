<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Country
 *
 * @property integer $id
 * @property string $sortname
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereSortname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereName($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['id','sortname', 'name'];
}
