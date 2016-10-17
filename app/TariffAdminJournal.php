<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TariffAdminJournal
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
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
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereLettersCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereLettersUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereEmployeeCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereEmployeeUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereServicesCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereServicesUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereDashboardCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereDashboardUnlimited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereUpdatedAt($value)
 * @property float $balance
 * @property string $next_order
 * @property string $valid_before
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereNextOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereValidBefore($value)
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\TariffAdminJournal whereDescription($value)
 */
class TariffAdminJournal extends Model
{
    protected $table = 'tariffs_admin_journal';
    protected $fillable = ['admin_id', 'name', 'type', 'price', 'balance', 'duration', 'description','next_order', 'status',
        'letters_count', 'letters_unlimited', 'employee_count', 'employee_unlimited',
        'services_count', 'services_unlimited', 'dashboard_count', 'dashboard_unlimited', 'valid_before', 'created_at'
    ];

    public function getValidBeforeAttribute($value)
    {
        return (new \DateTime($value))->format('d-m-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new \DateTime($value))->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return (new \DateTime($value))->format('d-m-Y');
    }

    public static function checkTariffEmployee($adminId)
    {
        $check_tariff = self::where('admin_id', $adminId)->first();

        if (!$check_tariff->employee_unlimited) {
            if ($check_tariff->employee_count != 0) {
                $check_tariff->decrement('employee_count');
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}
