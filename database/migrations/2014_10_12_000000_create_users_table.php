<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('gmail_id')->unique()->nullable();
            $table->string('fb_id')->unique()->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('phone_number')->unsigned()->unique()->nullable();
            $table->string('password')->unique()->nullable();
            $table->string('profile')->nullable();
            $table->string('bio')->nullable();
            // $table->string('profile')->nullable();
            $table->integer('point')->unsigned()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
