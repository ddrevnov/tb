<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForAdminSmsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_sms_data', function (Blueprint $table) {
            $table->integer('sent')->unsigned()->default(0)->after('count');
            $table->boolean('is_notify')->default(0)->after('sent');
            $table->enum('notify_type', ['sms', 'email', 'sms+email'])->default('email')->after('is_notify');
            $table->integer('sms_balance_notify')->default(0)->after('notify_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_sms_data', function (Blueprint $table) {
            $table->dropColumn(['sent', 'is_notify', 'notify_type', 'sms_balance_notify']);
        });
    }
}
