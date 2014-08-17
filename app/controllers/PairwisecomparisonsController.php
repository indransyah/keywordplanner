<?php

class PairwisecomparisonsController extends \BaseController {

	protected $RI = array(0, 0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51);
    protected $options = array(
        '1' => '1. Sama penting dengan',
        '2' => '2. Mendekati sedikit lebih penting dari',
        '3' => '3. Sedikit lebih penting dari',
        '4' => '4. Mendekati lebih penting dari',
        '5' => '5. Lebih penting dari',
        '6' => '6. Mendekati sangat penting dari',
        '7' => '7. Sangat penting dari',
        '8' => '8. Mendekati mutlak dari',
        '9' => '9. Mutlak sangat penting dari'
    );

    public function postProcess($criterion_id = null)
    {
        if (empty($criterion_id)) {
            $items = Criterion::all();
            $itemId = "criterion_id";
        } else {
            $items = Subcriterion::where('criterion_id', '=', $criterion_id)->get();
            $itemId = "subcriterion_id";
        }
        $max = count($items);

        // Convert judgments into matrix
        $index = 0;
        for ($i = 0; $i < $max; $i++) {
            $total[$i] = 0;
            for ($j = 0; $j < $max; $j++) {
                if ($i == $j) {
                    $judgments[$i][$j] = (float) 1;
                    $data[$index][$itemId] = $items[$i]->$itemId;
                    $data[$index]['judgment'] = (float) 1;
                    $data[$index]['compared_' . $itemId] = $items[$j]->$itemId;
                    $index++;
                } else {
                    $tmp = Input::get($items[$i]->$itemId . '-' . $items[$j]->$itemId);
                    if (is_null($tmp)) {
                        $input = (float) 1 / Input::get($items[$j]->$itemId . '-' . $items[$i]->$itemId);
                        $data[$index][$itemId] = $items[$i]->$itemId;
                        $data[$index]['judgment'] = $input;
                        $data[$index]['compared_' . $itemId] = $items[$j]->$itemId;
                        $index++;
                    } else {
                        $input = (float) Input::get($items[$i]->$itemId . '-' . $items[$j]->$itemId);
                        $data[$index][$itemId] = $items[$i]->$itemId;
                        $data[$index]['judgment'] = $input;
                        $data[$index]['compared_' . $itemId] = $items[$j]->$itemId;
                        $index++;
                    }
                    $judgments[$i][$j] = $input;
                }
            }
        }
        $judgmentTotal = Ahp::total($judgments, $max);
        $normalization = Ahp::normalization($judgments, $judgmentTotal, $max);
        $normalizationTotal = Ahp::total($normalization, $max);
        $tpv = Ahp::tpv($normalization, $max);
        $rating = Ahp::rating($tpv, $max);

        if (!empty($criterion_id)) {
            $weight = Ahp::weight($rating, $criterion_id, $max);
        }

        $Ax = Ahp::Ax($judgments, $tpv, $max);
        $lamda = Ahp::lamda($Ax, $tpv, $max);
        $lamdaMax = array_sum($lamda) / $max;
        $CI = ($lamdaMax - $max) / ($max - 1);
        $CR = $CI / $this->RI[$max];
        if (round($CR, 2) <= 0.1) {
            // Consistent
            if (empty($criterion_id)) {

                // Delete criteria judgments
                /*foreach ($data as $key => $value) {
                    $criterion = Criterion::find($value['criterion_id']);
                    $criterion->comparecriteria()->detach($value['compared_criterion_id'], array('judgment' => $value['judgment']));
                }*/
                Ahp::clearJudgments(null, $data);

                // Add new criteria judgments
                /*foreach ($data as $key => $value) {
                    $criterion = Criterion::find($value['criterion_id']);
                    $criterion->comparecriteria()->attach($value['compared_criterion_id'], array('judgment' => $value['judgment']));
                }*/
                Ahp::addJudgments(null, $data);

                // Save TPV into database
                /*foreach (Criterion::all() as $key => $criterion) {
                    $criterion->tpv = $tpv[$key];
                    $criterion->save();
                }*/
                // Ahp::saveTpvRating(null, $tpv);
                Ahp::saveTpvRatingWeight(null, $tpv, $rating, null);

                return Redirect::to('pairwisecomparison/criteria');
            } else {

                // Delete subcriteria judgments
                /*foreach ($data as $key => $value) {
                    $subcriterion = Subcriterion::find($value['subcriterion_id']);
                    $subcriterion->comparesubcriteria()->detach($value['compared_subcriterion_id'], array('judgment' => $value['judgment']));
                }*/
                Ahp::clearJudgments($criterion_id, $data);

                // Add new subcriteria judgments
                /*foreach ($data as $key => $value) {
                    $subcriterion = Subcriterion::find($value['subcriterion_id']);
                    $subcriterion->comparesubcriteria()->attach($value['compared_subcriterion_id'], array('judgment' => $value['judgment']));
                }*/
                Ahp::addJudgments($criterion_id, $data);

                // Save TPV & Rating into database
                /*foreach (Subcriterion::where('criterion_id', $criterion_id)->get() as $key => $subcriterion) {
                    $subcriterion->tpv = $tpv[$key];
                    $subcriterion->rating = $tpv[$key]/max($tpv);
                    $subcriterion->save();
                }*/
                // Ahp::saveTpvRating($criterion_id, $tpv);
                Ahp::saveTpvRatingWeight($criterion_id, $tpv, $rating, $weight);

                return Redirect::to('pairwisecomparison/subcriteria/'.$criterion_id);
            }            
        } else {
            // Not Consistent
            if (empty($criterion_id)) {
                // Show Criteria Pairwise Comparisons
                $this->layout->content = View::make('pairwisecomparisons.criteria')->with(array(
                    'criteria' => $items,
                    'judgments' => $judgments,
                    'judgmentTotal' => $judgmentTotal,
                    'normalization' => $normalization,
                    'normalizationTotal' => $normalizationTotal,
                    'tpv' => $tpv,
                    // 'rating' => $rating,
                    'Ax' => $Ax,
                    'lamda' => $lamda,
                    'lamdaMax' => $lamdaMax,
                    'CI' => $CI,
                    'RI' => $this->RI[$max],
                    'CR' => $CR
                ));
            } else {
                // Show Subcriteria Pairwise Comparisons
                $this->layout->content = View::make('pairwisecomparisons.subcriteria')->with(array(
                    'criterion_id' => $criterion_id,
                    'subcriteria' => $items,
                    'judgments' => $judgments,
                    'judgmentTotal' => $judgmentTotal,
                    'normalization' => $normalization,
                    'normalizationTotal' => $normalizationTotal,
                    'tpv' => $tpv,
                    'rating' => $rating,
                    'weight' => $weight,
                    'Ax' => $Ax,
                    'lamda' => $lamda,
                    'lamdaMax' => $lamdaMax,
                    'CI' => $CI,
                    'RI' => $this->RI[$max],
                    'CR' => $CR
                ));
            }
        }
    }

    public function getCriteria()
    {
        // Check consistency
        $consistency = Ahp::consistency();
        if ($consistency==false) {
            return Redirect::to('judgment/criteria')->with('error', 'Criteria judgments empty / not consistent. Please set the judgments!');
        }

        // Convert judgments into matrix
        $i=0;
        foreach (Criterion::with('comparecriteria')->get() as $criteria)
        {
            $j=0;
            foreach ($criteria->comparecriteria as $comparecriteria) {
                $judgments[$i][$j]=$comparecriteria->pivot->judgment;
                $j++;
            }
            $i++;
        }
        $criteria = Criterion::all();
        $max = count($criteria);
        $judgmentTotal = Ahp::total($judgments, $max);
        $normalization = Ahp::normalization($judgments, $judgmentTotal, $max);
        $normalizationTotal = Ahp::total($normalization, $max);
        $tpv = Ahp::tpv($normalization, $max);
        $Ax = Ahp::Ax($judgments, $tpv, $max);
        $lamda = Ahp::lamda($Ax, $tpv, $max);
        $lamdaMax = array_sum($lamda) / $max;
        $CI = ($lamdaMax - $max) / ($max - 1);
        $CR = $CI / $this->RI[$max];
        $this->layout->content = View::make('pairwisecomparisons.criteria')->with(array(
            'criteria' => $criteria,
            'judgments' => $judgments,
            'judgmentTotal' => $judgmentTotal,
            'normalization' => $normalization,
            'normalizationTotal' => $normalizationTotal,
            'tpv' => $tpv,
            'Ax' => $Ax,
            'lamda' => $lamda,
            'lamdaMax' => $lamdaMax,
            'CI' => $CI,
            'RI' => $this->RI[$max],
            'CR' => $CR
            ));
    }

    public function getSubcriteria($criterion_id = null)
    {
        if (empty($criterion_id)) {
            // Show the criteria list
            $criteria = Criterion::all();
            foreach ($criteria as $key => $criterion) {
                $consistency = 'Consistent';
                $subcriteria = Subcriterion::where('criterion_id', $criterion->criterion_id)->get();
                $totalSubcriteria = count($subcriteria);
                if ($totalSubcriteria==0) {
                    $consistency = 'Not Consistent';
                }
                foreach ($subcriteria as $subcriterion) {
                    if ($subcriterion->rating == 0) {
                        $consistency = 'Not Consistent';
                    }
                }
                $criteria[$key]['consistency'] = $consistency;
            }
            $this->layout->content = View::make('judgments.index')->with('criteria', $criteria);
        } else {
            // Show the pairwise comparisons / judgments
            
            // Check consistency
            $consistency = Ahp::consistency($criterion_id);
            if ($consistency==false) {
                return Redirect::to('judgment/subcriteria/'.$criterion_id)->with('error', 'Subcriteria judgments empty / not consistent. Please set the judgments!');
            }

            // Convert judgments into matrix
            $i=0;
            foreach (Subcriterion::where('criterion_id', $criterion_id)->with('comparesubcriteria')->get() as $subcriteria)
            {
                $j=0;
                foreach ($subcriteria->comparesubcriteria as $comparesubcriteria) {
                    $judgments[$i][$j]=$comparesubcriteria->pivot->judgment;
                    $j++;
                }
                $i++;
            }
            $max = $i;
            $subcriteria = Subcriterion::where('criterion_id', $criterion_id)->get();
            $judgmentTotal = Ahp::total($judgments, $max);
            $normalization = Ahp::normalization($judgments, $judgmentTotal, $max);
            $normalizationTotal = Ahp::total($normalization, $max);
            $tpv = Ahp::tpv($normalization, $max);
            $rating = Ahp::rating($tpv, $max);
            $weight = Ahp::weight($rating, $criterion_id, $max);
            $Ax = Ahp::Ax($judgments, $tpv, $max);
            $lamda = Ahp::lamda($Ax, $tpv, $max);
            $lamdaMax = array_sum($lamda) / $max;
            $CI = ($lamdaMax - $max) / ($max - 1);
            $CR = $CI / $this->RI[$max];
            $this->layout->content = View::make('pairwisecomparisons.subcriteria')->with(array(
                'criterion_id' => $criterion_id,
                'subcriteria' => $subcriteria,
                'judgments' => $judgments,
                'judgmentTotal' => $judgmentTotal,
                'normalization' => $normalization,
                'normalizationTotal' => $normalizationTotal,
                'tpv' => $tpv,
                'rating' => $rating,
                'weight' => $weight,
                'Ax' => $Ax,
                'lamda' => $lamda,
                'lamdaMax' => $lamdaMax,
                'CI' => $CI,
                'RI' => $this->RI[$max],
                'CR' => $CR
                ));
        }
    }

}
