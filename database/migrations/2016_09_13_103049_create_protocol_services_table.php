<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocol_services', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('admin_id')->unsigned();
	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
	        $table->integer('service_id')->unsigned();
	        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
	        $table->enum('author', ['admin', 'director'])->default('admin');
	        $table->string('type');
	        $table->string('old_value')->nullable();
	        $table->string('new_value')->nullable();
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
        Schema::drop('protocol_services');
    }
}
