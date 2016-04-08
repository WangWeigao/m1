<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdAndStartTimeToPlayRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('play_records', function (Blueprint $table) {
            $table->string('user_id');
            $table->datetime('start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('play_records', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('start_time');
        });
    }
}
