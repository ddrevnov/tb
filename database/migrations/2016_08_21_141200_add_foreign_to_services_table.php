<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('admin_id')->unsigned()->change();
	        $table->integer('category_id')->unsigned()->change();

	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
	        $table->foreign('category_id')->references('id')->on('services_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['category_id', 'admin_id']);
        });
    }
}
