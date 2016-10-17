<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountEmailForDirectorAndAdminMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_mails', function ($table){
           $table->integer('count')->after('send')->unsigned()->default(0);
        });

        Schema::table('mails', function ($table){
            $table->integer('count')->after('send')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_mails', function ($table){
            $table->dropColumn('count');
        });

        Schema::table('mails', function ($table){
            $table->dropColumn('count');
        });
    }
}
