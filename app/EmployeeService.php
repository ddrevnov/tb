<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EmployeeService
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $employee_id
 * @property integer $service_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeService whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeService whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeService whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeService whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeService whereUpdatedAt($value)
 */
class EmployeeService extends Model
{
    protected $table = 'employee_servises';
    protected $fillable = ['id','employee_id','service_id'];

    public static function getEmployees($serviceId){
        return self::join('employees', 'employee_servises.employee_id', '=', 'employees.id')
            ->where('employee_servises.service_id', $serviceId)
            ->where('employees.status', 'active')
            ->select(['employees.id', 'employees.name'])
            ->get();
    }
    
    public static function getServicesForEmployee($employee_id){
        return self::join('services', 'services.id', '=', 'employee_servises.service_id')
            ->join('services_category', 'services_category.id', '=', 'services.category_id')
            ->where('employee_servises.employee_id', $employee_id)
            ->where('services.service_status', 1)
            ->select(['services.id as service_id', 'services_category.category_name', 'service_name', 'services.duration', 'services.price'])
            ->get()->groupBy('category_name');
    }
}
