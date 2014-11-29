<?php

class CampaignsController extends BaseController {

	public function getIndex()
	{
		$campaigns = Campaign::where('user_id', Auth::user()->user_id)->get();
		$this->layout->content = View::make('campaigns.index')->with('campaigns', $campaigns);
	}

	public function deleteDestroy($id) {
        $campaign = Campaign::find($id);
        File::delete(public_path() . '/uploads/'. $campaign->csv);
        $campaign->delete();
        return Redirect::to('campaign')->with('success', 'Campaign successfully deleted!');
    }

    public function getShow($id = null) {
        if (empty($id)) {
            return Redirect::to('campaign');
        }

        if (Ahp::allConsistency()) {
            $campaign = Campaign::find($id);
            $criteria = Criterion::all();

            // Check the campaign's status
            if ($campaign->status=='out of date') {
                $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->get();
                // Calculate alternative's criteria weight
                foreach ($keywords as $key => $keyword) {
                    foreach ($criteria as $criterion) {
                        $weights[$keyword->keyword_id][$criterion->field] = Ahp::subcriteriaWeight($criterion->criterion_id, $keyword);
                    }
                    // Update score when old alternative's score not match because of updated judgments
                    $score = array_sum($weights[$keyword->keyword_id]);
                    if ($score != $keyword->score) {
                        $updatedKeyword = Keyword::find($keyword->keyword_id);
                        $updatedKeyword->score = $score;
                        $updatedKeyword->save();
                    }
                }
                $campaign->status = 'up to date';
                $campaign->save();
                $keywords = null;
            }

            // Keyword Filter
            $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC');
            if (Session::has('filter.type')) {
                foreach (Session::get('filter.type') as $name => $id) {
                    $subcriterion = Subcriterion::find($id);
                    $field = $name;
                    $range = explode('-', $subcriterion->range);
                    $sign = substr($subcriterion->range, 0, 1);

                    if (count($range)==2) {
                        foreach ($range as $key => $data) {
                            $conditional = ($key==0) ? '>' : '<';
                            $value = $range[$key];
                            $keywords->where($field, $conditional, $value);
                        }
                    }
                    if ($sign == '<') {
                        $conditional = '<';
                        $value = substr($subcriterion->range, 1);
                        $keywords->where($field, $conditional, $value);
                    }
                    if ($sign == '>') {
                        $conditional = '>';
                        $value = substr($subcriterion->range, 1);
                        $keywords->where($field, $conditional, $value);
                    }
                    if (count($range)!=2 && $sign != '<' && $sign != '>') {
                        $conditional = '=';
                        $value = $subcriterion->range;
                        $keywords->where($field, $conditional, $value);
                    }
                }
            }
            if (Session::has('filter.range')) {
                // return 'has';
                foreach (Session::get('filter.range') as $name => $rangeValue) {
                    $field = $name;
                    $range = explode('-', $rangeValue);
                    $sign = substr($rangeValue, 0, 1);
                    if (count($range)==2) {
                        foreach ($range as $key => $data) {
                            $conditional = ($key==0) ? '>' : '<';
                            $value = $range[$key];
                            $keywords->where($field, $conditional, $value);
                        }
                    }
                    if ($sign == '<') {
                        $conditional = '<';
                        $value = substr($rangeValue, 1);
                        $keywords->where($field, $conditional, $value);
                    }
                    if ($sign == '>') {
                        $conditional = '>';
                        $value = substr($rangeValue, 1);
                        $keywords->where($field, $conditional, $value);
                    }
                    if (count($range)!=2 && $sign != '<' && $sign != '>') {
                        $conditional = '=';
                        $value = $rangeValue;
                        $keywords->where($field, $conditional, $value);
                    }
                }
            }
            

            // $keywords->paginate(10);

            // $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->paginate(10);
            // $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC');
            // $keywords->where('word','=', '2');
            $keywords = $keywords->paginate(10);
            // return $keywords;
            if ($keywords->count()==0) {
                $this->layout->content = View::make('campaigns.show')->with('keywords', $keywords);
            } else {
                // Get CSV file name
                $csv = $campaign->csv;
                $fileName = explode('.', $csv);
            // $tmp = array();
            // Calculate alternative's criteria weight
                foreach ($keywords as $key => $keyword) {
                // return $keyword;
                    foreach ($criteria as $criterion) {
                        $classification = Ahp::keywordSubcriteriaWeight($criterion->criterion_id, $keyword);
                        $class = $classification['class'];
                        $value = $classification['value'];
                        $weights[$keyword->keyword_id][$criterion->field] = $classification['weight'];
                        $classes[$keyword->keyword_id][$criterion->field] = $class;
                        $values[$keyword->keyword_id][$criterion->field] = $value;
                    }
                }

            // $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->paginate(10);
                // $recommendedKeywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->take(10)->get();
                // foreach ($recommendedKeywords as $key => $recommendedKeyword) {
                //     $tmp[$key] = $recommendedKeyword['keyword'];
                // }
                foreach ($keywords as $key => $value) {
                    $recommendedKeywords[$key] = $value->keyword;
                }
                // return $recommendedKeywords;
                // $recommendedKeywords = null;
                // $recommendedKeywords = $tmp;
                Keywordplanner::exportTxt($recommendedKeywords, $csv);

                $this->layout->content = View::make('campaigns.show')
                ->with('keywords', $keywords)
                ->with('criteria', $criteria)
                ->with('recommendedKeywords' ,$recommendedKeywords)
                ->with('weights', $weights)
                ->with('classes', $classes)
                ->with('values', $values)
                ->with('fileName', $fileName[0]);
            }
        } else {
            $this->layout->content = View::make('campaigns.show');
        }
    }

    // public function getShow($id = null) {
    //     if (empty($id)) {
    //         return Redirect::to('campaign');
    //     }

    //     $campaign = Campaign::find($id);
    //     $criteria = Criterion::all();

    //     // Check the campaign's status
    //     if ($campaign->status=='out of date') {
    //         $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->get();
    //         // Calculate alternative's criteria weight
    //         foreach ($keywords as $key => $keyword) {
    //         // return $keyword;
    //             foreach ($criteria as $criterion) {
    //                 $weights[$keyword->keyword_id][$criterion->field] = Ahp::subcriteriaWeight($criterion->criterion_id, $keyword);
    //             }
    //             // Update score when old alternative's score not match because of updated judgments
    //             $score = array_sum($weights[$keyword->keyword_id]);
    //             if ($score != $keyword->score) {
    //                 $updatedKeyword = Keyword::find($keyword->keyword_id);
    //                 $updatedKeyword->score = $score;
    //                 $updatedKeyword->save();
    //             }
    //         }
    //         $campaign->status = 'up to date';
    //         $keywords = null;
    //     }

    //     // $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->get();
    //     $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->paginate(10);

    //     // Get CSV file name
    //     $csv = $campaign->csv;
    //     $fileName = explode('.', $csv);

    //     // Calculate alternative's criteria weight
    //     foreach ($keywords as $key => $keyword) {
    //         // return $keyword;
    //         foreach ($criteria as $criterion) {
    //             $classification = Ahp::keywordSubcriteriaWeight($criterion->criterion_id, $keyword);
    //             $class = $classification['class'];
    //             $value = $classification['value'];
    //             $weights[$keyword->keyword_id][$criterion->field] = $classification['weight'];
    //             $classes[$keyword->keyword_id][$criterion->field] = $class;
    //             $values[$keyword->keyword_id][$criterion->field] = $value;
    //             // $weights[$keyword->keyword_id][$criterion->field] = Ahp::subcriteriaWeight($criterion->criterion_id, $keyword);
    //         }
    //         // Update score when old alternative's score not match because of updated judgments
    //         // $score = array_sum($weights[$keyword->keyword_id]);
    //         // if ($score != $keyword->score) {
    //         //     $updatedKeyword = Keyword::find($keyword->keyword_id);
    //         //     $updatedKeyword->score = $score;
    //         //     $updatedKeyword->save();
    //         // }
    //     }
        
    //     // $keywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->paginate(10);
    //     $recommendedKeywords = Keyword::where('campaign_id', $id)->orderBy('score', 'DESC')->orderBy('keyword', 'ASC')->take(10)->get();
    //     // $tmp = array();
    //     foreach ($recommendedKeywords as $key => $recommendedKeyword) {
    //         $tmp[$key] = $recommendedKeyword['keyword'];
    //     }
    //     $recommendedKeywords = null;
    //     $recommendedKeywords = $tmp;
    //     Keywordplanner::exportTxt($recommendedKeywords, $csv);

    //     $this->layout->content = View::make('campaigns.show')
    //         ->with('keywords', $keywords)
    //         ->with('criteria', $criteria)
    //         ->with('recommendedKeywords' ,$recommendedKeywords)
    //         ->with('weights', $weights)
    //         ->with('classes', $classes)
    //         ->with('values', $values)
    //         ->with('fileName', $fileName[0]);
    // }

}
