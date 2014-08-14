<?php

class Ahp {
	
	public static function test() {
		return 'Test Ahp';
	}

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