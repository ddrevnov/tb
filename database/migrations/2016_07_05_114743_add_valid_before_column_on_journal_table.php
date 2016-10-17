<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidBeforeColumnOnJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariffs_admin_journal', function ($table){
           $table->timestamp('valid_before')->after('dashboard_unlimited')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tariffs_admin_journal', function ($table){
            $table->dropColumn('valid_before');
        });
    }
}
