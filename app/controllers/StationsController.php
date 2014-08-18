<?php

class StationsController extends BaseController
{

    /**
     * Display a listing of the resource.
     * GET /stations
     *
     * @return Response
     */
    public function index()
    {
        //
        return Response::make(
            array(
                'stations' => Station::all()
            ),
            200
        );
    }

    /**
     * Display the specified resource.
     * GET /stations/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        return Response::make(
            array(
                'stations' => Station::findOrFail($id)
            ),
            200
        );
    }

}