<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\AlternativeComparisons;
use App\Models\Criteria;
use Illuminate\Http\Request;

class AlternativeComparisonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data perbandingan alternatif dengan eager loading relasi alternatif dan kriteria
        $alternativeCom = AlternativeComparisons::with(['alternative', 'criteria'])->get();

        // Mengirimkan data ke view
        return view('pages.perbandinganAlternative.index', [
            'values' => $alternativeCom, // Data perbandingan alternatif
            // 'alternatives' => $alternatives, // Data alternatif
            // 'criterias' => $criterias, // Data kriteria
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AlternativeComparisons $alternativeComparisons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comparisons = AlternativeComparisons::with(['alternative', 'criteria'])
        ->where('alternative_id', $id)
        ->get();        return view('pages.perbandinganAlternative.edit', [
            'values' => $comparisons,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $comparisonIds = $request->input('comparison_ids');
    $values = $request->input('values');

    foreach ($comparisonIds as $index => $id) {
        $comparison = AlternativeComparisons::findOrFail($id);
        $comparison->update([
            'value' => $values[$index],
        ]);
    }

    return redirect('/alternatives-comparisons')->with('success', 'Data perbandingan alternatif berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlternativeComparisons $alternativeComparisons)
    {
        //
    }
}
