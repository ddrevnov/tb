<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('services')->delete();

        DB::table('services')->insert([
            'admin_id' => 2,
            'category_id' => 2,
            'service_name' => 'mans haicut',
            'price' => '35 usd',
            'duration' => '30 min',
            'description' => 'the best haicut',
            'service_status' => 1
        ]);
        DB::table('services')->insert([
            'admin_id' => 2,
            'category_id' => 2,
            'service_name' => 'woman haicut',
            'price' => '50 usd',
            'duration' => '40 min',
            'description' => 'the best haicut',
            'service_status' => 1
        ]);
        DB::table('services')->insert([
            'admin_id' => 2,
            'category_id' => 2,
            'service_name' => 'children haicut',
            'price' => '10 usd',
            'duration' => '10 min',
            'description' => 'the best haicut',
            'service_status' => 1
        ]);
        DB::table('services')->insert([
            'admin_id' => 2,
            'category_id' => 2,
            'service_name' => 'animal haicut',
            'price' => '5 usd',
            'duration' => '5 min',
            'description' => 'the best haicut',
            'service_status' => 1
        ]);
    }

}
