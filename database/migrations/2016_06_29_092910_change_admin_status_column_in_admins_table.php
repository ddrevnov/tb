<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAdminStatusColumnInAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function ($table) {
            $table->dropColumn('status');
        });

        Schema::table('admins', function ($table) {
            $table->enum('status', ['new', 'active', 'notactive', 'blocked', 'freeze'])->after('tariff')->default('new');
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
            $table->dropColumn('status');
        });

        Schema::table('admins', function ($table) {
            $table->string('status')->after('tariff')->default('active');
        });
    }
}
