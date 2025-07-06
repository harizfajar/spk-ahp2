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
        ])->with(['alternatives' => Alternative::all(), 'criterias' => Criteria::all()]);
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
public function edit($alternative_id)
{
    $criterias = Criteria::all();

    // Ambil perbandingan yang sudah ada
    $comparisons = AlternativeComparisons::where('alternative_id', $alternative_id)->get();

    // Cek kriteria yang belum ada perbandingannya
    foreach ($criterias as $criteria) {
        $exists = $comparisons->firstWhere('criteria_id', $criteria->id);

        if (!$exists) {
            $newComparison = AlternativeComparisons::create([
                'alternative_id' => $alternative_id,
                'criteria_id' => $criteria->id,
                'value' => 0 // atau 0 / 1 tergantung default kamu
            ]);

            $comparisons->push($newComparison);
        }
    }

    return view('pages.perbandinganAlternative.edit', [
        'values' => $comparisons->sortBy('criteria_id'), // optional: urutkan kriteria
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
