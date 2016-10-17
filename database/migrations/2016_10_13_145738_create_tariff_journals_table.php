<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_journals', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('admin_id')->unsigned();
	        $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
	        $table->enum('type', ['free', 'paid'])->default('free');
	        $table->timestamp('valid_before');
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
        Schema::drop('tariff_journals');
    }
}
