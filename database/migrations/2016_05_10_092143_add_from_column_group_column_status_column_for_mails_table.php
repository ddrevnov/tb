<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFromColumnGroupColumnStatusColumnForMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mails', function($table) {
            $table->string('from')->after('to');
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
        Schema::table('mails', function($table) {
            $table->dropColumn('from');
            $table->dropColumn('group');
            $table->dropColumn('send');
        });
    }
}
