<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocol_newsletters', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('admin_id')->unsigned();
	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
	        $table->integer('employee_id')->unsigned()->nullable();
	        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
	        $table->enum('author', ['admin', 'employee'])->default('admin');
	        $table->string('type');
	        $table->string('title')->nullable();
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
        Schema::drop('protocol_newsletters');
    }
}
