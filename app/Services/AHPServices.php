<?php
namespace App\Services;

use App\Models\Criteria;
use App\Models\CriteriaComparisons;
use App\Models\Alternative;
use App\Models\AlternativeComparisons;
class AHPServices
{
    public function calculate()
    {
        $criterias = Criteria::orderBy('id')->get();
        $n = $criterias->count();

        $criteriaIndexMap = [];
        foreach ($criterias as $index => $criteria) {
            $criteriaIndexMap[$criteria->id] = $index;
        }

        $matrix = array_fill(0, $n, array_fill(0, $n, 1.0));
        $comparisons = CriteriaComparisons::all();

        foreach ($comparisons as $comp) {
            $i = $criteriaIndexMap[$comp->criteria_id_1];
            $j = $criteriaIndexMap[$comp->criteria_id_2];
            $value = $comp->value;

            $matrix[$i][$j] = $value;
            $matrix[$j][$i] = 1 / $value;
        }

        $columnSums = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSums[$j] += $matrix[$i][$j];
            }
        }

        $normalizedMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalizedMatrix[$i][$j] = $matrix[$i][$j] / $columnSums[$j];
            }
        }

        $priorityVector = [];
        for ($i = 0; $i < $n; $i++) {
            $priorityVector[$i] = array_sum($normalizedMatrix[$i]) / $n;
        }

        $totalPerKriteria = [];
        for ($j = 0; $j < $n; $j++) {
            $totalPerKriteria[$j] = 0;
            for ($i = 0; $i < $n; $i++) {
                $totalPerKriteria[$j] += $matrix[$i][$j];
            }
        }

        $eigenValue = 0;
        for ($j = 0; $j < $n; $j++) {
            $eigenValue += $totalPerKriteria[$j] * $priorityVector[$j];
        }

        $lambdaMax = $eigenValue;
        $CI = ($lambdaMax - $n) / ($n - 1);
        $RI = [0, 0, 0.58, 0.90, 1.12, 1.24];
        $CR = $CI / ($RI[$n - 1] ?? 1);

        $alternatives = Alternative::all();
        $allValues = AlternativeComparisons::all();

        $groupedValues = [];
        foreach ($allValues as $val) {
            $groupedValues[$val->criteria_id][$val->alternative_id] = $val->value;
        }

        $normalizedAlternatives = [];
        foreach ($groupedValues as $criteriaId => $values) {
            $criteria = $criterias->firstWhere('id', $criteriaId);
            $attribute = strtolower($criteria->atribut);

            if ($attribute === 'cost') {
                $inverses = [];
                foreach ($values as $altId => $val) {
                    $inverses[$altId] = 1 / $val;
                }
                $sumInverses = array_sum($inverses);
                foreach ($inverses as $altId => $invVal) {
                    $normalizedAlternatives[$altId][$criteriaId] = $invVal / $sumInverses;
                }
            } else {
                $sum = array_sum($values);
                foreach ($values as $altId => $val) {
                    $normalizedAlternatives[$altId][$criteriaId] = $val / $sum;
                }
            }
        }

        $alternativeScores = [];
        foreach ($alternatives as $alt) {
            $score = 0;
            foreach ($criterias as $index => $criteria) {
                $criteriaId = $criteria->id;
                $normalizedVal = $normalizedAlternatives[$alt->id][$criteriaId] ?? 0;
                $weight = $priorityVector[$index];
                $score += $normalizedVal * $weight;
            }

            $alternativeScores[] = [
                'name' => $alt->name,
                'deskripsi' => $alt->description,
                'score' => $score,
            ];
        }

        usort($alternativeScores, fn ($a, $b) => $b['score'] <=> $a['score']);

        return $alternativeScores;
    }
}
