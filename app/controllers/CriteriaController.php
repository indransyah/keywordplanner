<?php

class CriteriaController extends \BaseController {

	protected $fields = array(
        'word' => 'Word',
        'search' => 'Search',
        'competition' => 'Competition',
        'bid' => 'BID'
    );

	/**
	 * Display a listing of the resource.
	 * GET /criterias
	 *
	 * @return Response
	 */
	public function index()
	{

		$criteria = Criterion::all();
        $this->layout->content = View::make('criteria.index')->with('criteria', $criteria);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /criterias/create
	 *
	 * @return Response
	 */
	public function create()
	{
		// Check max criteria = 4
		$max = count(Criterion::all());
		if ($max==4) {
			return Redirect::to('criteria')->with('error', 'Just 4 criteria allowed!');
		}

		$this->layout->content = View::make('criteria.create')->with('fields', $this->fields);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /criterias
	 *
	 * @return Response
	 */
	public function store()
	{
		// Check max criteria = 4
		$max = count(Criterion::all());
		if ($max==4) {
			return Redirect::to('criteria')->with('error', 'Just 4 criteria allowed!');
		}
		$validator = Validator::make(Input::all(), Criterion::$rules);
        if ($validator->passes()) {
            $criterion = new Criterion;
            $criterion->criterion = Input::get('criterion');
            $criterion->description = Input::get('description');
            $criterion->field = Input::get('field');
            $criterion->save();

            // Change campaigns status
            Keywordplanner::outofdateCampaigns();

            return Redirect::to('criteria')
                            ->with('success', 'Criterion successfully added!');
        } else {
            return Redirect::to('criteria/create')
            				->with('fields', $this->fields)
                            ->with('error', 'The following errors occurred')
                            ->withErrors($validator)
                            ->withInput();
        }
	}

	/**
	 * Display the specified resource.
	 * GET /criterias/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$criterion = Criterion::find($id);
        $subcriteria = Subcriterion::where('criterion_id', '=', $id)->get();
        $this->layout->content = View::make('criteria.show')->with(array(
            'criterion_id' => $id,
            'criterion' => $criterion,
            'subcriteria' => $subcriteria
            )
        );
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /criterias/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$criterion = Criterion::find($id);
        if ($criterion) {
            $this->layout->content = View::make('criteria.edit')->with('criterion', $criterion)->with('fields', $this->fields);
        } else {
            return Redirect::to('criteria');
        }
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /criterias/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = Criterion::$rules;
        $rules['criterion'] .= ',' . $id . ',criterion_id';
        $rules['field'] .= ',' . $id . ',criterion_id';
		$validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $criterion = Criterion::find($id);
            $criterion->criterion = Input::get('criterion');
            $criterion->description = Input::get('description');
            $criterion->field = Input::get('field');
            $criterion->save();

            // Change campaigns status
            Keywordplanner::outofdateCampaigns();

            return Redirect::to('criteria')->with('success', 'Criterion successfully edited!');
        } else {
            return Redirect::to('criteria/' . $id . '/edit')
            				->with('fields', $this->fields)
                            ->with('error', 'The following errors occurred')
                            ->withErrors($validator)
                            ->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /criterias/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$criteria = Criterion::with('comparecriteria')->get();
		
		// Delete criteria judgments
		foreach ($criteria as $key => $value) {
			$criterion = Criterion::find($value['criterion_id']);
			$criterion->comparecriteria()->detach($value['compared_criterion_id'], array('judgment' => $value['judgment']));
		}
		// Delete criteria
		$criterion = Criterion::find($id);
        $criterion->delete();
        
        // Reset TPV
        foreach ($criteria as $criterion) {
        	$criterion->tpv = 0;
        	$criterion->save();
        }

        // Clear subcriteria weight
        Ahp::clearSubcriteriaWeight();

        // Change campaigns status
        Keywordplanner::outofdateCampaigns();

        return Redirect::to('criteria')
                        ->with('success', 'Criterion successfully deleted!');
	}

}