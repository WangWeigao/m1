<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnAuthToAuthorInMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 重命名列
        Schema::table('musics', function(Blueprint $table) {
            $table->renameColumn('auth', 'author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 重命名列
        Schema::table('musics', function(Blueprint $table) {
            $table->renameColumn('author', 'auth');
        });
    }
}
