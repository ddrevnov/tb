<?php

use Illuminate\Database\Seeder;

class DirectorBankDetails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('director_bank_details')->insert(['id' => 1, 'created_at' => date('Y-m-d H:i:s')]);
    }
}
