<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignForFirmtype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('admins', function (Blueprint $table) {
        	$table->dropColumn('firmtype');
        });

	    Schema::table('admins', function (Blueprint $table){
	    	$table->integer('firmtype')->unsigned()->nullable()->after('firmlink');
		    $table->foreign('firmtype')->references('id')->on('firmtype')->onDelete('set null');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
			$table->dropForeign(['firmtype']);
	        $table->dropColumn('firmtype');
        });

	    Schema::table('admins', function (Blueprint $table){
		    $table->string('firmtype')->after('firmlink');
	    });
    }
}
