<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidColumnToRobotOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('robot_orders', function (Blueprint $table) {
            $table->string('paid')->default(0)->comment('是否已结算给机构和教师');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('robot_orders', function (Blueprint $table) {
            $table->dropColumn('paid');
        });
    }
}
