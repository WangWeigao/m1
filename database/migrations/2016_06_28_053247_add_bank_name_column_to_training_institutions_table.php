<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankNameColumnToTrainingInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_institutions', function (Blueprint $table) {
            $table->string('bank_name');
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
            $table->dropColumn('bank_name');
        });
    }
}
