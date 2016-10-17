<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RebuildTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariffs', function ($table) {
            $table->dropColumn('tarifname');
            $table->dropColumn('price');
        });

        Schema::table('tariffs', function ($table) {
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
        //
    }
}
