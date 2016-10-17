<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_details', function ($table) {
            $table->boolean('agreement')->after('admin_id')->default(0);
            $table->string('firm_name')->after('bic')->nullable();
            $table->string('first_last_name')->after('firm_name')->nullable();
            $table->string('post_index')->after('first_last_name')->nullable();
            $table->string('street')->after('post_index')->nullable();
            $table->string('addition_address')->after('street')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_details', function ($table) {
            $table->dropColumn('agreement');
            $table->dropColumn('firm_name');
            $table->dropColumn('first_last_name');
            $table->dropColumn('post_index');
            $table->dropColumn('street');
            $table->dropColumn('addition_address');
        });
    }
}
