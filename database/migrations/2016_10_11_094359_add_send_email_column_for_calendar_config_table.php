<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendEmailColumnForCalendarConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_config', function (Blueprint $table) {
            $table->boolean('send_email')->after('h_reminder')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar_config', function (Blueprint $table) {
            $table->dropColumn('send_email');
        });
    }
}
