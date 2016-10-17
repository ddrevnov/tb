<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStreetCityStateCountryColumnsForFirmDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function ($table) {
            $table->dropForeign(['city']);
            $table->dropColumn('city');
            $table->dropForeign(['state']);
            $table->dropColumn('state');
            $table->dropForeign(['country']);
            $table->dropColumn('country');
            $table->dropColumn('street');
        });


        Schema::table('firmdetails', function ($table) {
            $table->string('street')->after('post_index')->nullable();
            $table->integer('city')->after('street')->nullable()->default(1);
            $table->foreign('city')->references('id')->on('cities')->onDelete('set null');
            $table->integer('state')->after('city')->nullable()->default(1);
            $table->foreign('state')->references('id')->on('states')->onDelete('set null');
            $table->integer('country')->after('state')->nullable()->default(1);
            $table->foreign('country')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
