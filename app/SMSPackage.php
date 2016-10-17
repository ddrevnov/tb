<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SMSPackage
 *
 * @property integer $id
 * @property float $price
 * @property integer $count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\SMSPackage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSPackage wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSPackage whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMSPackage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $package_title
 * @method static \Illuminate\Database\Query\Builder|\App\SMSPackage wherePackageTitle($value)
 */
class SMSPackage extends Model
{
    protected $table = 'sms_packages';
	protected $fillable = ['package_title', 'price', 'count'];
}
