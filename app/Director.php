<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Director
 *
 * @mixin \Eloquent
 */
class Director extends Model
{

    public static function approveNewAdmin($newAdminId, $passForAdmin) {

        DB::table('admins')->where('id', $newAdminId)->update(['status' => 'active']);
        
        $newAdmin = DB::table('admins')->where('id', $newAdminId)->get();
        
        $newAdmin = array_shift($newAdmin);

        $newAdmin->password = $passForAdmin;
        DB::table('users')->insert([
            'name' => $newAdmin->firstname,
            'email' => $newAdmin->email,
            'password'=> $newAdmin->password,
            'status' => 'admin'
        ]);
        
        DB::table('firmdetails')->insert(['firmlink' => $newAdmin->firmlink]);
        DB::table('bank_details')->insert(['admin_id' => $newAdminId]);
        
        $id = intval(DB::table('users')->where('email', $newAdmin->email)->value('id'));

        DB::update("update admins set user_id = $id where id = $newAdminId");
    }
}
