<?php

class Station extends Eloquent
{
	protected $fillable = [];

    public function startLegs()
    {
        return $this->hasMany('Leg', 'stationStartId');
    }

    public function endLegs()
    {
        return $this->hasMany('Leg', 'stationEndId');
    }

    public function startTrips()
    {
        return $this->hasMany('Trip', 'stationStartId');
    }

    public function endTrips()
    {
        return $this->hasMany('Trip', 'stationEndId');
    }
}