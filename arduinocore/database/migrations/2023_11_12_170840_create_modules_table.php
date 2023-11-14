<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();

            $table->string('name',100);
            $table->mediumText('description')->nullable();
            $table->string('route',100)->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);

            $table->bigInteger('category_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('modules', function($table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
