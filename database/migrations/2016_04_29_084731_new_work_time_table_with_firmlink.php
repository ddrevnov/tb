<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewWorkTimeTableWithFirmlink extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('work_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firmlink');
            $table->foreign('firmlink')->references('firmlink')->on('firmdetails');
            $table->time('from');
            $table->time('to');
            $table->integer('index_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('work_times');
    }

}
