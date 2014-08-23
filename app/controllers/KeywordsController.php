<?php

class KeywordsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth', array('except' => 'deleteDestroy'));
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
        $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->paginate(20);
        $criteria = Criterion::all();
        $this->layout->content = View::make('keywords.result')->with('keywords', $keywords)->with('criteria', $criteria);
    }

    public function getResult() {
        $criteria = Criterion::all();
        if (Auth::check()) {
            $keywords = Keyword::paginate(10);
            $this->layout->content = View::make('keywords.result')->with('keywords', $keywords)->with('criteria', $criteria);
        } else {
            if (!Session::has('keywords')) {
                return Redirect::to('keyword/import');
            }
            $keywords = Session::get('keywords');
            $this->layout->content = View::make('keywords.tmp')->with('keywords', $keywords)->with('criteria', $criteria);
        }
    }

	public function getImport()
	{
		$this->layout->content = View::make('keywords.create');
	}

	public function postStore() {
        
        // Check the consistency
        $consistency = Ahp::allConsistency();
        if (!$consistency) {
            return Redirect::to('keyword/import');
        }

        // Upload CSV and convert CSV into array
        $filename = Keywordplanner::uploadCsv();

        // Convert CSV record into array
        $keywords = Keywordplanner::convertCSV($filename);

        // Keyword score
        $keywords = Ahp::keywordScore($keywords);
        // return $keywords;


        // Check the user auth
        if(!Auth::check()) { 
            return Redirect::to('keyword/result')->with('keywords', $keywords);
        }

        // Find Seed Keywords for Campaign's name
        $campaignName = Keywordplanner::getCampaignName($keywords);

        // Delete existing campaign 
        // Keywordplanner::deleteCampaign($campaignName);

        // Add a campaign
        // Keywordplanner::addCampaign($campaignName, $filename);

        // Update campaign
        Keywordplanner::updateCampaign($campaignName, $filename);

        // Get campaign to get campaign_id
        $campaign = Campaign::where('csv', $filename)->first();
        // return $campaign->campaign_id;

        foreach ($keywords as $key => $value) {
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
                $keyword->score = $value['score'];
                $keyword->campaign_id = $campaign->campaign_id;
                $keyword->save();
            }
        }
        return Redirect::to('keyword/show/'.$campaign->campaign_id)->with('success', 'Keywords successfully imported!');
    }

    public function deleteDestroy($id) {
        $keyword = Keyword::find($id);
        $keyword->delete();
        return Redirect::to('keyword')->with('success', 'Keyword successfully deleted!');
    }

}