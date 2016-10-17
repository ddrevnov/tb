<?php

use Illuminate\Database\Seeder;

class FirmTypeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('firmtype')->delete();

        DB::table('firmtype')->insert([
            'firmtype' => 'Wähle Deine Branche aus…',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Beauty & Nails',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Beratung & Coaching',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Betreuung & Pflege',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Entertainment',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Fahrservice & Kurierdienste',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Finanzen & Versicherung',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Fotografie und Film',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Friseur',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Gesundheit & Ernährung',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Handwerk',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Heilpraktiker',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'IT- & Computerservice',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'KFZ-Reparatur & -Service',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Kunst',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Massage & Wellness',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Optiker & Medizintechniker',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Physiotherapie & Osteopathie',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Psychologie',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Reinigungs- und Hausmeisterservice',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Reparatur & Wartung',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Sport & Freizeit',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Steuern & Recht',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Tattoo & Piercing',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Umzug & Transporte',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Unterricht & Lernen',
        ]);
        DB::table('firmtype')->insert([
            'firmtype' => 'Ärzte & Zahnärzte',
        ]);
    }

}
