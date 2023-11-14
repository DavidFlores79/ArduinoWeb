<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('profile_id')->unsigned();

            $table->string('nickname')->nullable()->unique();
            $table->string('phone',10)->nullable();
            $table->string('os_token')->nullable();

            $table->string('termination_date')->nullable();
            $table->boolean('enabled')->default(0);
            $table->boolean('status')->default(1);

            // $table->string('uid')->nullable();
            // $table->time("shift_start_time")->nullable();
            // $table->time("shift_end_time")->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
