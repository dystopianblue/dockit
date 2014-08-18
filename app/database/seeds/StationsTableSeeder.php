<?php

class StationsTableSeeder extends Seeder
{

    public function run()
    {
        Eloquent::unguard();

        //DB::table('stations')->delete();

        $client = new GuzzleHttp\Client();
        $res = $client->get('http://www.bikesharetoronto.com/stations/json')->json();
        foreach ($res['stationBeanList'] as $station) {
            $stationExists = Station::find($station['id']);

            if ($stationExists) {
                $stationExists->stationName = $station['stationName'];
                $stationExists->availableDocks = $station['availableDocks'];
                $stationExists->totalDocks = $station['totalDocks'];
                $stationExists->latitude = $station['latitude'];
                $stationExists->longitude = $station['longitude'];
                $stationExists->statusValue = $station['statusValue'];
                $stationExists->statusKey = $station['statusKey'];
                $stationExists->availableBikes = $station['availableBikes'];
                $stationExists->stAddress1 = $station['stAddress1'];
                $stationExists->stAddress2 = $station['stAddress2'];
                $stationExists->city = $station['city'];
                $stationExists->postalCode = $station['postalCode'];
                $stationExists->location = $station['location'];
                $stationExists->altitude = $station['altitude'];
                $stationExists->testStation = $station['testStation'];
                $stationExists->lastCommunicationTime = $station['lastCommunicationTime'];
                $stationExists->landMark = $station['landMark'];
                $stationExists->save();
            } else {
                Station::create($station);
            }
        }
    }

}