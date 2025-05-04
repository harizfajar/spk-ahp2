<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\CriteriaComparisons;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index() {
        $criteria = Criteria::all();
        return view('pages.criteria.index', [
            'criterias' => $criteria,
        ]);
    }
    public function create() {
        return view('pages.criteria.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'atribut' => 'required|in:Cost,Benefit',
    ], [
        'name.required' => 'Nama Kriteria tidak boleh kosong',
        'name.max' => 'Nama Kriteria tidak boleh lebih dari 255 karakter',
        'atribut.required' => 'Atribut Kriteria harus dipilih',
    ]);


    // Simpan kriteria baru
    $newCriteria = Criteria::create($validated);

    // Ambil semua kriteria (termasuk yang baru)
    $allCriteria = Criteria::all();

    // Buat perbandingan nilai default 1
    foreach ($allCriteria as $existing) {
        CriteriaComparisons::create([
            'criteria_id_1' => $newCriteria->id,
            'criteria_id_2' => $existing->id,
            'value' => 1,
        ]);

        // Hindari duplikat jika perbandingan sebaliknya belum ada
        if ($newCriteria->id != $existing->id) {
            CriteriaComparisons::create([
                'criteria_id_1' => $existing->id,
                'criteria_id_2' => $newCriteria->id,
                'value' => 1,
            ]);
        }
    }

    return redirect('/criteria')->with('success', 'Kriteria berhasil ditambahkan beserta perbandingannya.');
}

    public function edit($id){
        $criteria = Criteria::findOrFail($id);
        return view('pages.criteria.edit', [
            'criteria' => $criteria
        ]);
    }
    public function update(Request $request, $id){
            // dd($request->all()); // Cek apakah atribut terkirim

        $validated = $request->validate([   
        'name' => 'required|string|max:255' ,
        'atribut' => 'required|in:Cost,Benefit',
        
        ],[
        'name.required' => 'Nama Kriteria tidak boleh kosong',
        'name.max' => 'Nama Kriteria tidak boleh lebih dari 255 karakter',
        'atribut.required' => 'Atribut Kriteria harus dipilih',
        ]);
        Criteria::findOrFail($id)->update($validated);
        return redirect('/criteria')->with('success', 'Kriteria berhasil diubah');
    }
    public function delete($id){
        $criteria = Criteria::findOrFail($id);
        $criteria->delete();
        return redirect('/criteria')->with('success', 'Kriteria berhasil dihapus');
    }
}
