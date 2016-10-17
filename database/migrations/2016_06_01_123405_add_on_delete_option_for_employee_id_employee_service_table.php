<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteOptionForEmployeeIdEmployeeServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('employee_servises')->delete();

        Schema::table('employee_servises', function($table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
        
        Schema::table('employee_servises', function($table) {
            $table->integer('service_id')->unsigned()->nullable()->after('employee_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('employee_servises')->delete();

        Schema::table('employee_servises', function($table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });

        Schema::table('employee_servises', function($table) {
            $table->integer('service_id')->unsigned()->nullable()->after('employee_id');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }
}
