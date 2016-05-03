<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDurationExpirationRecordErrorsColumnsToPlayRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('play_records', function (Blueprint $table) {
            $table->integer('duration')->comment('单位是秒');
            $table->datetime('record_expiration')->comment('录音过期时间');
            $table->string('errors')->comment('用一种数据结构包含一首曲子中所有的错误');
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
            $table->dropColumn('duration');
            $table->dropColumn('record_expiration');
            $table->dropColumn('errors');
        });
    }
}
