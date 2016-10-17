<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeed::class);
    }
}

class AdminsTableSeed extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('admins')->delete();
        
        for ($i = 0; $i < 10; $i++) {
            
            (($i % 2) == 0) ? $status = 'active' : $status = 'not active';
            
            DB::table('admins')->insert([
                'firstname' => str_random(10),
                'lastname' => str_random(10),
                'telnumber' => '0-00-0000-00',
                'email' => str_random(5) . '@gmail.com',
                'firmname' => str_random(10),
                'firmlink' => str_random(10),
                'firmtype' => str_random(10),
                'tariff' => '1',
                'status' => $status,
            ]);
        }
    }

}