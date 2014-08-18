<?php

class Leg extends Eloquent
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

    public function steps()
    {
        return $this->hasMany('Step', 'legId');
    }
}
