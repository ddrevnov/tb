<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('comments');
        
        Schema::create('comments', function($table) {
            $table->increments('id');
            $table->string('heading');
            $table->string('text');
            $table->integer('id_firm')->unsigned();
            $table->foreign('id_firm')->references('id')->on('firmdetails');
            $table->string('name_firm');
            $table->foreign('name_firm')->references('firmlink')->on('firmdetails');
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
