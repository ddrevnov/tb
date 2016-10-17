<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Services
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property string $service_name
 * @property string $price
 * @property string $duration
 * @property string $description
 * @property boolean $service_status
 * @property boolean $service_delete
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $category_id
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereServiceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereServiceStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereServiceDelete($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services whereCategoryId($value)
 * @property-read \App\ServicesCategory $category
 * @method static \Illuminate\Database\Query\Builder|\App\Services active()
 */
class Services extends Model {

    protected $table = 'services';
    protected $fillable = ['admin_id', 'category_id', 'service_name',
        'price', 'duration', 'description', 'service_status', 'service_delete'];

	public function scopeActive($query)
	{
		return $query->where('service_status', 1);
	}

	/**
	 * Relation one service to one category
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category()
	{
		return $this->hasOne(\App\ServicesCategory::class, 'id', 'category_id');
	}

    public static function getServicesList($idAdmin) {
        return self::where(['services.admin_id' => $idAdmin, 'service_delete' => 0])
                        ->join('services_category', 'services_category.id', '=', 'services.category_id')
                        ->select('services.id as service_id', 'services.service_name', 'services.price',
                                'services.duration', 'services.description', 'services.service_status', 
                                'services_category.id as category_id', 'services_category.category_name', 'services.price')
                        ->get();
    }

    public static function getActiveServicesList($idAdmin) {
        return self::where(['services.admin_id' => $idAdmin, 'services.service_status' => 1])
                        ->join('services_category', 'services_category.id', '=', 'services.category_id')
                        ->select('services.id', 'services_category.category_name', 'services.service_name', 'services.description',
                            'services.duration', 'services.price')
                        ->get();
    }

    public static function deleteService($idServiceForRemove){
        self::find($idServiceForRemove)->update(['service_delete' => 1, 'service_status' => 0]);
    }
    
    public static function deleteGroupServices($idCategory){
        self::where('category_id', $idCategory)->update(['service_delete' => 1, 'service_status' => 0]);
    }

}
