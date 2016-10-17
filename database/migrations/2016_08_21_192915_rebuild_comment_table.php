<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RebuildCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	\DB::table('comments')->delete();

        Schema::table('comments', function (Blueprint $table) {
        	$table->dropForeign('comments_id_firm_foreign');
	        $table->dropForeign('comments_name_firm_foreign');
	        $table->dropColumn(['id_firm', 'name_firm']);

	        $table->integer('admin_id')->unsigned()->after('id');
	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('admin_id');
        });
    }
}
