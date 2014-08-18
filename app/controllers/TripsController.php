<?php

class TripsController extends BaseController {

	/**
	 * Store a newly created resource in storage.
	 * POST /trips
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /trips/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        return Response::make(
            array(
                'trips' => Trip::findOrFail($id)
            ),
            200
        );
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /trips/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /trips/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}