<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sms', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('order_id')->unsigned();
	        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
	        $table->string('package_title')->nullable();
	        $table->integer('count')->unsigned();
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
        Schema::drop('order_sms');
    }
}
