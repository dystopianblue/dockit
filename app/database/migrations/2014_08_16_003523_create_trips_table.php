<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTripsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->integer('legId')->unsigned();
            $table->string('bikeId');
            $table->integer('stationStartId')->unsigned();
            $table->integer('stationEndId')->unsigned();
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->integer('duration');
            $table->integer('distance');
            $table->integer('steps');
            $table->integer('calories');
            $table->integer('carbonOffset');
            $table->double('gasPrice');
            $table->double('durationPoints');
            $table->double('distancePoints');
            $table->double('stepPoints');
            $table->double('caloriePoints');
            $table->double('carbonOffsetPoints');
            $table->double('gasPricePoints');
            $table->integer('totalPoints');
            $table->timestamps();
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('legId')->references('id')->on('legs');
            $table->foreign('stationStartId')->references('landMark')->on('stations');
            $table->foreign('stationEndId')->references('landMark')->on('stations');
        });

        DB::statement(
            'CREATE VIEW dailyTotals as SELECT trips.userId, users.username, DATE_FORMAT(startTime, "%m-%d-%Y") as day, COUNT(*) as totalTrips, 
            COUNT(DISTINCT bikeId) as totalUniqueBikes, SUM(duration) as totalDuration, SUM(distance) as totalDistance, SUM(steps) as totalSteps, 
            SUM(calories) as totalCalories, SUM(carbonOffset) as totalCarbonOffset, SUM(gasPrice) as totalGasPrice, SUM(totalPoints) as totalPoints 
            FROM trips, users 
            WHERE trips.userId = users.id 
            GROUP BY trips.userId, DATE_FORMAT(startTime, "%m-%d-%Y") 
            ORDER BY DATE_FORMAT(startTime, "%m-%d-%Y") DESC, totalPoints DESC'
        );

        DB::statement(
            'CREATE VIEW weeklyTotals as SELECT trips.userId, users.username, WEEK(startTime) as week, COUNT(*) as totalTrips, 
            COUNT(DISTINCT bikeId) as totalUniqueBikes, SUM(duration) as totalDuration, SUM(distance) as totalDistance, SUM(steps) as totalSteps, 
            SUM(calories) as totalCalories, SUM(carbonOffset) as totalCarbonOffset, SUM(gasPrice) as totalGasPrice, SUM(totalPoints) as totalPoints 
            FROM trips, users 
            WHERE trips.userId = users.id 
            GROUP BY trips.userId, WEEK(startTime) 
            ORDER BY WEEK(startTime) DESC, totalPoints DESC'
        );

        DB::statement(
            'CREATE VIEW monthlyTotals as SELECT trips.userId, users.username, DATE_FORMAT(startTime, "%m-%Y") as month, COUNT(*) as totalTrips, 
            COUNT(DISTINCT bikeId) as totalUniqueBikes, SUM(duration) as totalDuration, SUM(distance) as totalDistance, SUM(steps) as totalSteps, 
            SUM(calories) as totalCalories, SUM(carbonOffset) as totalCarbonOffset, SUM(gasPrice) as totalGasPrice, SUM(totalPoints) as totalPoints 
            FROM trips, users 
            WHERE trips.userId = users.id 
            GROUP BY trips.userId, DATE_FORMAT(startTime, "%m-%Y") 
            ORDER BY DATE_FORMAT(startTime, "%m-%Y") DESC, totalPoints DESC'
        );

        DB::statement(
            'CREATE VIEW allTimeTotals as SELECT trips.userId, users.username, COUNT(*) as totalTrips, 
            COUNT(DISTINCT bikeId) as totalUniqueBikes, SUM(duration) as totalDuration, SUM(distance) as totalDistance, SUM(steps) as totalSteps, 
            SUM(calories) as totalCalories, SUM(carbonOffset) as totalCarbonOffset, SUM(gasPrice) as totalGasPrice, SUM(totalPoints) as totalPoints 
            FROM trips, users 
            WHERE trips.userId = users.id 
            GROUP BY trips.userId 
            ORDER BY totalPoints DESC'
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trips');
        DB::statement('DROP VIEW dailyTotals');
        DB::statement('DROP VIEW weeklyTotals');
        DB::statement('DROP VIEW monthlyTotals');
        DB::statement('DROP VIEW allTimeTotals');
    }

}
