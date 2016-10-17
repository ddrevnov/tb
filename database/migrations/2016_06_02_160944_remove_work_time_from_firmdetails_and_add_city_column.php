<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveWorkTimeFromFirmdetailsAndAddCityColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firmdetails', function($table) {
            $table->dropColumn('mon_worktime');
            $table->dropColumn('tue_worktime');
            $table->dropColumn('wed_worktime');
            $table->dropColumn('thu_worktime');
            $table->dropColumn('fri_worktime');
            $table->dropColumn('sat_worktime');
            $table->dropColumn('sun_worktime');
            $table->string('city')->after('street');
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
