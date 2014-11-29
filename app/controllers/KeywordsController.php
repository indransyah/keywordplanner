<?php

class KeywordsController extends \BaseController {

    public function __construct()
    {
        // $this->beforeFilter('auth', array('except' => array('getIndex', 'deleteDestroy', 'getImport', 'postStore', 'getShow')));
    }

    public function getFilter() {
        $criteria = Criterion::all();
        $options = array();
        foreach ($criteria as $criterion) {
            $options[$criterion->criterion] = array('' => '-- Ignore --') + Subcriterion::where('criterion_id', $criterion->criterion_id)->lists('subcriterion', 'subcriterion_id') + array('range' => '-- Input your range --');
        }
        $this->layout->content = View::make('keywords.filter')->with('criteria', $criteria)->with('options', $options);
    }

    public function postFilter() {
        Session::forget('filter');
        $criteria = Criterion::all();
        $filter = array();
        foreach ($criteria as $criterion) {
            $input = Input::get($criterion->field.'-select');
            if ($input == 'range') {
                $range = Input::get($criterion->field.'-range');
                if (empty($range)) {
                    return Redirect::to('keyword/filter')->with('error', 'Range cannot be empty');
                }
                // $filter[strtolower($criterion->criterion)] = $range;
                Session::put('filter.range.'.$criterion->field, $range);
            } elseif (!empty($input)) {
                $subcriterion = Subcriterion::find($input);
                // $filter[strtolower($criterion->criterion)] = $subcriterion->range;
                Session::put('filter.type.'.$criterion->field, $subcriterion->subcriterion_id);
            }
        }
        if (Auth::check()) {
            return Redirect::to('campaign')->with('success', 'Keyword filter saved');
        } else {
            return Redirect::to('keyword/result')->with('success', 'Keyword filter saved');
        }
        // return Session::all();
        
        // return Redirect::to('keyword/result');
        // return Session::all();
        // // return Session::forget('filter');
        // $url = null;
        // foreach ($filter as $key => $value) {
        //     echo $value.'<br />';
        //     $url .= $key.'='.$value.'&';
        // }
        // return $url;
        // return Redirect::to('campaign/show/1/'.$url);
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
	}

    public function getResult() {

        // Check uploaded csv before
        if (!Session::has('csv')) {
            return Redirect::to('keyword/import');
        }

        // Get csv file before
        $csv = Session::get('csv');

        // Convert csv to array
        $keywords = Keywordplanner::convertCsv($csv);

        // Count keyword's weight
        $keywords = Ahp::keywordScore($keywords);
        // return $keywords;
// return $keywords;

        // Get Filter
        $newKeywords = array();
        // return $keywords;
        // foreach ($keywords as $keywordKey => $keyword) {
        if (Session::has('filter')) {
            $filter = Session::get('filter');
            foreach ($filter as $key => $data) {
                if ($key=='type') {
                    foreach ($data as $name => $id) {
                        $subcriterion = Subcriterion::find($id);
                        $newFilters[$name] = $subcriterion->range;
                    //     foreach ($keywords as $keywordKey => $keyword) {
                    //         $subcriterion = Subcriterion::find($id);
                    //         $range = explode('-', $subcriterion->range);
                    //         $sign = substr($subcriterion->range, 0, 1);
                    //         $value = substr($subcriterion->range, 1);
                    //         if (count($range)==2) {
                    //             if (Ahp::range($keyword[$name], $range[0], $range[1])) {
                    //                 $newKeywords[$keywordKey] = $keyword;
                    //             }
                    //         }
                    //         if ($sign == '<' && $keyword[$name] < $value) {
                    //             $newKeywords[$keywordKey] = $keyword;
                    //         }
                    //         if ($sign == '>' && $keyword[$name] > $value) {
                    //             $newKeywords[$keywordKey] = $keyword;
                    //         }
                    //         if ($keyword[$name]==$subcriterion->range) {
                    //             $newKeywords[$keywordKey] = $keyword;
                    //         }
                    //     }
                    //     $keywords = null;
                    //     $keywords = $newKeywords;
                    }
                }
                if ($key=='range') {
                    foreach ($data as $name => $rangeValue) {
                        $newFilters[$name] = $rangeValue;
                    //     foreach ($keywords as $keywordKey => $keyword) {
                    //         $range = explode('-', $rangeValue);
                    //         $sign = substr($rangeValue, 0, 1);
                    //         $value = substr($rangeValue, 1);
                    //         if (count($range)==2) {
                    //             if (Ahp::range($keyword[$name], $range[0], $range[1])) {
                    //                 $newKeywords[$keywordKey] = $keyword;
                    //             }
                    //         }
                    //         if ($sign == '<' && $keyword[$name] < $value) {
                    //             $newKeywords[$keywordKey] = $keyword;
                    //         }
                    //         if ($sign == '>' && $keyword[$name] > $value) {
                    //             $newKeywords[$keywordKey] = $keyword;

                    //         }
                    //         if ($keyword[$name]==$rangeValue) {
                    //             $newKeywords[$keywordKey] = $keyword;
                    //         }
                    //     }
                    //     $keywords = null;
                    //     $keywords = $newKeywords;
                    }
                }
            }
        }
        
        if (Session::has('filter')) {
            foreach ($newFilters as $name => $filterValue) {
            // return $name;
                foreach ($keywords as $keywordKey => $keyword) {
                    $range = explode('-', $filterValue);
                    $sign = substr($filterValue, 0, 1);
                    $value = substr($filterValue, 1);
                    if (count($range)==2) {
                        if (Ahp::range($keyword[$name], $range[0], $range[1])) {
                            $newKeywords[$keywordKey] = $keyword;
                        }
                    }
                    if ($sign == '<' && $keyword[$name] < $value) {
                    // echo "kurang";
                        $newKeywords[$keywordKey] = $keyword;
                    }
                    if ($sign == '>' && $keyword[$name] > $value) {
                    // echo "lebih";

                        $newKeywords[$keywordKey] = $keyword;
                    }
                    if ($keyword[$name]==$filterValue) {
                    // echo "sama";

                        $newKeywords[$keywordKey] = $keyword;
                    }
                }
            // echo "<br />";
            // return $newKeywords;
                $keywords = null;
                $keywords = $newKeywords;
                $newKeywords = null;
            // return $keywords;
            }
        }
        // return $keywords;
        // return $newFilters;
        // $keywords = null;
        $name = null;
        // $keywords = $newKeywords;
        if (count($keywords)==0) {
             $this->layout->content = View::make('keywords.result')->with('keywords', $keywords);
        } else {
            // Sort the array
            $criteria = Criterion::all();
            foreach ($keywords as $key => $value) {
                $score[$key] = $value['score'];
                $name[$key] = $value['keyword'];
            }
            $keyword = array_multisort($score, SORT_DESC, $name, SORT_ASC, $keywords);
            $tmp = null;

        // Get recommended keywords
            $total = count($keywords);
            $max = 10;
            if ($total>=$max) {
                for ($i=0; $i < $max; $i++) {
                    $tmp[$i] = $keywords[$i];
                    $recommendedKeywords[$i] = (string) $keywords[$i]['keyword'];
                }
            } else {
                for ($i=0; $i < $total; $i++) {
                    $tmp[$i] = $keywords[$i];
                    $recommendedKeywords[$i] = (string) $keywords[$i]['keyword'];
                }
            }

        // Export the keyword to txt file
            Keywordplanner::exportTxt($recommendedKeywords, $csv);

        // Get subcriteria's weight of the keyword
            $keywords = null;
            $keywords = $tmp;
            foreach ($keywords as $key => $keyword) {
                foreach ($criteria as $criterion) {
                    $classification = Ahp::keywordSubcriteriaWeight($criterion->criterion_id, $keyword);
                    $weight = $classification['weight'];
                    $class = $classification['class'];
                    $value = $classification['value'];
                    $key = $keyword['keyword'];
                    $weights[$key][$criterion->field] = $weight;
                    $classes[$key][$criterion->field] = $class;
                    $values[$key][$criterion->field] = $value;
                }

            }

        // Get the txt file's name
            $fileName = explode('.', $csv);
            $this->layout->content = View::make('keywords.result')
            ->with('keywords', $keywords)
            ->with('criteria', $criteria)
            ->with('recommendedKeywords' ,$recommendedKeywords)
            ->with('weights', $weights)
            ->with('classes', $classes)
            ->with('values', $values)
            ->with('fileName', $fileName[0]);
        }
        // return $newKeywords;
        
        // foreach ($keywords as $key => $keyword) {
        //     // return Session::get('filter');
        //     if (Session::has('filter')) {
        //         $status = Keywordplanner::filter($keyword);
        //         if (!$status) {
        //             # code...
        //         }
        //     }

        //     // $filter = Session::get('filter');
        //     // foreach ($filter as $name => $value) {
        //     //     echo $name.'-'.$value;
        //     //     $status = Keywordplanner::filter();
        //     //     if (!$status) {
        //     //         # code...
        //     //     }
        //     // }
        //     return $keywords;
        // }

        
    }

    // public function getResult() {
    //     if (!Session::has('csv')) {
    //         return Redirect::to('keyword/import');
    //     }
    //     $csv = Session::get('csv');
    //     $keywords = Keywordplanner::convertCsv($csv);
    //     $keywords = Ahp::keywordScore($keywords);
    //     $criteria = Criterion::all();
    //     // CSV::with($keywords)->put(public_path().'/uploads/guest/result-'.$csv);
        
    //     foreach ($keywords as $key => $value) {
    //         $tmp[$key] = $value['score'];
    //     }
    //     $keyword = array_multisort($tmp, SORT_DESC, $keywords);
    //     // foreach ($keywords as $key => $value) {
    //     //     echo $value['keyword'].'<br>';
    //     // }
    //     // return 'ok';
    //     $tmp = null;
    //     $total = count($keywords);
    //     $max = 10;
    //     if ($total>=$max) {
    //         for ($i=0; $i < $max; $i++) {
    //             $tmp[$i] = $keywords[$i];
    //             $recommendedKeywords[$i] = (string) $keywords[$i]['keyword'];
    //         }
    //     } else {
    //         for ($i=0; $i < $total; $i++) {
    //             $tmp[$i] = $keywords[$i];
    //             $recommendedKeywords[$i] = (string) $keywords[$i]['keyword'];
    //         }
    //     }

    //     // Export
    //     // Keywordplanner::exportCsv($recommendedKeywords, $csv);
    //     Keywordplanner::exportTxt($recommendedKeywords, $csv);
    //     // return $recommendedKeywords;

    //     $keywords = null;
    //     $keywords = $tmp;
    //     // foreach ($keywords as $key => $keyword) {
    //     //     foreach ($criteria as $criterion) {
    //     //         $weights[$key][$criterion->criterion] = Ahp::subcriteriaWeight($criterion->criterion_id, $keyword);
    //     //     }
    //     // }

    //     foreach ($keywords as $key => $keyword) {
    //         // return $keyword;
    //         foreach ($criteria as $criterion) {
    //             $classification = Ahp::keywordSubcriteriaWeight($criterion->criterion_id, $keyword);
    //             // return $classification;
    //             $weight = $classification['weight'];
    //             $class = $classification['class'];
    //             $value = $classification['value'];
    //             $key = $keyword['keyword'];
    //             $weights[$key][$criterion->field] = $weight;
    //             // return $keyword['keyword'];
    //             $classes[$key][$criterion->field] = $class;
    //             $values[$key][$criterion->field] = $value;
    //             // $weights[$keyword->keyword_id][$criterion->field] = Ahp::subcriteriaWeight($criterion->criterion_id, $keyword);
    //         }
            
    //     }
    //     // return $classes;

    //     // return $recommendedKeywords;
    //     $fileName = explode('.', $csv);
    //     $this->layout->content = View::make('keywords.result')
    //         ->with('keywords', $keywords)
    //         ->with('criteria', $criteria)
    //         ->with('recommendedKeywords' ,$recommendedKeywords)
    //         ->with('weights', $weights)
    //         ->with('classes', $classes)
    //         ->with('values', $values)
    //         ->with('fileName', $fileName[0]);
    // }

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
        // $filename = Keywordplanner::uploadCsv();

        // Redirect if no csv file selected
        if (!Input::hasFile('csv')) {
            return Redirect::to('keyword/import')->with('error', 'Ups! There is no csv file selected!');
        }


        $file = Input::file('csv');
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        // Check the file extension
        if ($extension != 'csv') {
            return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed. Please select a csv file!');
        }

        // Upload the file
        $upload = Keywordplanner::uploadCsv($file);
        if (!$upload) {
            return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed!');
        }

        // if (Input::hasFile('csv')) {
        //     $file = Input::file('csv');
        //     $dir = (Auth::check()) ? '/uploads' : '/uploads/guest';
        //     $destinationPath = public_path() . $dir;
        //     $filename = $file->getClientOriginalName();
        //     $extension = $file->getClientOriginalExtension();
        //     if ($extension == 'csv') {
        //         $upload = $file->move($destinationPath, $filename);
        //         // return $upload;
        //         if ($upload) {
        //             $filename = $file->getClientOriginalName();
        //         } else {
        //             return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed!');
        //         }
        //     } else {
        //         return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed. Please select a csv file!');
        //         // return Redirect::to('keyword/import')->with('error', 'Import a csv file from <a href="http://adwords.google.com" class="alert-link">Google AdWords Keyword Planner!</a>!');
        //     }
        // } else {
        //     return Redirect::to('keyword/import')->with('error', 'Ups! There is no csv file selected!');
        // }
        //

        // Check the user auth
        // if(!Auth::check()) {
        //     Session::put('csv', $filename);
        //     return Redirect::to('keyword/result');
        //     // return Redirect::to('keyword/result')->with('keywords', $keywords);
        // }

        if (Keywordplanner::checkCsv($filename)) {
            if(Auth::check()) {
                // Convert CSV record into array
                $keywords = Keywordplanner::convertCsv($filename);
            } else {

                // Redirect to keyword filter
                Session::put('csv', $filename);
                return Redirect::to('keyword/filter');

                // Redirect to keyword results
                Session::put('csv', $filename);
                return Redirect::to('keyword/result');
            }
        } else {
            return Redirect::to('keyword/import')->with('error', 'Ups! Not valid CSV file!');
        }

        // Keyword score
        $keywords = Ahp::keywordScore($keywords);
        // return $keywords;




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
        return Redirect::to('campaign/show/'.$campaign->campaign_id)->with('success', 'Keywords successfully imported!');
    }

    public function deleteDestroy($id) {
        $keyword = Keyword::find($id);
        $keyword->delete();
        return Redirect::to('keyword')->with('success', 'Keyword successfully deleted!');
    }

}
