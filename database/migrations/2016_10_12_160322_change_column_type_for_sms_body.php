<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeForSmsBody extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		\DB::statement('ALTER TABLE `admin_sms_data` CHANGE `body` `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    \DB::statement('ALTER TABLE `admin_sms_data` CHANGE `body` `body` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;');
    }
}
