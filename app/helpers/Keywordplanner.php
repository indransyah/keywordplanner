<?php

class Keywordplanner {

	// public static function exportCsv($recommendedKeywords, $csv) {
	// 	$dir = (Auth::check()) ? '/uploads/' : '/uploads/guest/';
	// 	$file = fopen(public_path().$dir.'result-'.$csv,'w');
	// 	foreach ($recommendedKeywords as $recommendedKeyword) {
	//   	fputcsv($file, explode(',', $recommendedKeyword));
	//   }
	// 	fclose($file);
	// }

	public static function filter($keyword) {
		if (Session::has('filter.type')) {
			$type = Session::get('filter.type');
			foreach ($type as $key => $value) {
				$subcriteria = Subcriterion::find($value);
				$input = $subcriteria->range;
			}
		}

		if (Session::has('filter.range')) {
			$range = Session::get('filter.range');
			foreach ($range as $key => $value) {
				$input = $value;
			}
		}

	}

	public static function keywordRange() {

	}

	public static function exportTxt($recommendedKeywords, $csv) {
		$dir = (Auth::check()) ? '/uploads/' : '/uploads/guest/';
		$name = explode('.', $csv);
		$file = fopen(public_path().$dir.'result-'.$name[0].'.txt','w');
		foreach ($recommendedKeywords as $recommendedKeyword) {
			// $recommendedKeyword .= "\n";
			fwrite($file, $recommendedKeyword."\r\n");
		}
		fclose($file);
	}

	public static function checkCsv($filename){
		$dir = (Auth::check()) ? '/uploads/' : '/uploads/guest/';
		$from = fopen(public_path() . $dir . $filename, 'r+');
		$fields = array('Ad group', 'Keyword', 'Currency', 'Avg. Monthly Searches (exact match only)', 'Competition', 'Suggested bid', 'Impr. share', 'In account', 'In plan', 'Extracted From');
		while (($data = fgetcsv($from, 1000, "\t", '"')) !== false) {
			foreach ($data as $key => $value) {
				$data[$key] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);
			}
			$check = array_diff($data, $fields);
			if (!empty($check)) {
				fclose($from);
				return false;
			} else {
				fclose($from);
				return true;
			}
		}
	}

	public static function convertCsv($filename) {
		$dir = (Auth::check()) ? '/uploads/' : '/uploads/guest/';
		$from = fopen(public_path() . $dir . $filename, 'r+');
		// $from = fopen(public_path() . '/uploads/' . $filename, 'r+');
		$arr = array();
		$pass = true;
		$header = array('group', 'keyword', 'currency', 'search', 'competition', 'bid', 'impression', 'account', 'plan', 'extract');
		while (($data = fgetcsv($from, 1000, "\t", '"')) !== false) {
			if ($pass == false) {
				if (count($header) == count($data)) {
					foreach ($data as $key => $value) {
						$data[$key] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $value);
					}
					$arr[] = array_combine($header, $data);
				}
			} else {
				$fields = array('Ad group', 'Keyword', 'Currency', 'Avg. Monthly Searches (exact match only)', 'Competition', 'Suggested bid', 'Impr. share', 'In account', 'In plan', 'Extracted From');
				foreach ($data as $key => $value) {
					$data[$key] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);
				}
				$pass = false;
			}
		}
		fclose($from);
		foreach ($arr as $index => $value) {
			$arr[$index]['search'] = (int) $value['search'];
			$arr[$index]['competition'] = (float) $value['competition'];
			$arr[$index]['bid'] = (float) $value['bid'];
			$arr[$index]['impression'] = (float) $value['impression'];
			foreach ($value as $field => $item) {
				if (empty($item)) {
					$arr[$index][$field] = 0;
				}
			}
			$arr[$index]['word'] = str_word_count($value['keyword']);
			// $arr[$index]['score'] = Ahp::keywordscore($value);
		}
		return $arr;
	}

	// public static function convertCSV($filename) {
	// 	$dir = (Auth::check()) ? '/uploads/' : '/uploads/guest/';
	// 	$from = fopen(public_path() . $dir . $filename, 'r+');
	// 	// $from = fopen(public_path() . '/uploads/' . $filename, 'r+');
	// 	$arr = array();
	// 	$pass = true;
	// 	$header = array('group', 'keyword', 'currency', 'search', 'competition', 'bid', 'impression', 'account', 'plan', 'extract');
	// 	while (($data = fgetcsv($from, 1000, "\t", '"')) !== false) {
	// 		if ($pass == false) {
	// 			if (count($header) == count($data)) {
	// 				foreach ($data as $key => $value) {
	// 					$data[$key] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $value);
	// 				}
	// 				$arr[] = array_combine($header, $data);
	// 			}
	// 		} else {
	// 			$fields = array('Ad group', 'Keyword', 'Currency', 'Avg. Monthly Searches (exact match only)', 'Competition', 'Suggested bid', 'Impr. share', 'In account', 'In plan', 'Extracted From');
	// 			foreach ($data as $key => $value) {
	// 				$data[$key] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);
	// 			}
	// 			$check = array_diff($data, $fields);
	// 			// return $check;
	// 			if (!empty($check)) {
	// 				fclose($from);
	// 				return Redirect::to('keyword/import')->with('error', 'Ups! Not valid CSV file!');
	// 			} else {
	// 				$pass = false;
	// 			}
	// 		}
	// 	}
	// 	fclose($from);
	// 	foreach ($arr as $index => $value) {
	// 		$arr[$index]['search'] = (int) $value['search'];
	// 		$arr[$index]['competition'] = (float) $value['competition'];
	// 		$arr[$index]['bid'] = (float) $value['bid'];
	// 		$arr[$index]['impression'] = (float) $value['impression'];
	// 		foreach ($value as $field => $item) {
	// 			if (empty($item)) {
	// 				$arr[$index][$field] = 0;
	// 			}
	// 		}
	// 		$arr[$index]['word'] = str_word_count($value['keyword']);
	// 		// $arr[$index]['score'] = Ahp::keywordscore($value);
	// 	}
	// 	return $arr;
	// }

	public static function getCampaignName($keywords) {
		foreach ($keywords as $key => $keyword) {
			if ($keyword['group']=='Seed Keywords') {
				$campaignName = $keyword['keyword'];
				return $campaignName;
			}
		}
		return 'No Seed Keyword';
	}

	public static function outofdateCampaigns() {
		$campaigns = Campaign::where('user_id', Auth::user()->user_id)->get();
        foreach ($campaigns as $campaign) {
        	$campaign->status = 'out of date';
        	$campaign->save();
        }
	}

	public static function updateCampaign($campaignName, $filename) {
		$campaign = Campaign::where('csv', $filename)->first();
		if (count($campaign) == 0) {
			$campaign = new Campaign;
	        $campaign->campaign = $campaignName;
	        $campaign->csv = $filename;
	        $campaign->status = 'up to date';
	        $campaign->user_id = Auth::user()->user_id;
	        $campaign->save();
		} else {
			Keyword::where('campaign_id', $campaign->campaign_id)->delete();
		}

		/*$campaign = Campaign::where('csv', $filename)->count();
		if ($campaign == 0) {
			$campaign = new Campaign;
	        $campaign->campaign = $campaignName;
	        $campaign->csv = $filename;
	        $campaign->user_id = Auth::user()->user_id;
	        $campaign->save();
		} else {
			Keyword::where('csv', $filename)->delete();
		}*/
	}

	/*public static function deleteCampaign($campaignName) {
		$campaigns = Campaign::all();
		foreach ($campaigns as $key => $campaign) {
			if ($campaign->csv == $filename) {
				$deletedCampaign = Campaign::find($campaign->campaign_id);
				$deletedCampaign->delete();
			}
		}
	}

	public static function addCampaign($campaignName, $filename) {
		$campaign = new Campaign;
        $campaign->campaign = $campaignName;
        $campaign->csv = $filename;
        $campaign->user_id = Auth::user()->user_id;
        $campaign->save();
	}*/

	// public static function uploadCsv() {
 //        if (Input::hasFile('csv')) {
 //            $file = Input::file('csv');
 //            $dir = (Auth::check()) ? '/uploads' : '/uploads/guest';
 //            $destinationPath = public_path() . $dir;
 //            // $destinationPath = public_path() . '/uploads';
 //            $filename = $file->getClientOriginalName();
 //            $extension = $file->getClientOriginalExtension();
 //            if ($extension == 'csv') {
 //                $upload = $file->move($destinationPath, $filename);
 //                if ($upload) {
 //                    return $filename;
 //                } else {
 //                    return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed!');
 //                }
 //            } else {
 //                return Redirect::to('keyword/import')->with('error', 'Import a csv file from <a href="http://adwords.google.com" class="alert-link">Google AdWords Keyword Planner!</a>!');
 //            }
 //        } else {
 //            return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed. Please select a csv file!');
 //        }
 //    }

    public static function uploadCsv($file) {
            $dir = (Auth::check()) ? '/uploads' : '/uploads/guest';
            $destinationPath = public_path() . $dir;
        	$filename = $file->getClientOriginalName();
            $upload = $file->move($destinationPath, $filename);
            if ($upload) {
            	return true;
           	} else {
            	return false;
            }
    }

}
