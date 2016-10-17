<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdColumnForDirectorEmployees extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        
        DB::table('director_employees')->delete();
        
        Schema::table('director_employees', function($table) {
            $table->integer('user_id')->unsigned()->after('id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('director_employees', function($table) {
            $table->dropColumn('user_id');
        });
    }

}
