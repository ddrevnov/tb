<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->integer('category_id');
            $table->string('service_name', 50);
            $table->string('price', 10);
            $table->string('duration', 50);
            $table->string('description');
            $table->boolean('service_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
         Schema::drop('services');
    }

}
