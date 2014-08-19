<?php

class KeywordsController extends \BaseController {

    function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                asort($sortable_array);
                break;
                case SORT_DESC:
                arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

	public function getIndex()
	{
        // Check user permision
        if(Auth::check()) {
            // Registered user will use campaign
            return Redirect::to('campaign');
        } else {
            // Guest user will import and get the keyword result
            return Redirect::to('keyword/import');
        }
		/*
        $keywords = Keyword::paginate(10);
        $this->layout->content = View::make('keywords.index')->with('keywords', $keywords);
        */
	}

    public function getShow($id) {
        $keywords = Keyword::where('campaign_id', $id)->get();
        $criteria = Criterion::all();
        $this->layout->content = View::make('keywords.show')->with('keywords', $keywords)->with('criteria', $criteria);
    }

    public function getResult() {
        $criteria = Criterion::all();
        $consistency = Ahp::allConsistency();
        if (Auth::check()) {
            $keywords = Keyword::paginate(10);
            $this->layout->content = View::make('keywords.result')->with('keywords', $keywords)->with('criteria', $criteria)->with('consistency', $consistency);
        } else {
            if (!Session::has('keywords')) {
                return Redirect::to('keyword/import');
            }
            $keywords = Session::get('keywords');
            $this->layout->content = View::make('keywords.tmp')->with('keywords', $keywords)->with('criteria', $criteria)->with('consistency', $consistency);
        }
    }

	public function getImport()
	{
        // SEMENTARA DINONAKTIFKAN
        // $consistency = true;
        // $criteriaConsistency = Ahp::consistency();
        // foreach (Criterion::all() as $key => $criterion) {
        //     $subcriteriaConsistency = Ahp::consistency($criterion->criterion_id);
        //     if ($subcriteriaConsistency==false || $criteriaConsistency==false) {
        //         $consistency = false;              
        //     }
        // }

        // $consistency = Ahp::criteriaConsistency(); 

        // Check the consistency
        $consistency = Ahp::allConsistency();
		$this->layout->content = View::make('keywords.create')->with('consistency', $consistency);
	}

	public function postStore() {
        // SEMENTARA DINONAKTIFKAN
        // $criteriaConsistency = Ahp::consistency();
        // foreach (Criterion::all() as $key => $criterion) {
        //     $subcriteriaConsistency = Ahp::consistency($criterion->criterion_id);
        //     if ($subcriteriaConsistency==false || $criteriaConsistency==false) {
        //         return Redirect::to('keyword/import');
        //     }
        // }

        // Check the consistency
        $consistency = Ahp::allConsistency();
        if (!consistency) {
            return Redirect::to('keyword/import');
        }

        // Upload CSV and convert CSV into array
        $filename = Keywordplanner::uploadCsv();

        // Convert CSV record into array
        $keywords = Keywordplanner::convertCSV($filename);

        // Check the user auth
        if(!Auth::check()) { 
            return Redirect::to('keyword/result')->with('keywords', $keywords);
        }

        // Find Seed Keywords for Campaign's name
        $campaignName = Keywordplanner::getCampaignName($keywords);

        // Delete existing campaign 
        Keywordplanner::deleteCampaign($campaignName);

        // Add a campaign
        Keywordplanner::addCampaign($campaignName);

        // Get campaign to get campaign_id
        $campaign = Campaign::where('csv', $filename);

        foreach ($arr as $key => $value) {
            $validator = Validator::make($value, Keyword::$rules);
            if ($validator->passes()) {
                $keyword = new Keyword;
                // $keyword->group = $value['group'];
                $keyword->keyword = $value['keyword'];
                // $keyword->currency = $value['currency'];
                $keyword->search = $value['search'];
                $keyword->competition = $value['competition'];
                $keyword->bid = $value['bid'];
                $keyword->score = $value['score'];
                // $keyword->impression = $value['impression'];
                // $keyword->account = $value['account'];
                // $keyword->plan = $value['plan'];
                // $keyword->extract = $value['extract'];
                // $keyword->word = str_word_count($value['keyword']);
                // $keyword->csv = $filename;
                $keyword->word = $value['word'];
                $keyword->campaign_id = $campaign->campaign_id;
                $keyword->save();
            }
        }
        return Redirect::to('keyword')->with('success', 'Keywords successfully imported!');
    }

    public function deleteDestroy($id) {
        $keyword = Keyword::find($id);
        $keyword->delete();
        return Redirect::to('keyword')->with('success', 'Keyword successfully deleted!');
    }

}