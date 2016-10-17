<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClientAvatar
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $path
 * @property integer $client_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ClientAvatar whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientAvatar wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientAvatar whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientAvatar whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientAvatar whereUpdatedAt($value)
 */
class ClientAvatar extends Model
{
    protected $table = 'client_avatars';
    protected $fillable = ['id', 'path', 'client_id'];
    
    public static function getClientAvatar($clientId){
        return self::where('client_id', $clientId)->pluck('path')->first();
    }
}
