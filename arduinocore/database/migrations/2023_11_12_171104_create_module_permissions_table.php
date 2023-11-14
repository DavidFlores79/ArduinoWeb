<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('module_id')->unsigned(); 
            $table->bigInteger('permission_id')->unsigned();

            
            $table->timestamps();
        });

        Schema::table('module_permissions', function($table) {
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });

        Schema::table('module_permissions', function($table) {
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_permissions');
    }
}
