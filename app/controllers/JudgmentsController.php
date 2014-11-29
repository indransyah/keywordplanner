<?php

class JudgmentsController extends \BaseController {

    protected $options = array(
        '1' => '1. Sama penting dengan',
        '2' => '2. Mendekati sedikit lebih penting dari',
        '3' => '3. Sedikit lebih penting dari',
        '4' => '4. Mendekati lebih penting dari',
        '5' => '5. Lebih penting dari',
        '6' => '6. Mendekati sangat penting dari',
        '7' => '7. Sangat penting dari',
        '8' => '8. Mendekati mutlak dari',
        '9' => '9. Mutlak sangat penting dari'
    );

    public function getCriteria()
    {        
        $criteria = Criterion::all();
        $this->layout->content = View::make('judgments.criteria')->with(array('criteria' => $criteria, 'options' => $this->options));
    }

    public function getSubcriteria($criterion_id = null)
    {
        $criterion = Criterion::find($criterion_id);
        $subcriteria = Subcriterion::where('criterion_id', '=', $criterion_id)->get();
        $this->layout->content = View::make('judgments.subcriteria')->with(array(
            'criterion' => $criterion,
            'subcriteria' => $subcriteria,
            'options' => $this->options
            ));
    }

}
