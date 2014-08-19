<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	/*public function showWelcome()
	{
		return View::make('hello');
	}*/

	public function getIndex()
	{
		// $criteria = Criterion::with('comparecriteria')->get();
		// $totalJudgments = count($criteria)*count($criteria);
		// $tmp = 0;
		// foreach ($criteria as $key => $criterion) {
		// 	$tmp = count($criterion->comparecriteria)+$tmp;
		// }
		// if ($totalJudgments==$tmp) {
		// 	return 'con';
		// } else {
		// 	return 'not';
		// }
		// return count($criteria->comparecriteria);

		// $conditional='word';
		// $value = 'word';
		// $range = explode('-', $conditional);
		// if (count($range)==2) {
		// 	if ($this->range($value, $range[0], $range[1])) {
		// 		return 'dalam';
		// 	} else {
		// 		return 'luar';
		// 	}
		// } else {
		// 	if ($value==$conditional) {
		// 		return 'ok';
		// 	}
		// }
		// return count($range);

		$this->layout->content = View::make('dashboard');
	}

	// public function range($value, $min, $max){
	// 	if($value < $min) return false;
	// 	if($value > $max) return false;
	// 	return true;
	// }

}
