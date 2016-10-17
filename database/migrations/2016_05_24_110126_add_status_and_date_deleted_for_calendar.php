<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndDateDeletedForCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('calendar')->delete();
        
        Schema::table('calendar', function($table) {
            $table->string('status')->after('date')->nullable();
            $table->string('date_deleted')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar', function($table) {
            $table->dropColumn('status');
            $table->dropColumn('date_deleted');
        });
    }
}
