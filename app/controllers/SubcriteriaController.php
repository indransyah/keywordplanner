<?php

class SubcriteriaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /subcriterias
	 *
	 * @return Response
	 */
	public function index()
	{
		return Redirect::to('criteria');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /subcriterias/create
	 *
	 * @return Response
	 */
	public function create($criterion_id = null)
	{
		if (empty($criterion_id)) {
            return Redirect::to('criteria');
        }

        $max = count(Subcriterion::where('criterion_id', $criterion_id)->get());
		if ($max==15) {
			return Redirect::to('criteria')->with('error', 'Just 15 subcriteria allowed!');
		}

        $criterion = Criterion::where('criterion_id', '=', $criterion_id)->count();
        if ($criterion) {
            $this->layout->content = View::make('subcriteria.create')->with('criterion_id', $criterion_id);
        } else {
            return Redirect::to('criteria');
        }
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /subcriterias
	 *
	 * @return Response
	 */
	public function store($criterion_id)
	{
		$max = count(Subcriterion::where('criterion_id', $criterion_id)->get());
		if ($max==15) {
			return Redirect::to('criteria')->with('error', 'Just 15 subcriteria allowed!');
		}
		
		$input = Input::all();
        $rules = Subcriterion::$rules;
        $rules['subcriterion'] .= ',NULL,subcriterion_id,criterion_id,' . $criterion_id;
        $validator = Validator::make($input, $rules);
        if ($validator->passes()) {
            $subcriterion = new Subcriterion;
            $subcriterion->subcriterion = Input::get('subcriterion');
            $subcriterion->description = Input::get('description');
            $subcriterion->conditional = Input::get('conditional');
            $subcriterion->criterion_id = $criterion_id;
            $subcriterion->save();
            return Redirect::to('criteria/' . $criterion_id)
                            ->with('success', 'Subcriterion successfully added!');
        } else {
            return Redirect::to('subcriteria/create/' . $criterion_id)
                            ->with('error', 'The following errors occurred')
                            ->withErrors($validator)
                            ->withInput();
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /subcriterias/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, $criterion_id)
	{
		$subcriterion = Subcriterion::find($id);
        if ($subcriterion) {
            $this->layout->content = View::make('subcriteria.edit')->with(array(
                // 'id' => $id,
                'criterion_id' => $criterion_id,
                'subcriterion' => $subcriterion
                )
            );
        } else {
            return Redirect::to('criteria/'.$criterion_id);
        }
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /subcriterias/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, $criterion_id)
	{
		$input = Input::all();
        $rules = Subcriterion::$rules;
        $rules['subcriterion'] .= ',' . $id . ',subcriterion_id,criterion_id,' . $criterion_id;
        $validator = Validator::make($input, $rules);
        if ($validator->passes()) {
            $subcriterion = Subcriterion::find($id);
            $subcriterion->subcriterion = Input::get('subcriterion');
            $subcriterion->description = Input::get('description');
            $subcriterion->conditional = Input::get('conditional');
            $subcriterion->save();
            return Redirect::to('criteria/' . $criterion_id)
                            ->with('success', 'Subcriterion successfully edited!');
        } else {
            return Redirect::to('subcriteria/' . $id . '/edit/' . $criterion_id)
                            ->with('error', 'The following errors occurred')
                            ->withErrors($validator)
                            ->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /subcriterias/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, $criterion_id)
	{
		$subcriteria = Subcriterion::where('criterion_id', $criterion_id)->with('comparesubcriteria')->get();
		
		// Delete subcriteria judgments
		foreach ($subcriteria as $key => $value) {
			$subcriterion = Subcriterion::find($value['subcriterion_id']);
			$subcriterion->comparesubcriteria()->detach($value['compared_subcriterion_id'], array('judgment' => $value['judgment']));
		}

		// Delete subcriteria
		$subcriterion = Subcriterion::find($id);
        $subcriterion->delete();
        
        // Delete tpv
        foreach ($subcriteria as $subcriterion) {
        	$subcriterion->tpv = 0;
        	$subcriterion->rating = 0;
        	$subcriterion->weight = 0;
        	$subcriterion->save();
        }
        return Redirect::to('criteria/' . $criterion_id)
                        ->with('success', 'Subcriterion successfully deleted!');
	}

}