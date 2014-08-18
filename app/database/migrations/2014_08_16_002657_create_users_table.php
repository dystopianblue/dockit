<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('username');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('zipCode');
            $table->enum('gender', array('m', 'f'))->default('m');
            $table->integer('weight')->nullable();
            $table->enum('membershipType', array('Registered', 'Casual'))->default('Registered');
            $table->string('image')->nullable();
            $table->boolean('dockIt');
            $table->unique('username');
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
        Schema::drop('users');
    }

}
