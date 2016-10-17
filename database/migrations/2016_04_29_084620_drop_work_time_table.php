<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropWorkTimeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::drop('work_times');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::create('work_times', function (Blueprint $table) {
            $table->increments('id');
            $table->time('from');
            $table->time('to');
            $table->integer('index_day');
            $table->integer('firm_id');
            $table->timestamps();
        });
    }

}
