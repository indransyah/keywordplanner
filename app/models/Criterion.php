<?php

class Criterion extends \Eloquent {
	protected $table = 'criteria';
    protected $primaryKey = 'criterion_id';
    public $timestamps = false;
    public static $rules = array(
        'criterion' => 'required|max:30|unique:criteria,criterion',
        'description' => 'required|max:200',
        'field' => 'required|unique:criteria,field'
    );

    public function subcriteria()
    {
        return $this->hasMany('Subcriterion', 'criterion_id', 'criterion_id');
    }

    // public function subcriteriajudgments()
    // {
    //     return $this->hasMany('SubcriteriaJudgment', 'criterion_id', 'criterion_id');
    // }

    public function comparecriteria()
	{
		return $this->belongsToMany('Criterion', 'criteria_judgments', 'criterion_id', 'compared_criterion_id')->withPivot('judgment');
	}

	public function comparedcriteria()
	{
		return $this->belongsToMany('Criterion', 'criteria_judgments', 'compared_criterion_id', 'criterion_id')->withPivot('judgment');
	}
}