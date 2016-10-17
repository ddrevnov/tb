<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('heading');
            $table->string('text');
            $table->integer('id_firm')->unsigned();
            $table->foreign('id_firm')->references('id')->on('firmdetails');
            $table->string('firmname');
            $table->foreign('firmname')->references('firmlink')->on('firmdetails');
            $table->integer('id_clients')->unsigned();
            $table->foreign('id_clients')->references('id')->on('clients');
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
        Schema::drop('comments');
    }
}
