<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorBankdetailsAndLegalAdress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('director_bank_details', function ($table) {
            $table->increments('id');
            $table->string('account_owner');
            $table->string('account_number');
            $table->string('bank_code');
            $table->string('bank_name');
            $table->string('iban');
            $table->string('bic');
            $table->string('firm_name');
            $table->string('first_last_name');
            $table->string('post_index');
            $table->string('street');
            $table->string('addition_address');
            $table->string('logo');
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
        Schema::drop('director_bank_details');
    }
}
