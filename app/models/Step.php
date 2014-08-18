<?php

class Step extends Eloquent
{
    protected $fillable = [];

    public function leg()
    {
        return $this->belongsTo('Leg');
    }
}