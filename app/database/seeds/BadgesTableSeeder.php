<?php

class BadgesTableSeeder extends Seeder
{

    public function run()
    {
        Eloquent::unguard();
        
        Badge::create([
            'title' => 'Newbie',
            'description' => 'Welcome to DockIt!',
            'condition' => '',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Adventurer',
            'description' => 'You\'ve took 10 trips with Bike Share',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalTrips = 10',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Explorer',
            'description' => 'You\'ve took 100 trips with Bike Share',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalTrips = 100',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Superstar',
            'description' => 'You\'ve took 1000 trips with Bike Share',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalTrips = 1000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Frequent Flyer',
            'description' => 'You\'ve took 10000 trips with Bike Share',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalTrips = 10000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Marathon',
            'description' => 'You\'ve rode the entire distance of a marathon',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalDistance >= 42',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Golden Horseshoe',
            'description' => 'You\'ve rode the total distance between Toronto and Niagara Falls',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalDistance >= 142',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Tour de France',
            'description' => 'Congratulations! You\'ve rode the entire distance of the Tour de France.',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalDistance >= 3663000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Million DockIt Club',
            'description' => 'Congratulations! You\'ve reached 1,000,000 DockIt points',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalPoints >= 1000000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Yellow Jersey',
            'description' => 'Congratulations! You\'ve earned the right to wear the maillot jaune today for covering the most distance in the shortest time',
            'condition' => '',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Polka Dot Jersey',
            'description' => 'Congratulations! You\'re the King or Queen of the roads for trekking a challenging Bike Share route',
            'condition' => 'SELECT * FROM trips WHERE userId = ? AND (stationStartId = 7000 AND stationEndId = 7034) OR 
            (stationStartId = 7010 AND stationEndId = 7025) OR 
            (stationStartId = 7054 AND stationEndId = 7034) OR
            (stationStartId = 7000 AND stationEndId = 7025) OR 
            (stationStartId = 7071 AND stationEndId = 7025) OR
            (stationStartId = 7071 AND stationEndId = 7034) OR 
            (stationStartId = 7075 AND stationEndId = 7025) OR 
            (stationStartId = 7071 AND stationEndId = 7056) OR 
            (stationStartId = 7075 AND stationEndId = 7063) OR 
            (stationStartId = 7075 AND stationEndId = 7003)',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Green Jersey',
            'description' => 'Congratulations! You\'ve saved the most money on gas today',
            'condition' => 'SELECT userId, SUM(gasPrice) AS totalGasPrice FROM trips WHERE DATE_FORMAT(startTime, "%m-%d-%Y") = ? AND userId = ? ORDER BY totalGasPrice GROUP BY userId LIMIT 1',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'White Jersey',
            'description' => 'Congratulations! You\'ve taken the most trips today',
            'condition' => 'SELECT userId, COUNT(*) AS totalTrips FROM trips WHERE DATE_FORMAT(startTime, "%m-%d-%Y") = ? AND userId = ? ORDER BY totalTrips GROUP BY userId LIMIT 1',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Pink Jersey',
            'description' => 'Congratulations! You\'ve scored the most DockIt points today',
            'condition' => 'SELECT * FROM dailyTotals LIMIT 1',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Red Headband',
            'description' => 'Congratulations! You\'ve burned off the most calories today',
            'condition' => 'SELECT userId, SUM(calories) AS totalCalories FROM trips WHERE DATE_FORMAT(startTime, "%m-%d-%Y") = ? AND userId = ? ORDER BY totalCalories GROUP BY userId LIMIT 1',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Cheeseburger',
            'description' => 'You\'ve burned off a cheeseburger',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalCalories >= 303',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Daily Calorie',
            'description' => 'You\'ve burned off a day\'s worth of calories',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalCalories >= 2000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Michael Phelps',
            'description' => 'You\'ve burned off what American Olympic swimmer Michael Phelps consumes in one day',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalCalories >= 12000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Car',
            'description' => 'Your carbon offset has totalled as much a car would emit after 1 km of driving',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalCarbonOffset > 271000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Bus',
            'description' => 'Your carbon offset has totalled as much a bus would emit after 1 km of driving',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalCarbonOffset > 101000',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Cup of Jo',
            'description' => 'You\'ve saved enough money for a cup of extra-large coffee',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalGasPrice >= 1.9',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Fill \'Er Up',
            'description' => 'You\'ve saved enough money for a full tank of gas',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalGasPrice >= 78',
            'image' => '',
            'points' => 0
        ]);

        Badge::create([
            'title' => 'Renew Me',
            'description' => 'You\'ve saved enough money for another year\'s membership worth with Bike Share',
            'condition' => 'SELECT * FROM allTimeTotals WHERE userId = ? AND totalGasPrice >= 101.7',
            'image' => '',
            'points' => 0
        ]);
    }

}