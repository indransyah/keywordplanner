<?php

class Keywordplanner {

	public static function convertCSV($filename) {
		$from = fopen(public_path() . '/uploads/' . $filename, 'r+');
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
				$check = array_diff($data, $fields);
				if (!empty($check)) {
					fclose($from);
					return Redirect::to('keyword/import')->with('error', 'Ups! Not valid CSV file!');
				} else {
					$pass = false;
				}
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
			$arr[$index]['score'] = Ahp::keywordScore($value);
		}
		return $arr;
	}

	public static function getCampaignName($keywords) {
		foreach ($keywords as $key => $keyword) {
			if ($keyword['group']=='Seed Keywords') {
				$campaignName = $keyword['keyword'];
			}
		}
		return $campaignName;
	}

	public static function deleteCampaign($campaignName) {
		$campaigns = Campaign::all();
		foreach ($campaigns as $key => $campaign) {
			if ($campaign->csv == $filename) {
				$deletedCampaign = Campaign::find($campaign->campaign_id);
				$deletedCampaign->delete();
			}
		}
	}

	public static function addCampaign($campaignName) {
		$campaign = new Campaign;
        $campaign->campaign = $campaignName;
        $campaign->csv = $filename;
        $campaign->user_id = Auth::user()->user_id;
        $campaign->save();
	}

	public static function uploadCsv() {
        if (Input::hasFile('csv')) {
            $file = Input::file('csv');
            $destinationPath = public_path() . '/uploads';
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'csv') {
                $upload = $file->move($destinationPath, $filename);
                if ($upload) {
                    return $filename;
                } else {
                    return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed!');
                }
            } else {
                return Redirect::to('keyword/import')->with('error', 'Import a csv file from <a href="http://adwords.google.com" class="alert-link">Google AdWords Keyword Planner!</a>!');
            }
        } else {
            return Redirect::to('keyword/import')->with('error', 'Ups! Upload failed. Please select a csv file!');
        }
    }

}