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
            $table->integer('seq_num');         // 编号
            $table->integer('province_id');     // 已有一张province表
            $table->integer('city_id');         // 已有一张city表
            $table->string('sex');              // 性别
            $table->integer('study_age');       // 学龄
            $table->integer('user_grade');      // 用户"水平等级"
            $table->integer('account_grade');   // 帐号等级
            $table->datetime('account_end_at'); // 账号截止时间
            $table->integer('account_status');  // 1.待审核 2.被退回 3.已上线
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
            $table->dropColumn('province_id');
            $table->dropColumn('city_id');
            $table->dropColumn('sex');
            $table->dropColumn('study_age');
            $table->dropColumn('user_grade');
            $table->dropColumn('account_grade');
            $table->dropColumn('account_end_at');
            $table->dropColumn('account_status');
        });
    }
}
