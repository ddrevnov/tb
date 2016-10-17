<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Image
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property string $avatar
 * @property string $firm_logo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereFirmLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereUpdatedAt($value)
 */
class Image extends Model {

    protected $table = 'images';
    protected $fillable = ['id', 'admin_id', 'firm_logo'];


    public static function hasLogo($adminId) {
        return self::where('admin_id', $adminId)->first();
    }

    public static function updateLogo($adminId, $fileName) {
        self::where('admin_id', $adminId)->update(['firm_logo' => $fileName]);
    }

    public static function addLogo($adminId, $request)
    {
        $logo = $request->file('firm_logo');
        
        $path = '/images/logos/';
        $fileName = str_random(8) . $logo->getClientOriginalName();
        $fullPath = public_path() . $path;
        $old_logo = self::where('admin_id', $adminId)->first();

        if ($old_logo) {
            $logo->move($fullPath, $fileName);
            unlink(public_path(). $old_logo->firm_logo);
            $old_logo->update(['firm_logo' => $path.$fileName]);
        } else {
            self::create(['admin_id' => $adminId, 'firm_logo' => $path.$fileName]);
            $logo->move($fullPath, $fileName);
        }
        return $path.$fileName;
    }
}
