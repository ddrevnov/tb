<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServicesCategory
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property string $category_name
 * @property boolean $category_status
 * @property boolean $category_delete
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereCategoryStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereCategoryDelete($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesCategory active()
 */
class ServicesCategory extends Model
{
    protected $table = 'services_category';
    protected $fillable = ['id', 'admin_id', 'category_name', 'category_status', 'category_delete'];

	/**
	 * Parse category status to int
	 *
	 * @param $value
	 *
	 * @return int
	 */
	public function getCategoryStatusAttribute($value)
	{
		return intval($value);
	}

	/**
	 * Scope for not deleted categories
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query)
	{
		return $query->where('category_delete', 0);
	}

    public static function getServicesCategoryList($idAdmin){
        return self::where(['admin_id' => $idAdmin, 'category_delete' => 0])->get();
    }
    
    public static function getActiveServicesCategoryList($idAdmin){
        return self::where(['admin_id'=> $idAdmin, 'category_status' => 1])->get();
    }

    public static function deleteServiceCategory($idCategoryForRemove){
        self::find($idCategoryForRemove)->update(['category_delete' => 1, 'category_status' => 0]);
    }
}
