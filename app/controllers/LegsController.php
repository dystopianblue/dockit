<?php

class LegsController extends BaseController
{

    /**
     * Display the specified resource.
     * GET /legs/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        return Response::make(
            array(
                'legs' => Leg::findOrFail($id)
            ),
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $start
     * @return Response
     */
    public function toClosestStartStation($start)
    {
        //
        $client = new GuzzleHttp\Client();

        $stations = Station::all();
        foreach ($stations as $station) {
            if ($station->availableBikes / $station->totalDocks > 0.1 && $station->statusValue == 'In Service') {
                $stationId[] = $station->landMark;
                $stationName[] = $station->stationName;
                $latitude[] = $station->latitude;
                $longitude[] = $station->longitude;
                $latLng[] = $station->latitude . ',' . $station->longitude;
            }
        }

        $end = implode('|', $latLng);

        $res = $client->get(
            'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $start . '&destinations=' . $end . '&avoid=highways&&mode=walking&key=' .
            $_ENV['GOOGLE_API_KEY']
        )->json();

        for ($i = 0; $i < count($res['rows'][0]['elements']); $i++) {
            $distance[] = $res['rows'][0]['elements'][$i]['distance']['value'];
            $startStation[] = array(
                'id' => $stationId[$i],
                'name' => $stationName[$i],
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i]
            );
        }

        array_multisort($distance, $startStation);

        $res = $client->get(
            'https://maps.googleapis.com/maps/api/directions/json?origin=' . $start .
            '&destination=' . $startStation[0]['latitude'] . ',' . $startStation[0]['longitude'] . '&avoid=highways&mode=walking&key=' .
            $_ENV['GOOGLE_API_KEY']
        )->json();

        return array(
            'id' => $startStation[0]['id'],
            'stationName' => $startStation[0]['name'],
            'distance' => $res['routes'][0]['legs'][0]['distance']['value'],
            'duration' => $res['routes'][0]['legs'][0]['duration']['value'],
            'steps' => $res['routes'][0]['legs'][0]['steps'],
            'polyline' => $res['routes'][0]['overview_polyline']['points']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $end
     * @return Response
     */
    public function fromClosestEndStation($end)
    {
        //
        $client = new GuzzleHttp\Client();

        $stations = Station::all();
        foreach ($stations as $station) {
            if ($station->availableDocks / $station->totalDocks > 0.1 && $station->statusValue == 'In Service') {
                $stationId[] = $station->landMark;
                $stationName[] = $station->stationName;
                $latitude[] = $station->latitude;
                $longitude[] = $station->longitude;
                $latLng[] = $station->latitude . ',' . $station->longitude;
            }
        }

        $start = implode('|', $latLng);

        $res = $client->get(
            'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $start . '&destinations=' . $end . '&avoid=highways&&mode=walking&key=' .
            $_ENV['GOOGLE_API_KEY']
        )->json();

        for ($i = 0; $i < count($res['rows']); $i++) {
            $distance[] = $res['rows'][$i]['elements'][0]['distance']['value'];
            $endStation[] = array(
                'id' => $stationId[$i],
                'name' => $stationName[$i],
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i]
            );
        }

        array_multisort($distance, $endStation);

        $res = $client->get(
            'https://maps.googleapis.com/maps/api/directions/json?origin=' . $endStation[0]['latitude'] . ',' . $endStation[0]['longitude'] .
            '&destination=' . $end . '&avoid=highways&mode=walking&key=' .
            $_ENV['GOOGLE_API_KEY']
        )->json();

        return array(
            'id' => $endStation[0]['id'],
            'stationName' => $endStation[0]['name'],
            'distance' => $res['routes'][0]['legs'][0]['distance']['value'],
            'duration' => $res['routes'][0]['legs'][0]['duration']['value'],
            'steps' => $res['routes'][0]['legs'][0]['steps'],
            'polyline' => $res['routes'][0]['overview_polyline']['points']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $start
     * @param  string  $end
     * @return Response
     */
    public function directWalking($start, $end)
    {
        //
        $client = new GuzzleHttp\Client();

        $res = $client->get(
            'https://maps.googleapis.com/maps/api/directions/json?origin=' . $start . '&destination=' . $end .
            '&avoid=highways&mode=walking&key=' .
            $_ENV['GOOGLE_API_KEY']
        )->json();

        return array(
            'distance' => $res['routes'][0]['legs'][0]['distance']['value'],
            'duration' => $res['routes'][0]['legs'][0]['duration']['value'],
            'steps' => $res['routes'][0]['legs'][0]['steps'],
            'polyline' => $res['routes'][0]['overview_polyline']['points']
        );
    }

    /**
     * Display the specified resource.
     * GET /legs/start/{start}/end/{end}
     *
     * @param  string  $start
     * @param  string  $end
     * @return Response
     */
    public function showRouteLegs($start, $end)
    {
        //
        $startLeg = $this->toClosestStartStation($start);
        $endLeg = $this->fromClosestEndStation($end);
        $stationLegs = Leg::where('stationStartId', $startLeg['id'])->where('stationEndId', $endLeg['id'])->with('steps')->get();

        return Response::make(
            array(
                'startLeg' => $startLeg,
                'stationLegs' => $stationLegs,
                'endLeg' => $endLeg,
                'walking' => $this->directWalking($start, $end)
            ),
            200
        );
    }

    /**
     * Display the specified resource.
     * GET /legs/startStation/{stationStartId}/endStation/{stationEndId}
     *
     * @param  int  $id
     * @return Response
     */
    public function showStationLegs($stationStartId, $stationEndId)
    {
        //
        return Response::make(
            array(
                'legs' => Leg::where('stationStartId', $stationStartId)->where('stationEndId', $stationEndId)->with('steps')->get()
            ),
            200
        );
    }

}