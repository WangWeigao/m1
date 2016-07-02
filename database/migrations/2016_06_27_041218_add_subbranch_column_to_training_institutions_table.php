<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubbranchColumnToTrainingInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_institutions', function (Blueprint $table) {
            $table->string('subbranch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_institutions', function (Blueprint $table) {
            $table->dropColumn('subbranch');
        });
    }
}
