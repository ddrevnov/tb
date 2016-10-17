<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProtocolCategory
 *
 * @property integer        $id
 * @property integer        $admin_id
 * @property integer        $category_id
 * @property string         $author
 * @property string         $type
 * @property string         $old_value
 * @property string         $new_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereOldValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereNewValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProtocolCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Admin $admin
 * @property-read \App\ServicesCategory $category
 */
class ProtocolCategory extends Model
{
	protected $table = 'protocol_categories';
	protected $fillable = ['admin_id', 'category_id', 'author', 'type', 'old_value', 'new_value'];

	/**
	 * Relation one protocol has one admin
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function admin()
	{
		return $this->hasOne(\App\Admin::class, 'id', 'admin_id')->with('avatar');
	}

	/**
	 * Relation one protocol has one category
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function category()
	{
		return $this->hasOne(\App\ServicesCategory::class, 'id', 'category_id');
	}

	/**
	 * Protocol new admin category
	 *
	 * @param null|integer $admin_id
	 * @param null|integer $category_id
	 * @param null|Request $request
	 * @param string       $author
	 */
	public static function protocolAdminCategoryCreate($admin_id = null, $category_id,
	                                                   $request = null, $author = 'admin')
	{
		if ($admin_id) {
			self::create([
				'admin_id'    => $admin_id,
				'category_id' => $category_id,
				'author'      => $author,
				'type'        => 'create_category',
				'new_value'   => $request['category_name'],
			]);

		}

		return false;
	}

	/**
	 * Protocol admin change category
	 *
	 * @param null|integer $admin_id
	 * @param null|integer $category_id
	 * @param null|array   $change_values
	 * @param null|Request $request
	 * @param string       $author
	 */
	public static function protocolAdminCategoryChange($admin_id = null, $category_id = null, $change_values = null,
	                                                   $request = null, $author = 'admin')
	{
		if ($admin_id) {

			$old_values = ServicesCategory::select($change_values)->find($category_id)->toArray();
			$new_values = $request->all();
			$diffs = array_keys(array_diff($old_values, $new_values));

			if ($diffs) {
				foreach ($diffs as $diff) {
					self::create([
						'admin_id'    => $admin_id,
						'category_id' => $category_id,
						'author'      => $author,
						'type'        => 'change_' . $diff,
						'old_value'   => $old_values[$diff],
						'new_value'   => $new_values[$diff],
					]);
				}
			}
		}

		return false;
	}

	/**
	 * Protocol admin delete category
	 *
	 * @param null|integer $admin_id
	 * @param null|integer $request
	 * @param string       $author
	 *
	 * @return bool
	 */
	public static function protocolAdminCategoryDelete($admin_id = null, $category_id, $request = null, $author = 'admin')
	{
		if ($admin_id) {
			$category_name = ServicesCategory::find($request->id)->category_name;
			self::create([
				'admin_id'    => $admin_id,
				'category_id' => $category_id,
				'author'      => $author,
				'type'        => 'delete_category',
				'new_value'   => $category_name,
			]);

		}

		return false;
	}
}
