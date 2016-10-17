<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeleteStatusColumnForServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_category', function($table) {
            $table->boolean('category_delete')->after('category_status')->default(0);
        });

        Schema::table('services', function($table) {
            $table->boolean('service_delete')->after('service_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_category', function($table) {
            $table->dropColumn('category_delete');
        });

        Schema::table('services', function($table) {
            $table->dropColumn('service_delete');
        });
    }
}
