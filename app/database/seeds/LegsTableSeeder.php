<?php

class LegsTableSeeder extends Seeder
{

    public function run()
    {
        Eloquent::unguard();

        //DB::table('steps')->delete();
        //DB::table('legs')->delete();
        $client = new GuzzleHttp\Client();

        $stationsStart = $stationsEnd = Station::all();
        foreach ($stationsStart as $stationStart) {
            foreach ($stationsEnd as $stationEnd) {
                if ($stationStart->landMark !== $stationEnd->landMark) {
                    $res = $client->get(
                        'https://maps.googleapis.com/maps/api/directions/json?origin=' . $stationStart->latitude . ',' . $stationStart->longitude .
                        '&destination=' . $stationEnd->latitude . ',' . $stationEnd->longitude . '&alternatives=true&avoid=highways&mode=bicycling&key=' .
                        $_ENV['GOOGLE_API_KEY']
                    )->json();

                    foreach ($res['routes'] as $routes) {
                        foreach ($routes['legs'] as $legs) {
                            // Assume average man is 170lbs and woman is 145lbs; average bike speed 15-17km/h (10mph)
                            // According to http://www.bicycling.com/training-nutrition/training-fitness/cycling-calories-burned-calculator:
                            // Average man burns 8 calories/min and woman burns 7 calories/min
                            // Assume 250g of CO2e/km (0.25g of CO2e/m) is saved bicycling vs driving according to http://www.ecf.com/news/how-much-co2-does-cycling-really-save/
                            // Assume 7.9L/100 km (0.000079L/m) gas saved from bicycling vs driving at $1.30/L for regular gas
                        
                            $caloriesMen = round((8 / 60) * $legs['duration']['value']);
                            $caloriesWomen = round((7 / 60) * $legs['duration']['value']);
                            $carbonOffset = round(0.25 * $legs['distance']['value']);
                            $gasAmount = 0.000079 * $legs['distance']['value'];
                            $gasPrice = 1.3 * 0.000079 * $legs['distance']['value'];
                            $totalPoints = round(
                                ((1 / 30) * $legs['duration']['value']) + ((1 / 100) * $legs['distance']['value']) + ($caloriesMen / 10) +
                                ($carbonOffset / 125) + ($gasPrice / 0.1)
                            );

                            $newLeg = Leg::create(array(
                                'stationStartId' => $stationStart->landMark,
                                'stationEndId' => $stationEnd->landMark,
                                'distance' => $legs['distance']['value'],
                                'duration' => $legs['duration']['value'],
                                'steps' => count($legs['steps']),
                                'caloriesMen' => $caloriesMen,
                                'caloriesWomen' => $caloriesWomen,
                                'carbonOffset' => $carbonOffset,
                                'gasAmount' => $gasAmount,
                                'gasPrice' => $gasPrice,
                                'totalPoints' => $totalPoints,
                                'polyline' => $routes['overview_polyline']['points']
                            ));

                            for ($s = 0; $s < count($legs['steps']); $s++) {
                                $stepId = Step::create(array(
                                    'legId' => $newLeg->id,
                                    'stepNum' => $s + 1,
                                    'distance' => $legs['steps'][$s]['distance']['value'],
                                    'duration' => $legs['steps'][$s]['duration']['value'],
                                    'startLatitude' => $legs['steps'][$s]['start_location']['lat'],
                                    'startLongitude' => $legs['steps'][$s]['start_location']['lng'],
                                    'endLatitude' => $legs['steps'][$s]['end_location']['lat'],
                                    'endLongitude' => $legs['steps'][$s]['end_location']['lng'],
                                    'instructions' => $legs['steps'][$s]['html_instructions'],
                                    'maneuver' => !empty($legs['steps'][$s]['maneuver']) ? $legs['steps'][$s]['maneuver'] : '',
                                    'polyline' => $legs['steps'][$s]['polyline']['points']
                                ));
                            }
                        }
                    }
                }
            }
        }

    }

}