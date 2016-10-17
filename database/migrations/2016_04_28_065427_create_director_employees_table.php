<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('director_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar');
            $table->string('phone');
            $table->string('email');
            $table->string('gender');
            $table->date('birthday');
            $table->string('group')->default('employee');
            $table->string('status')->default('not active');
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
        Schema::drop('director_employees');
    }
}
