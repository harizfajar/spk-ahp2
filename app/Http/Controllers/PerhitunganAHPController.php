<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\AlternativeComparisons;
use App\Models\Criteria;
use App\Models\CriteriaComparisons;
use Illuminate\Http\Request;

class PerhitunganAHPController extends Controller
{
    public function index()
    {
        return view('pages.perhitunganAHP.index');
    }


    public function calculateAHP()
    {
        // 1. Ambil semua kriteria dan urutkan agar konsisten
        $criterias = Criteria::orderBy('id')->get();
        $n = $criterias->count();

        // 2. Buat array [id => index] agar bisa mapping posisi
        $criteriaIndexMap = [];
        foreach ($criterias as $index => $criteria) {
            $criteriaIndexMap[$criteria->id] = $index;
        }

        // 3. Inisialisasi matriks NxN dengan nilai default 1 jika i==j, atau 0 sementara
        $matrix = array_fill(0, $n, array_fill(0, $n, 1.0));
        // 4. Ambil data perbandingan dari tabel
        $comparisons = CriteriaComparisons::all();

        foreach ($comparisons as $comp) {
            $i = $criteriaIndexMap[$comp->criteria_id_1];
            $j = $criteriaIndexMap[$comp->criteria_id_2];
            $value = $comp->value;

            $matrix[$i][$j] = $value;
            $matrix[$j][$i] = 1 / $value; // nilai kebalikannya
        }

        // 5. Hitung jumlah kolom
        $columnSums = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSums[$j] += $matrix[$i][$j];
            }
        }

        // 6. Normalisasi matriks
        $normalizedMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalizedMatrix[$i][$j] = $matrix[$i][$j] / $columnSums[$j];
            }
        }

        // 7. Hitung bobot (rata-rata tiap baris)
        $priorityVector = [];
        for ($i = 0; $i < $n; $i++) {
            $priorityVector[$i] = array_sum($normalizedMatrix[$i]) / $n;
        }

        $totalPerKriteria = [];
        for ($j = 0; $j < $n; $j++) {
            $totalPerKriteria[$j] = 0;
            for ($i = 0; $i < $n; $i++) {
                $totalPerKriteria[$j] += $matrix[$i][$j]; // jumlah per kolom
            }
        }



        $eigenValue = 0;
        for ($i = 0; $i < $n; $i++) {
            $eigenValue = 0;
            for ($j = 0; $j < $n; $j++) {
                $eigenValue += $totalPerKriteria[$j] * $priorityVector[$j];
            }
        }
        // dd($eigenValue);

        // 8. Hitung λ max
        $lambdaMax = $eigenValue;
        // for ($i = 0; $i < $n; $i++) {
        //     $sumRow = 0;
        //     for ($j = 0; $j < $n; $j++) {
        //         $sumRow += $matrix[$i][$j] * $priorityVector[$j];
        //     }
        //     $lambdaMax += $sumRow / $priorityVector[$i];
        // }
        // $lambdaMax = $lambdaMax / $n;

        // 9. CI dan CR
        $CI = ($lambdaMax - $n) / ($n - 1);
        $RI = [0, 0, 0.58, 0.90, 1.12, 1.24]; // bisa ditambah
        $CR = $CI / ($RI[$n-1] ?? 1);

        // 10. Ambil data alternatif
        $alternatives = Alternative::all();

        // 11. Hitung total skor tiap alternatif (AHP)
       // Tambahan di atas sebelum return view

        // 10. Ambil data alternatif
        $alternatives = Alternative::all();

        // [NEW] Ambil semua nilai alternatif (bukan per alternatif)
        $allValues = AlternativeComparisons::all();

        // [NEW] Kelompokkan berdasarkan criteria_id
        $groupedValues = [];
        foreach ($allValues as $val) {
            $groupedValues[$val->criteria_id][$val->alternative_id] = $val->value;
        }

        // [NEW] Normalisasi alternatif
        $normalizedAlternatives = []; // [alternative_id][criteria_id] = normalized_value

        foreach ($groupedValues as $criteriaId => $values) {
            $criteria = $criterias->firstWhere('id', $criteriaId);
            $attribute = strtolower($criteria->atribut); // 'benefit' atau 'cost'
            if ($attribute === 'cost') {
                // Normalisasi invers untuk cost
                $inverses = [];
                foreach ($values as $altId => $val) {
                    $inverses[$altId] = 1 / $val;
                }
                $sumInverses = array_sum($inverses);
                foreach ($inverses as $altId => $invVal) {
                    $normalizedAlternatives[$altId][$criteriaId] = $invVal / $sumInverses;
                }
            } else {
                // Normalisasi biasa untuk benefit
                $sum = array_sum($values);
                foreach ($values as $altId => $val) {
                    $normalizedAlternatives[$altId][$criteriaId] = $val / $sum;
                }
            }
        }
        $altIds = array_keys($normalizedAlternatives);

        $alternatifMap = Alternative::whereIn('id', $altIds)->get()->keyBy('id');



        // [NEW] Hitung skor berdasarkan nilai normalisasi
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

        // Urutkan dari yang tertinggi
        usort($alternativeScores, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('pages.perhitunganAHP.index', [
            'criterias' => $criterias,
            'matrix' => $matrix,
            'normalizedMatrix' => $normalizedMatrix,
            'priorityVector' => $priorityVector,
            'lambdaMax' => $lambdaMax,
            'CI' => $CI,
            'CR' => $CR,
            'isConsistent' => $CR < 0.1,
            'alternativeScores' => $alternativeScores,
            'normalizedAlternatives' => $normalizedAlternatives, 
            'alternatifMap' => $alternatifMap, 

        ]);
    }

}
