<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropcolumnAuthorAndAddColumnDeletedAtToMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musics', function(Blueprint $table) {
            $table->dropColumn('author');
            $table->softDeletes();
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
            $table->string('author');
            $table->dropColumn('deleted_at');
        });
    }
}
