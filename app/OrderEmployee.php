<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderEmployee
 *
 * @property integer $id
 * @property integer $admin_id
 * @property integer $order_id
 * @property string $name
 * @property string $last_name
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderEmployee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderEmployee extends Model
{
    protected $table = 'order_employees';
	protected $fillable = ['admin_id', 'order_id', 'name', 'last_name', 'price'];
}
