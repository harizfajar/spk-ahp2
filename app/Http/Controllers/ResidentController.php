<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
class ResidentController extends Controller
{
    public function index(){
        $residents = Resident::all();

        return view('pages.resident.index',[
            'residents' => $residents
        ]);
    }

    public function create() {
        return view('pages.resident.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nik' => 'required|unique:residents,nik|string|digits_between:0,16',
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|in:Male,Female',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'alamat' => 'required|string',
            'agama' => 'nullable|string|max:50',
            'marital_status' => 'required|in:Married,Single',
            'pekerjaan' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20|unique:residents,phone',
            'status' => 'required|in:Pindahan,Almarhum,Aktif',
        ],[
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits_between' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'kelamin.required' => 'Jenis Kelamin wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'marital_status.required' => 'Status pernikahan wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'status.required' => 'Status wajib diisi.',
            'nik.max' => 'NIK tidak boleh lebih dari 16 karakter.',
            'nama.max' => 'Nama tidak boleh lebih dari 100 karakter.',
            
        ]
        );
        Resident::create($validated);
        return redirect('/resident')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id){
        $resident = Resident::findOrFail($id);
        return view('pages.resident.edit', [
            'resident' => $resident
        ]);
    }

    public function update (Request $request, $id){
         $validated = $request->validate([
            'nik' => 'required|string|digits_between:0,16|unique:residents,nik,' . $id,
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|in:Male,Female',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'alamat' => 'required|string',
            'agama' => 'nullable|string|max:50',
            'marital_status' => 'required|in:Married,Single',
            'pekerjaan' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20|unique:residents,phone,' . $id,
            'status' => 'required|in:Pindahan,Almarhum,Aktif',
        ],[
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'nik.digits_between' => 'NIK harus terdiri dari 16 digit.',
            'nama.required' => 'Nama wajib diisi.',
            'kelamin.required' => 'Jenis Kelamin wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'marital_status.required' => 'Status pernikahan wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor Telepon ini sudah terdaftar.',
            'status.required' => 'Status wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 100 karakter.',
            
        ]);

        Resident::findOrFail($id)->update($validated);
        return redirect('/resident')->with('success', 'Data berhasil diubah');
    }
    public function delete($id){
        $resident = Resident::findOrFail($id);
        $resident->delete();
        return redirect('/resident')->with('success', 'Data berhasil dihapus');
    }
}
