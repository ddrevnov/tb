<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WorkTime
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $firmlink
 * @property string $from
 * @property string $to
 * @property integer $index_day
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereFirmlink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereIndexDay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkTime whereUpdatedAt($value)
 */
class WorkTime extends Model {

    protected $table = 'work_times';
    protected $fillable = ['id', 'from', 'to', 'index_day', 'firmlink'];

    public static function getFirmShedule($firmLink) {
        return self::where('firmlink', $firmLink)->orderBy('index_day', 'asc')->get();
    }

    /** return index_day always by integer
     * @param $value
     * @return int
     */
    public function getIndexDayAttribute($value)
    {
        return intval($value);
    }
}
