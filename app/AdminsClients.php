<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AdminsClients
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $admin_id
 * @property integer $client_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\AdminsClients whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminsClients whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminsClients whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminsClients whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdminsClients whereUpdatedAt($value)
 * @property boolean $email_send
 * @method static \Illuminate\Database\Query\Builder|\App\AdminsClients whereEmailSend($value)
 */
class AdminsClients extends Model {

    protected $table = 'admins_clients';
    protected $fillable = ['id', 'admin_id', 'client_id'];

    public static function getAdminClientsInfo($idAdmin)
    {
        return self::where('admins_clients.admin_id', $idAdmin)
                ->join('clients', 'clients.id', '=', 'admins_clients.client_id')
                ->paginate(15);
    }

    public static function getClientSubscribes($idClient)
    {
        return self::where('admins_clients.client_id', $idClient)
                    ->leftJoin('admins', 'admins.id', '=', 'admins_clients.admin_id')
                    ->leftJoin('images', 'admins_clients.admin_id', '=', 'images.admin_id')
                    ->select('admins.firmlink', 'images.firm_logo', 'admins_clients.admin_id',
                        'admins_clients.email_send')->get();
    }
    
}
