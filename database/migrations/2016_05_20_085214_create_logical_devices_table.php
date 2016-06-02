<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogicalDevicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logical_devices', function (Blueprint $table) {
            $table->string('ip')->primary();
            $table->string('type');
            $table->string('username');
            $table->string('password');
            $table->text('os');
            $table->string('service');
            $table->string('nicinfo');
            $table->string('device');
            $table->text('details');
            $table->text('note');
            $table->integer('user_id');
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
        Schema::drop('logical_devices');
    }
}
