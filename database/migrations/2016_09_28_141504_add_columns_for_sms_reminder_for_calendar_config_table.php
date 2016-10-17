<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForSmsReminderForCalendarConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_config', function (Blueprint $table) {
            $table->boolean('send_sms')->default(0)->after('h_reminder');
	        $table->smallInteger('sms_reminder')->default(30)->after('send_sms');
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
            $table->dropColumn(['send_sms', 'sms_reminder']);
        });
    }
}
