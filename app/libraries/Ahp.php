<?php

class Ahp {
	
	public static function campaignExistency() {
        $campaign = Campaign::where('user_id', Auth::user()->user_id)->count();
        if ($campaign == 0) {
            return false;
        } else {
            return true;
        }
        
    }

    public static function criteriaExistency() {
        $criteria = Criterion::all()->count();
        if ($criteria < 3) {
            return false;
        } else {
            return true;
        }
    }

    public static function subcriteriaExistency($criterion_id = null) {
        if (empty($criterion_id)) {
            $criteria = Criterion::all();
            foreach ($criteria as $criterion) {
                if (count($criterion->subcriteria) < 3) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            $criterion = Criterion::find($criterion_id);
            if (count($criterion->subcriteria) < 3) {
                return false;
            } else {
                return true;
            }
        }
    }

    public static function range($value, $min, $max){
        if($value < $min) return false;
        if($value > $max) return false;
        return true;
    }

    public static function subcriteriaWeight($criterion_id, $keyword) {
        $criterion = Criterion::find($criterion_id);
        $weight = 0;
        foreach ($criterion->subcriteria as $key => $subcriterion) {
            $range = explode('-', $subcriterion->conditional);
            if (count($range)==2) {
                if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
                    $weight = $subcriterion->weight+$weight;
                }
            } else {
                if ($keyword[$criterion->field]==$subcriterion->conditional) {
                    $weight = $subcriterion->weight+$weight;
                }
            }
        }
        return $weight;
    }

    public static function keywordScore($keywords) {
        $criteria = Criterion::all();
        $score = 0;
        foreach ($keywords as $key => $keyword) {
            foreach ($criteria as $criterion) {
                $score = self::subcriteriaWeight($criterion->criterion_id, $keyword)+$score;
            }
            $keywords[$key]['score'] = $score;
            $score = 0;
        }
        // $criteria = Criterion::all();
        // $score = 0;
        // foreach ($criteria as $key => $criterion) {
        //     $score = self::subcriteriaWeight($criterion->criterion_id, $keyword)+$score;
        // }
        return $keywords;
    }

    public static function criteriaConsistency() {
        $criteria = Criterion::all();
        $consistency = true;
        foreach ($criteria as $key => $criterion) {
            if ($criterion->tpv==0) {
                $consistency = false;
            }
        }
        if (count($criteria)==0) {
            $consistency = false;
        }
        return $consistency;
    }

    public static function subcriteriaConsistency($criterion_id) {
        $subcriteria = Subcriterion::where('criterion_id', $criterion_id)->get();
        $consistency = true;
        foreach ($subcriteria as $key => $subcriterion) {
            if ($subcriterion->tpv==0) {
                $consistency = false;
            }
        }
        return $consistency;
    }

    public static function allConsistency() {
        $criteriaConsistency = self::criteriaConsistency();
        if (!$criteriaConsistency) {
            return false;
        }
        $criteria = Criterion::all();
        foreach ($criteria as $key => $criterion) {
            $subcriteriaConsistency = self::subcriteriaConsistency($criterion->criterion_id);
            if (!$subcriteriaConsistency) {
                return false;
            }
        }
        return true;
    }

    /*public static function process($keyword) {
        // $fields = (word, search, competition, bid);
        $criteria = Criterion::all();
        foreach ($criteria as $criterion) {
            foreach ($criterion->subcriteria as $subcriterion) {
                $range = explode('-', $subcriterion->conditional);
                $tmp = 0;
                if (count($range)==2) {
                    if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
                        $tmp = $subcriterion->weight+$tmp;
                    }
                } else {
                    if ($keyword[$criterion->field]==$conditional) {
                        $tmp = $subcriterion->weight+$tmp;
                    }
                }

            }
            // return $criterion->subcriteria;
            /*foreach ($fields as $field) {
                if ($criterion->field==$keyword[$field]) {
                    foreach ($criterion->subcriteria as $subcriterion) {
                        if ($keyword[]) {
                            # code...
                        }
                        $tmp = $subcriterion->weight+$tmp;
                    }
                }
            }
            // $keyword[$criterion->field]
        }
    }*/

    /*public static function competition($value) {
        switch ($value) {
            case ($value<0.33):
                return 'Low';
                break;
            
            case ($value>0.33 && $value<0.66):
                return 'Medium';
                break;

            case ($value>0.67):
                return 'High';
                break;
        }
        // OLD
        switch ($keyword['competition']) {
            case ($keyword['competition']<0.33):
                return 'Low';
                break;
            
            case ($keyword['competition']>0.33 && $keyword['competition']<0.66):
                return 'Medium';
                break;

            case ($keyword['competition']>0.67):
                return 'High';
                break;
        }
    }*/

    /*public static function consistency($criterion_id = null) {
        if (empty($criterion_id)) {
            $criteria = Criterion::all();
            $totalCriteria = count($criteria);
            if ($totalCriteria==0) {
                return false;
            }
            foreach ($criteria as $criterion) {
                if ($criterion->tpv == 0) {
                    return false;
                }
            }
            return true;
        } else {
            $subcriteria = Subcriterion::where('criterion_id', $criterion_id)->get();
            $totalSubcriteria = count($subcriteria);
            if ($totalSubcriteria==0) {
                return false;
            }
            foreach ($subcriteria as $subcriterion) {
                if ($subcriterion->weight == 0) {
                    return false;
                }
            }
            return true;
        }
    }*/

    public static function clearJudgments($criterion_id = null, $data){
        if (empty($criterion_id)) {
            foreach ($data as $key => $value) {
                $criterion = Criterion::find($value['criterion_id']);
                $criterion->comparecriteria()->detach($value['compared_criterion_id'], array('judgment' => $value['judgment']));
            }
        } else {
            foreach ($data as $key => $value) {
                $subcriterion = Subcriterion::find($value['subcriterion_id']);
                $subcriterion->comparesubcriteria()->detach($value['compared_subcriterion_id'], array('judgment' => $value['judgment']));
            }
        }
    }

    public static function addJudgments($criterion_id = null, $data){
        if (empty($criterion_id)) {
            foreach ($data as $key => $value) {
                $criterion = Criterion::find($value['criterion_id']);
                $criterion->comparecriteria()->attach($value['compared_criterion_id'], array('judgment' => $value['judgment']));
            }
        } else {
            foreach ($data as $key => $value) {
                $subcriterion = Subcriterion::find($value['subcriterion_id']);
                $subcriterion->comparesubcriteria()->attach($value['compared_subcriterion_id'], array('judgment' => $value['judgment']));
            }
        }
    }

    // NOT USE
    /*public static function saveTpvRating($criterion_id = null, $tpv){
        if (empty($criterion_id)) {
            $criteria = Criterion::all();
            foreach ($criteria as $key => $criterion) {
                $criterion->tpv = $tpv[$key];
                $criterion->save();
            }
        } else {
            $criterion = Criterion::find($criterion_id);
            // $subcriteria = Subcriterion::where('criterion_id', $criterion_id)->get();
            // foreach ($subcriteria as $key => $subcriterion) {
            // return $criterion->subcriteria();
            foreach ($criterion->subcriteria as $key => $subcriterion) {
                // return $tpv[$key];
                $subcriterion->tpv = $tpv[$key];
                $rating = $tpv[$key]/max($tpv);
                $subcriterion->rating = $rating;
                $subcriterion->weight = $rating*$criterion->tpv;
                $subcriterion->save();
            }
        }
    }*/

    public static function saveTpvRatingWeight($criterion_id = null, $tpv, $rating, $weight = null) {
        if (empty($criterion_id) && empty($weight)) {
            $criteria = Criterion::all();
            foreach ($criteria as $key => $criterion) {
                $criterion->tpv = $tpv[$key];
                $criterion->save();
            }
        } else {
            $criterion = Criterion::find($criterion_id);
            foreach ($criterion->subcriteria as $key => $subcriterion) {
                $subcriterion->tpv = $tpv[$key];
                $subcriterion->rating = $rating[$key];
                $subcriterion->weight = $weight[$key];
                $subcriterion->save();
            }
        }
    }

    // // NOT USE
    // public static function saveTpv($criterion_id = null, $tpv) {
    //     if (empty($criterion_id)) {
    //         $criteria = Criterion::all();
    //         foreach ($criteria as $key => $criterion) {
    //             $criterion->tpv = $tpv[$key];
    //             $criterion->save();
    //         }
    //     } else {
    //         $criterion = Criterion::find($criterion_id);
    //         foreach ($criterion->subcriteria as $key => $subcriterion) {
    //             $subcriterion->tpv = $tpv[$key];
    //             $subcriterion->save();
    //         }
    //     }
    // }

    // // NOT USE
    // public static function saveRating($rating) {
    //     $criterion = Criterion::find($criterion_id);
    //     foreach ($criterion->subcriteria as $key => $subcriterion) {
    //         $subcriterion->rating = $rating[$key];
    //         $subcriterion->save();
    //     }
    // }

    // // NOT USE
    // public static function saveWeight($weight) {
    //     $criterion = Criterion::find($criterion_id);
    //     foreach ($criterion->subcriteria as $key => $subcriterion) {
    //         $subcriterion->weight = $weight[$key];
    //         $subcriterion->save();
    //     }
    // }    


    // AHP
	public static function total($matrix, $max) {
		for ($i = 0; $i < $max; $i++) {
            $total[$i] = 0;
            for ($j = 0; $j < $max; $j++) {
                $total[$i] += $matrix[$j][$i];
            }
        }
        return $total;
	}

	public static function normalization($judgments, $judgmentTotal, $max) {
		for ($i = 0; $i < $max; $i++) {
            for ($j = 0; $j < $max; $j++) {
                $normalization[$i][$j] = $judgments[$i][$j] / $judgmentTotal[$j];
            }
        }
        return $normalization;
	}

    public static function tpv($normalization, $max) {
        for ($i = 0; $i < $max; $i++) {
            $tpv[$i] = 0;
            for ($j = 0; $j < $max; $j++) {
                $tpv[$i] += $normalization[$i][$j];
                if ($j == $max - 1) {
                    $tpv[$i] /= $max;
                }
            }
        }
        return $tpv;
    }

    public static function rating($tpv, $max) {
        for ($i = 0; $i < $max; $i++) {
            $rating[$i] = 0;
            for ($j = 0; $j < $max; $j++) {
                $rating[$i] = $tpv[$i] / max($tpv);
            }
        }
        return $rating;
    }

    public static function weight($rating, $criterion_id, $max) {
        $criterion = Criterion::find($criterion_id);
        for ($i=0; $i < $max; $i++) { 
            // $weight[$i] = 0;
            $weight[$i] = $rating[$i]*$criterion->tpv;
        }
        return $weight;
    }

    public static function Ax($judgments, $tpv, $max) {
        for ($i = 0; $i < $max; $i++) {
            $Ax[$i] = 0;
            for ($j = 0; $j < $max; $j++) {
                $Ax[$i] += $judgments[$i][$j] * $tpv[$j];
            }
        }
        return $Ax;
    }

    public static function lamda($Ax, $tpv, $max) {
        for ($i = 0; $i < $max; $i++) {
            $lamda[$i] = $Ax[$i] / $tpv[$i];
        }
        return $lamda;
    }

}