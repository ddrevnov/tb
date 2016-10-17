<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RebuildBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_details', function (Blueprint $table) {
            $table->dropColumn('account_number');
            $table->dropColumn('bank_code');
            $table->dropColumn('firm_name');
            $table->dropColumn('first_last_name');
            $table->dropColumn('post_index');
            $table->dropColumn('street');
            $table->dropColumn('addition_address');

            $table->integer('legal_city')->after('bic')->nullable()->default(1);
            $table->foreign('legal_city')->references('id')->on('cities')->onDelete('set null');
            $table->integer('legal_state')->after('legal_city')->nullable()->default(1);
            $table->foreign('legal_state')->references('id')->on('states')->onDelete('set null');
            $table->integer('legal_country')->after('legal_state')->nullable()->default(1);
            $table->foreign('legal_country')->references('id')->on('countries')->onDelete('set null');

            $table->string('legal_street')->after('legal_city')->nullable();
            $table->string('legal_post_index')->after('legal_street')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_details', function (Blueprint $table) {
            //
        });
    }
}
