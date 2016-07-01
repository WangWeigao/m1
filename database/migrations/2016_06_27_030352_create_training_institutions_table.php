<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('province');
            $table->string('cell_phone');
            $table->string('address');
            $table->string('email');
            $table->string('invite_code');
            $table->string('payment_account');
            $table->boolean('invite_code_status');
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
        Schema::drop('training_institutions');
    }
}
