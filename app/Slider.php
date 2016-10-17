<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Slider
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property string $slide_name
 * @property string $image
 * @property boolean $slide_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereSlideName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereSlideStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slider whereUpdatedAt($value)
 */
class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = ['id', 'admin_id', 'slide_name', 'image', 'slide_status'];

//    public static function getSlidersList($adminId)
//    {
//        return self::where(['admin_id' => $adminId, 'slide_status' => 1])->get();
//    }

    public static function addSlide($adminId, $slideName, $image, $slideStatus)
    {
        self::create([
            'admin_id' => $adminId,
            'slide_name' => $slideName,
            'image' => $image,
            'slide_status' => $slideStatus
        ]);
    }

    public static function updateSlide($slideId, $slideName, $image, $slideStatus)
    {
        self::find($slideId)
            ->update([
                'slide_name' => $slideName,
                'image' => $image,
                'slide_status' => $slideStatus
            ]);
    }
}
