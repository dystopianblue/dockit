<?php

class UsersController extends BaseController
{

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        return Response::make(
            array(
                'users' => User::findOrFail($id)
            ),
            200
        );
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}/dailyTotals
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showDailyTotals($id)
	{
		//
        return Response::make(
            array(
                'dailyTotals' => DB::select("SELECT * FROM dailyTotals WHERE userId = ?", array($id))
            ),
            200
        );
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}/weeklyTotals
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showWeeklyTotals($id)
	{
		//
        return Response::make(
            array(
                'weeklyTotals' => DB::select("SELECT * FROM weeklyTotals WHERE userId = ?", array($id))
            ),
            200
        );
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}/monthlyTotals
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showMonthlyTotals($id)
	{
		//
        return Response::make(
            array(
                'monthlyTotals' => DB::select("SELECT * FROM monthlyTotals WHERE userId = ?", array($id))
            ),
            200
        );
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}/allTimeTotals
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showAllTimeTotals($id)
	{
		//
        return Response::make(
            array(
                'allTimeTotals' => DB::select("SELECT * FROM allTimeTotals WHERE userId = ?", array($id))
            ),
            200
        );
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}/trips
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showTrips($id)
	{
		//
        return Response::make(
            array(
                'trips' => Trip::where('userId', $id)->orderBy('startTime', 'desc')->with('startStation')->with('endStation')->get()
            ),
            200
        );
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}/badges
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showBadges($id)
	{
		//
        return Response::make(
            array(
                'badges' => User::findOrFail($id)->badges()
            ),
            200
        );
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
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
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}