<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_values', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->float('value', 8, 2)->nullable();

            $table->bigInteger('device_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('device_values', function($table) {
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_values');
    }
}
