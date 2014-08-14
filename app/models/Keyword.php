<?php

class Keyword extends \Eloquent {
	protected $table = 'keywords';
    protected $primaryKey = 'keyword_id';
    public $timestamps = false;
    public static $rules = array(
        // 'group' => 'required',
        'keyword' => 'required',
        // 'currency' => 'required',
        'search' => 'required|integer',
        'competition' => 'required',
        'bid' => 'required',
        // 'impression' => 'required',
        // 'account' => 'required',
        // 'plan' => 'required',
        // 'extract' => 'sometimes'
    );
}