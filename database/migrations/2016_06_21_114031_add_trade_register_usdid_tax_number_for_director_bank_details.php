<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTradeRegisterUsdidTaxNumberForDirectorBankDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('director_bank_details', function ($table){
            $table->string('ust_id')->after('bic')->nullable();
            $table->string('trade_register')->after('ust_id')->nullable();
            $table->string('tax_number')->after('trade_register')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('director_bank_details', function ($table){
            $table->dropColumn('ust_id');
            $table->dropColumn('trade_register');
            $table->dropColumn('tax_number');
        });
    }
}
