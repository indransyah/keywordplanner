<?php

class Campaign extends \Eloquent {
	protected $table = 'campaigns';
    protected $primaryKey = 'campaign_id';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'user_id');
    }

     public function keyword()
    {
        return $this->hasMany('Keyword', 'keyword_id', 'keyword_id');
    }
}
