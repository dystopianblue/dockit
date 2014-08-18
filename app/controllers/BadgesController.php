<?php

class BadgesController extends BaseController
{

	/**
	 * Display a listing of the resource.
	 * GET /badges
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        return Response::make(
            array(
                'badges' => Badge::all()
            ),
            200
        );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /badges
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /badges/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        //
        return Response::make(
            array(
                'badges' => Badge::findOrFail($id)
            ),
            200
        );
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /badges/{id}
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
	 * DELETE /badges/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}