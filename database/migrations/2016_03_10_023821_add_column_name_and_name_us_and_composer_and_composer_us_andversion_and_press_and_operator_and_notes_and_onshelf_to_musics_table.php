<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNameAndNameUsAndComposerAndComposerUsAndversionAndPressAndOperatorAndNotesAndOnshelfToMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musics', function(Blueprint $table) {
            $table->string('instrument_id');
            $table->string('name_us');
            $table->string('composer');
            $table->string('composer_us');
            $table->string('version');
            $table->integer('press');
            $table->string('operator');
            $table->text('notes');
            $table->boolean('onshelf');
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
            $table->dropColumn('instrument_id');
            $table->dropColumn('name_us');
            $table->dropColumn('composer');
            $table->dropColumn('composer_us');
            $table->dropColumn('version');
            $table->dropColumn('press');
            $table->dropColumn('operator');
            $table->dropColumn('notes');
            $table->dropColumn('onshelf');
        });
    }
}
