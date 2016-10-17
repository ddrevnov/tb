<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSMSDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_sms_data', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('admin_id')->unsigned();
	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
	        $table->string('title');
	        $table->string('body');
	        $table->integer('count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_sms_data');
    }
}
