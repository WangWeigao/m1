<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilenameColumnToMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 添加一个filename列, 存入文件名
        Schema::table('musics', function(Blueprint $table) {
            $table->string('filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musics', function(Blueprint $table) {
            $table->dropColumn('filename');
        });
    }
}
