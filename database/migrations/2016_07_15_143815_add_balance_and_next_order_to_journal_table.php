<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBalanceAndNextOrderToJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariffs_admin_journal', function (Blueprint $table) {
            $table->float('balance')->after('price')->default(0);
            $table->timestamp('next_order')->after('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tariffs_admin_journal', function (Blueprint $table) {
            $table->dropColumn('balance');
            $table->dropColumn('next_order');
        });
    }
}
