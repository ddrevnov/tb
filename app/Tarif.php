<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Tarif
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $price
 * @property integer $duration
 * @property boolean $status
 * @property integer $letters_count
 * @property boolean $letters_unlimited
 * @property integer $employee_count
 * @property boolean $employee_unlimited
 * @property integer $services_count
 * @property boolean $services_unlimited
 * @property integer $dashboard_count
 * @property boolean $dashboard_unlimited
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereLettersCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereLettersUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereEmployeeCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereEmployeeUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereServicesCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereServicesUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereDashboardCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereDashboardUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereUpdatedAt($value)
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\Tarif whereDescription($value)
 */
class Tarif extends Model
{
    protected $table = 'tariffs';
    protected $fillable = ['id', 'name', 'type', 'price','duration', 'description', 'status',
                            'letters_count', 'letters_unlimited', 'employee_count', 'employee_unlimited',
                            'services_count', 'services_unlimited', 'dashboard_count', 'dashboard_unlimited'
                        ];
}
