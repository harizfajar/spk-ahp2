<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\CriteriaComparisons;
use Illuminate\Http\Request;

class CriteriaComparsions extends Controller
{
    public function index()
    {
        $criteriaComparisons = CriteriaComparisons::with(['criteria1', 'criteria2'])->get();
        $nilaiPerbandingan = [
            1 => 'Sama penting dengan',
            2 => 'Mendekati sedikit lebih penting dari',
            3 => 'Sedikit lebih penting dari',
            4 => 'Mendekati lebih penting dari',
            5 => 'Lebih penting dari',
            6 => 'Mendekati sangat penting dari',
            7 => 'Sangat penting dari',
            8 => 'Mendekati sangat sangat penting dari',
            9 => 'Sangat sangat penting dari',
        ];
        return view('pages.perbandinganCriteria.index',[
            'comparisons'=> $criteriaComparisons,
            'nilaiPerbandingan' => $nilaiPerbandingan,
        ]);
    }

    public function compare(Request $request)
    {
        $validated = $request->validate([
            'criteria_id_1' => 'required|different:criteria_id_2|exists:criteria,id',
            'criteria_id_2' => 'required|exists:criteria,id',
            'value' => 'required|numeric|min:0.01',
    ]);

    // Simpan nilai langsung
    CriteriaComparisons::updateOrCreate(
        [
            'criteria_id_1' => $validated['criteria_id_1'],
            'criteria_id_2' => $validated['criteria_id_2'],
        ],
        [
            'value' => $validated['value']
        ]
    );

    // Simpan nilai kebalikannya secara otomatis
    CriteriaComparisons::updateOrCreate(
        [
            'criteria_id_1' => $validated['criteria_id_2'],
            'criteria_id_2' => $validated['criteria_id_1'],
        ],
        [
            'value' => 1 / $validated['value']
        ]
    );

    return redirect()->back()->with('success', 'Nilai perbandingan berhasil diperbarui.');
}

}
