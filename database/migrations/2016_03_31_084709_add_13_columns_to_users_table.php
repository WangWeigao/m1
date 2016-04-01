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
            $table->string('sex');
            $table->integer('study_age');
            $table->integer('instrument_grade');    // 需要再加 1 张表
            $table->integer('instrument');      // 需要再加 2 张表
            $table->integer('account_grade');   // 需要再加 1 张表
            $table->datetime('account_end_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
