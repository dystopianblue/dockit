<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => 'api/v1'), function () {
    Route::get('users/{id}/trips', array('uses' => 'UsersController@showTrips'))
    ->where('id', '[0-9]+');

    Route::get('users/{id}/dailyTotals', array('uses' => 'UsersController@showDailyTotals'))
    ->where('id', '[0-9]+');

    Route::get('users/{id}/weeklyTotals', array('uses' => 'UsersController@showWeeklyTotals'))
    ->where('id', '[0-9]+');

    Route::get('users/{id}/monthlyTotals', array('uses' => 'UsersController@showMonthlyTotals'))
    ->where('id', '[0-9]+');

    Route::get('users/{id}/allTimeTotals', array('uses' => 'UsersController@showAllTimeTotals'))
    ->where('id', '[0-9]+');

    Route::get('users/{id}/badges', array('uses' => 'UsersController@showBadges'))
    ->where('id', '[0-9]+');

    Route::resource('users', 'UsersController');

    Route::resource('stations', 'StationsController');

    Route::get('legs/start/{start}/end/{end}', array('uses' => 'LegsController@showRouteLegs'));

    Route::get('legs/startStation/{stationStartId}/endStation/{stationEndId}', array('uses' => 'LegsController@showStationLegs'))
    ->where(array('stationStartId' => '[0-9]+', 'stationEndId' => '[0-9]+'));

    Route::resource('legs', 'LegsController');

    Route::resource('steps', 'StepsController');

    Route::resource('trips', 'TripsController');

    Route::resource('badges', 'BadgesController');

    Route::get('scoreboard/dailyTotals/{day}', function ($day) {
        return Response::make(
            array(
                'dailyTotals' => DB::select("SELECT * FROM dailyTotals WHERE day = ?", array($day))
            ),
            200
        );
    });

    Route::get('scoreboard/weeklyTotals/{week}', function ($week) {
        return Response::make(
            array(
                'weeklyTotals' => DB::select("SELECT * FROM weeklyTotals WHERE week = ?", array($week))
            ),
            200
        );
    })->where('week', '[0-9]+');

    Route::get('scoreboard/monthlyTotals/{month}', function ($month) {
        return Response::make(
            array(
                'monthlyTotals' => DB::select("SELECT * FROM monthlyTotals WHERE month = ?", array($month))
            ),
            200
        );
    });

    Route::get('scoreboard/allTimeTotals', function () {
        return Response::make(
            array(
                'allTimeTotals' => DB::select("SELECT * FROM allTimeTotals")
            ),
            200
        );
    });
});
