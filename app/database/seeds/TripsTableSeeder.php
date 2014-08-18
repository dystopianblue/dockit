<?php

class TripsTableSeeder extends Seeder
{

    public function run()
    {
        Eloquent::unguard();

        //DB::table('trips')->delete();

        $bikeTrips = fopen('/var/www/dockit/HackBikeShareTO-Trips.csv', 'r');
        if ($bikeTrips !== false) {
            $firstRow = true;

            while (!feof($bikeTrips)) {
                $bikeTrip = fgetcsv($bikeTrips, 1000, ",");

                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }

                if (count($bikeTrip) == 11 && !empty($bikeTrip[4]) && !empty($bikeTrip[7]) && !empty($bikeTrip[10])) {
                    $user = User::where('zipCode', $bikeTrip[10])->get();
                    $leg = Leg::where('stationStartId', $bikeTrip[4])->where('stationEndId', $bikeTrip[7])->get();
                } else {
                    continue;
                }

                if (!$user->isEmpty() && !$leg->isEmpty()) {
                    sscanf($bikeTrip[1], "%d:%d:%d", $hours, $minutes, $seconds);
                    $duration = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $calories = ($user[0]->gender === 'm') ? round((8 / 60) * $duration) : round((7 / 60) * $duration);
                    $durationPoints = (1 / 30) * $duration;
                    $distancePoints = (1 / 100) * $leg[0]->distance;
                    $stepPoints = 0;
                    $caloriePoints = $calories / 10;
                    $carbonOffsetPoints = $leg[0]->carbonOffset / 125;
                    $gasPricePoints = $leg[0]->gasPrice / 0.10;

                    Trip::create([
                        'id' => $bikeTrip[0],
                        'userId' => $user[0]->id,
                        'legId' => $leg[0]->id,
                        'bikeId' => $bikeTrip[8],
                        'stationStartId' => $bikeTrip[4],
                        'stationEndId' => $bikeTrip[7],
                        'startTime' => date('Y-m-d H:i:s', strtotime($bikeTrip[2])),
                        'endTime' => date('Y-m-d H:i:s', strtotime($bikeTrip[5])),
                        'duration' => $duration,
                        'distance' => $leg[0]->distance,
                        'steps' => $leg[0]->steps,
                        'calories' => $calories,
                        'carbonOffset' => $leg[0]->carbonOffset,
                        'gasPrice' => $leg[0]->gasPrice,
                        'durationPoints' => $durationPoints,
                        'distancePoints' => $distancePoints,
                        'stepPoints' => $stepPoints,
                        'caloriePoints' => $caloriePoints,
                        'carbonOffsetPoints' => $carbonOffsetPoints,
                        'gasPricePoints' => $gasPricePoints,
                        'totalPoints' => round($durationPoints + $distancePoints + $stepPoints + $caloriePoints + $carbonOffsetPoints + $gasPricePoints)
                    ]);
                }
            }
        }
        fclose($bikeTrips);
    }

}
