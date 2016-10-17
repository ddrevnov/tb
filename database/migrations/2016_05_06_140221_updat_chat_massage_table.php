<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatChatMassageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('chat_massages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('massage');
            $table->integer('to')->unsigned();
            $table->foreign('to')->references('id')->on('users');
            $table->integer('from')->unsigned();
            $table->foreign('from')->references('id')->on('users');
            $table->integer('status');
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
        //
    }
}
