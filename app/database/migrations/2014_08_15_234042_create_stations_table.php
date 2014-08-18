<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stationName');
            $table->integer('availableDocks');
            $table->integer('totalDocks');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('statusValue');
            $table->integer('statusKey');
            $table->integer('availableBikes');
            $table->string('stAddress1')->nullable();
            $table->string('stAddress2')->nullable();
            $table->string('city')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('location')->nullable();
            $table->string('altitude')->nullable();
            $table->boolean('testStation');
            $table->dateTime('lastCommunicationTime');
            $table->integer('landMark')->unsigned();
            $table->timestamps();
            $table->unique('stationName');
            $table->unique('landMark');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stations');
    }

}
