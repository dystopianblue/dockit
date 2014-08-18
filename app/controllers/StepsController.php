<?php

class StepsController extends BaseController
{

	/**
	 * Display the specified resource.
	 * GET /steps/{id}
	 *
	 * @param  int  $stepId
	 * @return Response
	 */
	public function show($legId)
	{
		//
        return Response::make(
            array(
                'steps' => Step::where('legId', $legId)->orderBy('stepNum')->get()
            ),
            200
        );
	}

}