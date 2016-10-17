<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForAdminsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('admins', function($table) {
            $table->string('mobile');
            $table->string('skype');
            $table->string('gender');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('admins', function($table) {
            $table->dropColumn(array('mobile', 'skype', 'gender', 'street', 'city','state', 'country'));
        });
    }

}
