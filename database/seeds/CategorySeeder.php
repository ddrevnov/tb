<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('services_category')->delete();

        DB::table('services_category')->insert([
            'admin_id' => 2,
            'category_name' => 'haicut',
            'category_status' => true,
        ]);
        DB::table('services_category')->insert([
            'admin_id' => 2,
            'category_name' => 'manicure',
            'category_status' => true,
        ]);
        DB::table('services_category')->insert([
            'admin_id' => 2,
            'category_name' => 'wave',
            'category_status' => true,
        ]);
        DB::table('services_category')->insert([
            'admin_id' => 2,
            'category_name' => 'painting',
            'category_status' => true,
        ]);
    }

}
