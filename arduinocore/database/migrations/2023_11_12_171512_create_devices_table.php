<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('token')->nullable();
            $table->float('analog_value_1', 8, 2)->nullable();
            $table->float('analog_value_2', 8, 2)->nullable();

            $table->bigInteger('device_category_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('devices', function($table) {
            $table->foreign('device_category_id')->references('id')->on('device_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
