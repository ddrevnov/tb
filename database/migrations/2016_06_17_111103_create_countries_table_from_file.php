<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTableFromFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(File::get(database_path() . '/countries.sql'));
        DB::unprepared(File::get(database_path() . '/cities.sql'));
        DB::unprepared(File::get(database_path() . '/states.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries');
        Schema::drop('cities');
        Schema::drop('states');
    }
}
