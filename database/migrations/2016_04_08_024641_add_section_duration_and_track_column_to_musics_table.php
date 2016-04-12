<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSectionDurationAndTrackColumnToMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musics', function(Blueprint $table) {
            $table->integer('section_duration');
            $table->integer('track');
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
            $table->dropColumn('section_duration');
            $table->dropColumn('track');
        });
    }
}
