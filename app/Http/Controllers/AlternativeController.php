<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\AlternativeComparisons;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AlternativeController extends Controller
{
    public function index() {
        $alternatives= Alternative::all();
        return view('pages.alternative.index',['alternatives'=>$alternatives]);
    }
    public function create(){
        return view('pages.alternative.create');
    }

public function store(Request $request){
    $validated = $request->validate([
        'name' => 'required|string|max:100|unique:alternatives,name',
        'description' => 'required|string',
    ],[
        'name.required' => 'Nama alternatif wajib diisi.',
        'name.unique' => 'Nama alternatif sudah terdaftar.',
        'name.max' => 'Nama alternatif tidak boleh lebih dari 100 karakter.',
        'description.required' => 'Deskripsi alternatif wajib diisi.',
    ]);

    // Simpan alternative
    $alternative = Alternative::create($validated);

    // Ambil semua kriteria dan buat nilai default = 1 (bisa diganti dengan nilai default lain)
    $criterias = Criteria::all();
    foreach ($criterias as $criteria) {
        AlternativeComparisons::create([
            'alternative_id' => $alternative->id,
            'criteria_id' => $criteria->id,
            'value' => 1
        ]);
    }

    return redirect('/alternatives')->with('success', 'Data berhasil ditambahkan');
}


    public function edit($id) {
        $alternative = Alternative::findOrFail($id);
        return view('pages.alternative.edit', [
            'alternative' => $alternative
        ]);
    }
    public function update(Request $request,$id){
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:alternatives,name,' . $id,
            'description' => 'required|string' 
        ],[
            'name.required' => 'Nama alternatif wajib diisi.',
            'name.unique' => 'Nama alternatif sudah terdaftar.',
            'name.max' => 'Nama alternatif tidak boleh lebih dari 100 karakter.',
            'description.required' => 'Deskripsi alternatif wajib diisi.',
        ]);
        Alternative::findOrFail($id)->update($validated);
        return redirect('/alternatives')->with('success', 'Data berhasil diubah');
    }

    public function delete($id) {
        $alternative = Alternative::findOrFail($id);
        $alternative->delete();
        return redirect('/alternatives')->with('success', 'Data berhasil dihapus');
    }
}
