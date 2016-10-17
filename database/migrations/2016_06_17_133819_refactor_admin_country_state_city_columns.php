<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorAdminCountryStateCityColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function ($table) {
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });

        Schema::table('admins', function ($table) {
            $table->integer('country')->after('gender')->nullable()->default(1);
            $table->foreign('country')->references('id')->on('countries')->onDelete('set null');
            $table->integer('state')->after('country')->nullable()->default(1);
            $table->foreign('state')->references('id')->on('states')->onDelete('set null');
            $table->integer('city')->after('state')->nullable()->default(1);
            $table->foreign('city')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function ($table) {
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });

        Schema::table('admins', function ($table) {
            $table->string('country')->after('gender')->nullable();
            $table->string('state')->after('country')->nullable();
            $table->string('city')->after('state')->nullable();
        });
    }
}
