<?php

class Badge extends Eloquent
{
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('condition');

    public function users()
    {
        return $this->belongsToMany('User');
    }
}