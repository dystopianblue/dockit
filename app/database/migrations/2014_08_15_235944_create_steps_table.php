<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStepsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legId')->unsigned();
            $table->integer('stepNum');
            $table->integer('duration');
            $table->integer('distance');
            $table->double('startLatitude');
            $table->double('startLongitude');
            $table->double('endLatitude');
            $table->double('endLongitude');
            $table->text('instructions');
            $table->string('maneuver');
            $table->text('polyline');
            $table->timestamps();
            $table->unique(array('legId', 'stepNum'));
            $table->foreign('legId')->references('id')->on('legs');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('steps');
    }

}
