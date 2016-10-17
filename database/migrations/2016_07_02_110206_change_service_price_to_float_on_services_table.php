<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeServicePriceToFloatOnServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function ($table){
           $table->dropColumn('price');
        });

        Schema::table('services', function ($table){
            $table->float('price')->after('service_name')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function ($table){
            $table->dropColumn('price');
        });

        Schema::table('services', function ($table){
            $table->integer('price')->after('service_name')->unsigned()->default(0);
        });
    }
}
