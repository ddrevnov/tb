<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffAdminJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs_admin_journal', function ($table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->string('name');
            $table->enum('type', ['free', 'paid']);
            $table->integer('price')->unsigned()->nullable();
            $table->integer('duration')->unsigned()->nullable();
            $table->boolean('status')->default(1);
            $table->integer('letters_count')->unsigned()->nullable();
            $table->boolean('letters_unlimited')->defauld(0);
            $table->integer('employee_count')->unsigned()->nullable();
            $table->boolean('employee_unlimited')->defauld(0);
            $table->integer('services_count')->unsigned()->nullable();
            $table->boolean('services_unlimited')->defauld(0);
            $table->integer('dashboard_count')->unsigned()->nullable();
            $table->boolean('dashboard_unlimited')->defauld(0);
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
        Schema::drop('tariffs_admin_journal');
    }
}
