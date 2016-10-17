<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderSMS
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $package_title
 * @property integer $count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\OrderSMS whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderSMS whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderSMS wherePackageTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderSMS whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderSMS whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderSMS whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderSMS extends Model
{
    protected $table = 'order_sms';
	protected $fillable = ['order_id', 'package_title', 'count'];
}
