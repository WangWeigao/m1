<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('province');
            $table->string('cell_phone');
            $table->string('email');
            $table->string('invite_code');
            $table->boolean('invite_code_status');
            $table->string('bank_name');
            $table->string('payment_account');
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
        Schema::drop('training_teachers');
    }
}
