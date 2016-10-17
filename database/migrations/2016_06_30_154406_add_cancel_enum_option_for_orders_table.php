<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelEnumOptionForOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('status');
        });

        Schema::table('orders', function ($table) {
            $table->enum('status', ['new', 'paid', 'attention', 'warning', 'cancel'])->after('price')->default('new');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('status');
        });

        Schema::table('orders', function ($table) {
            $table->enum('status', ['new', 'paid', 'attention', 'warning'])->after('price')->default('new');
        });
    }
}
