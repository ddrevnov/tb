<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePricesColumnsToFloatForTariffAndJournalTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariffs', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('tariffs', function ($table){
            $table->float('price')->after('type')->unsigned()->default(0);
        });

        Schema::table('tariffs_admin_journal', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('tariffs_admin_journal', function ($table){
            $table->float('price')->after('type')->unsigned()->default(0);
        });

        Schema::table('orders', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('orders', function ($table){
            $table->float('price')->after('admin_id')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tariffs', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('tariffs', function ($table){
            $table->integer('price')->after('type')->unsigned()->default(0);
        });

        Schema::table('tariffs_admin_journal', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('tariffs_admin_journal', function ($table){
            $table->integer('price')->after('type')->unsigned()->default(0);
        });

        Schema::table('orders', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('orders', function ($table){
            $table->integer('price')->after('admin_id')->unsigned()->default(0);
        });
    }
}
