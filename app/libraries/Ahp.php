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

    // public static function criteriaExistency() {
    //     $criteria = Criterion::all()->count();
    //     if ($criteria < 3) {
    //         return false;
    //     } else {
    //         return true;
    //     }
    // }

    // public static function subcriteriaExistency($criterion_id = null) {
    //     if (empty($criterion_id)) {
    //         $criteria = Criterion::all();
    //         foreach ($criteria as $criterion) {
    //             if (count($criterion->subcriteria) < 3) {
    //                 return false;
    //             } else {
    //                 return true;
    //             }
    //         }
    //     } else {
    //         $criterion = Criterion::find($criterion_id);
    //         if (count($criterion->subcriteria) < 3) {
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     }
    // }

    public static function range($value, $min, $max){
        if($value < $min) return false;
        if($value > $max) return false;
        return true;
    }

    // public static function subcriteriaWeight($criterion_id, $keyword) {
    //     $criterion = Criterion::find($criterion_id);
    //     $weight = 0;
    //     foreach ($criterion->subcriteria as $key => $subcriterion) {
    //         $range = explode('-', $subcriterion->range);
    //         if (count($range)==2) {
    //             if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
    //                 $weight = $subcriterion->weight+$weight;
    //             }
    //         } else {
    //             $sign = substr($subcriterion->range, 0, 1);
    //             $value = substr($subcriterion->range, 1);
    //             if ($sign == '<' && $keyword[$criterion->field] < $value) {
    //                 $weight = $subcriterion->weight+$weight;
    //             } elseif ($sign == '>' && $keyword[$criterion->field] > $value) {
    //                 $weight = $subcriterion->weight+$weight;
    //             } else {
    //                 if ($keyword[$criterion->field]==$subcriterion->range) {
    //                     $weight = $subcriterion->weight+$weight;
    //                 }
    //             }
    //         }
    //     }
    //     return $weight;
    // }

    public static function subcriteriaWeight($criterion_id, $keyword) {
        $criterion = Criterion::find($criterion_id);
        $weight = 0;
        foreach ($criterion->subcriteria as $key => $subcriterion) {
            $weight = $subcriterion->weight;

            $range = explode('-', $subcriterion->range);
            if (count($range)==2) {
                if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
                    return $weight;
                }
            }

            $sign = substr($subcriterion->range, 0, 1);
            $value = substr($subcriterion->range, 1);
            if ($sign == '<' && $keyword[$criterion->field] < $value) {
                return $weight;

            }

            if ($sign == '>' && $keyword[$criterion->field] > $value) {
                return $weight;
            }

            if ($keyword[$criterion->field]==$subcriterion->range) {
                return $weight;
            }
            
        }
        return $weight;
    }

    public static function keywordSubcriteriaWeight($criterion_id, $keyword) {
        $criterion = Criterion::find($criterion_id);
        $classification = array();
        $classification['weight'] = 0;
        $classification['class'] = '-';
        $classification['value'] = '-';
        foreach ($criterion->subcriteria as $key => $subcriterion) {
            $classification['weight'] = $subcriterion->weight;
            $classification['class'] = $subcriterion->subcriterion;
            $classification['value'] = $keyword[$criterion->field];

            $range = explode('-', $subcriterion->range);
            if (count($range)==2) {
                if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
                    return $classification;
                }
            }

            $sign = substr($subcriterion->range, 0, 1);
            $value = substr($subcriterion->range, 1);
            if ($sign == '<' && $keyword[$criterion->field] < $value) {
                return $classification;

            }

            if ($sign == '>' && $keyword[$criterion->field] > $value) {
                return $classification;
            }

            if ($keyword[$criterion->field]==$subcriterion->range) {
                return $classification;
            }

            // $range = explode('-', $subcriterion->range);
            // if (count($range)==2) {
            //     if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
            //         $classification['weight'] = $subcriterion->weight+$classification['weight'];
            //         $classification['class'] = $subcriterion->subcriterion;
            //         $classification['value'] = $keyword[$criterion->field];
            //         return $classification;
            //     }
            // }

            // $sign = substr($subcriterion->range, 0, 1);
            // $value = substr($subcriterion->range, 1);
            // if ($sign == '<' && $keyword[$criterion->field] < $value) {
            //     // return 'kurang dari';
            //     $classification['weight'] = $subcriterion->weight+$classification['weight'];
            //     $classification['class'] = $subcriterion->subcriterion;
            //     $classification['value'] = $keyword[$criterion->field];
            //     return $classification;

            // }
            // if ($sign == '>' && $keyword[$criterion->field] > $value) {
            //     // return 'lebih dari';
            //     $classification['weight'] = $subcriterion->weight+$classification['weight'];
            //     $classification['class'] = $subcriterion->subcriterion;
            //     $classification['value'] = $keyword[$criterion->field];
            //     return $classification;
            // }

            // if ($keyword[$criterion->field]==$subcriterion->range) {
            //     // return $keyword[$criterion->field].'sama dengan'.$subcriterion->range;
            //     $classification['weight'] = $subcriterion->weight+$classification['weight'];
            //     $classification['class'] = $subcriterion->subcriterion;
            //     $classification['value'] = $keyword[$criterion->field];
            //     return $classification;
            // }

        }
        return $classification;
    }

    // fgfgfg
    public static function subcriteriaWeightNew($criterion_id, $keyword) {
        $criterion = Criterion::find($criterion_id);
        $weight = array();
        $tmp = 0;
        foreach ($criterion->subcriteria as $key => $subcriterion) {
            $range = explode('-', $subcriterion->range);
            if (count($range)==2) {
                if (self::range($keyword[$criterion->field], $range[0], $range[1])) {
                    $weight[$subcriterion->subcriterion_id][$criterion->field] = $subcriterion->rating*$criterion->tpv;
                    // $tmp = $weight[$subcriterion->subcriterion_id][$criterion->field]+$tmp;
                }
            } else {
                $sign = substr($subcriterion->range, 0, 1);
                $value = substr($subcriterion->range, 1);
                if ($sign == '<' && $keyword[$criterion->field] < $value) {
                    $weight[$subcriterion->subcriterion_id][$criterion->field] = $subcriterion->rating*$criterion->tpv;
                    // $weight = $subcriterion->weight+$weight;
                } elseif ($sign == '>' && $keyword[$criterion->field] > $value) {
                    $weight[$subcriterion->subcriterion_id][$criterion->field] = $subcriterion->rating*$criterion->tpv;
                    // $weight = $subcriterion->weight+$weight;
                } else {
                    if ($keyword[$criterion->field]==$subcriterion->range) {
                        $weight[$subcriterion->subcriterion_id][$criterion->field] = $subcriterion->rating*$criterion->tpv;
                        // $weight = $subcriterion->weight+$weight;
                    }
                }
            }
        }
        return $weight;
    }

    public static function subcriteriaRating($criterion_id, $keyword) {
        
    }
    // hghg

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
        if (count($subcriteria)==0) {
            $consistency = false;
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
            $existency = true;
            foreach ($criteria as $criterion) {
                if (count($criterion->subcriteria) < 3) {
                    $existency = false;
                }
            }
            return $existency;
        } else {
            $criterion = Criterion::find($criterion_id);
            if (count($criterion->subcriteria) < 3) {
                return false;
            } else {
                return true;
            }
        }
    }

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

    public static function saveTpvRatingWeight($criterion_id = null, $tpv, $rating, $weight = null) {
        if (empty($criterion_id) && empty($weight)) {
            $criteria = Criterion::all();
            foreach ($criteria as $criterionKey => $criterion) {
                $criterion->tpv = $tpv[$criterionKey];
                $criterion->save();

                // Update subcriteria's weight
                foreach ($criterion->subcriteria as $subcriterion) {
                    $subcriterion->weight = $subcriterion->rating*$criterion->tpv;
                    $subcriterion->save();
                }
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

    public static function clearSubcriteriaWeight() {
        $subcriteria = Subcriterion::all();
        foreach ($subcriteria as $subcriterion) {
            $subcriterion->weight = 0;
            $subcriterion->save();
        }
    }

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
            // $weight[$i] = $rating[$i].' x '.$criterion->tpv.' = '.$rating[$i]*$criterion->tpv."\n";
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