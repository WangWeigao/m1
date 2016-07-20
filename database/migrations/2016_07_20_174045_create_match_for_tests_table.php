<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchForTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_for_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('practice_id');
            $table->string('param_n');
            $table->string('param_s');
            $table->string('param_c');
            $table->string('param_w');
            $table->string('origin_midi_path')->comment('wav转midi生成的原始文件');
            $table->string('midi_path')->comment('匹配后生成的midi文件');
            $table->integer('match_score');
            $table->integer('bpm_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match_for_tests');
    }
}
