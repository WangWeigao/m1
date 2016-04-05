<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add13ColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('seq_num');
            $table->integer('country');     // 需要再加 1 张表
            $table->integer('city');        // 需要再加 1 张表
            $table->string('sex');          // 性别
            $table->integer('study_age');   // 学龄
            $table->integer('instrument_grade');    // 需要再加 1 张表
            $table->integer('instrument');      // 需要再加 2 张表
            $table->integer('account_grade');   // 需要再加 1 张表
            $table->datetime('account_end_at'); // 账号截止时间
            $table->string('submit_data');      // 
            $table->integer('data_status');
            $table->integer('account_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('seq_num');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('sex');
            $table->dropColumn('study_age');
            $table->dropColumn('instrument_grade');
            $table->dropColumn('instrument');
            $table->dropColumn('account_grade');
            $table->dropColumn('account_end_at');
            $table->dropColumn('submit_data');
            $table->dropColumn('data_status');
            $table->dropColumn('account_status');
        });    }
}
