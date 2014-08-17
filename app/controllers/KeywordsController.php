<?php

class KeywordsController extends \BaseController {

	public function getIndex()
	{
		$keywords = Keyword::paginate(10);
        $this->layout->content = View::make('keywords.index')->with('keywords', $keywords);
	}

	public function getImport()
	{
        // SEMENTARA DINONAKTIFKAN
        $consistency = true;
        // $criteriaConsistency = Ahp::consistency();
        // foreach (Criterion::all() as $key => $criterion) {
        //     $subcriteriaConsistency = Ahp::consistency($criterion->criterion_id);
        //     if ($subcriteriaConsistency==false || $criteriaConsistency==false) {
        //         $consistency = false;              
        //     }
        // }
		$this->layout->content = View::make('keywords.create')->with('consistency', $consistency);
	}

	public function postStore() {
        // SEMENTARA DINONAKTIFKAN
        /*$criteriaConsistency = Ahp::consistency();
        foreach (Criterion::all() as $key => $criterion) {
            $subcriteriaConsistency = Ahp::consistency($criterion->criterion_id);
            if ($subcriteriaConsistency==false || $criteriaConsistency==false) {
                return Redirect::to('keyword/import');           
            }
        }*/
        if (Input::hasFile('csv')) {
            $file = Input::file('csv');
            $destinationPath = public_path() . '/uploads';
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'csv') {
                $upload = $file->move($destinationPath, $filename);
                if ($upload) {
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
                        // Jumlah kata
                        $arr[$index]['word'] = str_word_count($value['keyword']);
                    }
                    Keyword::where('csv', '=', $filename)->delete();
                    foreach ($arr as $key => $value) {
                        $validator = Validator::make($value, Keyword::$rules);
                        if ($validator->passes()) {

                            // Perhitungan AHP
                            // return Ahp::process($value);
                            return $value;
                            //

                            $keyword = new Keyword;
                            // $keyword->group = $value['group'];
                            $keyword->keyword = $value['keyword'];
                            // $keyword->currency = $value['currency'];
                            $keyword->search = $value['search'];
                            $keyword->competition = $value['competition'];
                            $keyword->bid = $value['bid'];
                            // $keyword->impression = $value['impression'];
                            // $keyword->account = $value['account'];
                            // $keyword->plan = $value['plan'];
                            // $keyword->extract = $value['extract'];
                            // $keyword->word = str_word_count($value['keyword']);
                            $keyword->csv = $filename;
                            $keyword->word = $value['word'];
                            $keyword->save();
                        }
                    }
                    return Redirect::to('keyword')->with('success', 'Keywords successfully imported!');
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

    public function deleteDestroy($id) {
        $keyword = Keyword::find($id);
        $keyword->delete();
        return Redirect::to('keyword')->with('success', 'Keyword successfully deleted!');
    }

}