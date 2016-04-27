<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMidiPathWavPathExpirationColumnsToPracticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice', function (Blueprint $table) {
            $table->string('midi_path');
            $table->string('wav_path');
            $table->datetime('expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practice', function (Blueprint $table) {
            $table->dropColumn('midi_path');
            $table->dropColumn('wav_path');
            $table->dropColumn('expiration');
        });
    }
}
