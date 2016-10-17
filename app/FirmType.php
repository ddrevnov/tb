<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FirmType
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $firmtype
 * @method static \Illuminate\Database\Query\Builder|\App\FirmType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FirmType whereFirmtype($value)
 */
class FirmType extends Model {

    protected $table = 'firmtype';
    protected $fillable = ['id', 'firmtype'];
   
}
