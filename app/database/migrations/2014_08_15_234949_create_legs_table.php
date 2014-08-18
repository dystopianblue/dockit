<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLegsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stationStartId')->unsigned();
            $table->integer('stationEndId')->unsigned();
            $table->integer('duration');
            $table->integer('distance');
            $table->integer('steps');
            $table->integer('caloriesMen');
            $table->integer('caloriesWomen');
            $table->integer('carbonOffset');
            $table->double('gasAmount');
            $table->double('gasPrice');
            $table->integer('totalPoints');
            $table->text('polyline');
            $table->timestamps();
            $table->foreign('stationStartId')->references('landMark')->on('stations');
            $table->foreign('stationEndId')->references('landMark')->on('stations');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('legs');
    }

}
