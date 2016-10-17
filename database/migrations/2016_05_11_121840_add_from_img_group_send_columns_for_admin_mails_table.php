<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFromImgGroupSendColumnsForAdminMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_mails', function($table) {
            $table->string('from')->after('to');
            $table->string('img')->after('text');
            $table->boolean('group')->after('img');
            $table->boolean('send')->after('group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_mails', function($table) {
            $table->dropColumn('from');
            $table->dropColumn('img');
            $table->dropColumn('group');
            $table->dropColumn('send');
        });
    }
}
