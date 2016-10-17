<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeFirmDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('firmdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firmlink');
            $table->text('about_us');
            $table->string('logo');
            $table->string('mon_worktime');
            $table->string('tue_worktime');
            $table->string('wed_worktime');
            $table->string('thu_worktime');
            $table->string('fri_worktime');
            $table->string('sat_worktime');
            $table->string('sun_worktime');
            $table->string('firm_name');
            $table->string('street');
            $table->string('post_index');
            $table->string('country');
            $table->string('firm_telnumber');
            $table->string('firm_email');
            $table->string('firm_website');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('firmdetails');
    }

}
