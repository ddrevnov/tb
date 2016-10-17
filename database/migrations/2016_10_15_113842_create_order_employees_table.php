<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_employees', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('admin_id')->unsigned();
	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
	        $table->integer('order_id')->unsigned()->nullable();
	        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
	        $table->string('name');
	        $table->string('last_name');
	        $table->float('price');
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
        Schema::drop('order_employees');
    }
}
