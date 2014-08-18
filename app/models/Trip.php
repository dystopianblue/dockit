<?php

class Trip extends Eloquent
{
	protected $fillable = [];

    public function startStation()
    {
        return $this->belongsTo('Station', 'stationStartId');
    }
    
    public function endStation()
    {
        return $this->belongsTo('Station', 'stationEndId');
    }

    public function user()
    {
        return $this->belongsTo('User', 'userId');
    }
}