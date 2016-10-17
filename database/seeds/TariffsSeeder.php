<?php

use Illuminate\Database\Seeder;

class TariffsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('tariffs')->delete();

        DB::table('tariffs')->insert([
            'tarifname' => 'Bitte wählen Sie den Tarif aus',
            'price' => '0',
        ]);

        DB::table('tariffs')->insert([
            'tarifname' => 'Free',
            'price' => '0',
        ]);
        DB::table('tariffs')->insert([
            'tarifname' => 'Premium',
            'price' => '10',
        ]);
        DB::table('tariffs')->insert([
            'tarifname' => 'Standart',
            'price' => '20',
        ]);
        DB::table('tariffs')->insert([
            'tarifname' => 'Enterprise',
            'price' => '30',
        ]);
    }

}
