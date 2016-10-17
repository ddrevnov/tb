<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOnDeleteRulesForUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    DB::statement('SET foreign_key_checks = 0;');
	    Schema::table('calendar', function (Blueprint $table){
	    	$table->dropForeign(['employee_id']);
	    	$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
	    });

	    Schema::table('avatars', function (Blueprint $table){
		    $table->dropForeign(['user_id']);
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	    });

	    DB::statement('SET foreign_key_checks = 1;');

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
