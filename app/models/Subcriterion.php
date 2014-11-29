<?php

class Subcriterion extends \Eloquent {
	protected $table = 'subcriteria';
    protected $primaryKey = 'subcriterion_id';
    public $timestamps = false;
    public static $rules = array(
        'subcriterion' => 'required|max:30|unique:subcriteria,subcriterion',
        'description' => 'required|max:200',
        'range' => 'required'
    );

    public function criteria()
    {
        return $this->belongsTo('Criterion', 'criterion_id', 'criterion_id');
    }

    public function comparesubcriteria()
	{
		return $this->belongsToMany('Subcriterion', 'subcriteria_judgments', 'subcriterion_id', 'compared_subcriterion_id')->withPivot('judgment');
	}

	public function comparedsubcriteria()
	{
		return $this->belongsToMany('Subcriterion', 'subcriteria_judgments', 'compared_subcriterion_id', 'subcriterion_id')->withPivot('judgment');
	}
}