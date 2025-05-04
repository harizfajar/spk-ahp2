@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Penduduk</h1>
    </div>
    <div class="row">
        <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="/resident/update/{{ $resident->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nik">NIK</label>
                            <input type="text" inputmode="numeric" name="nik" id="nik" class="form-control"
                                value="{{ old('nik', $resident->nik) }}">
                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama', $resident->nama) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kelamin">Jenis Kelamin</label>
                            <select name="kelamin" id="kelamin" class="form-control">
                                <option value="Male" {{ $resident->kelamin == 'Male' ? 'selected' : '' }}>Laki-Laki
                                </option>
                                <option value="Female" {{ $resident->kelamin == 'Female' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="birth_date">Tanggal Lahir</label>
                            <input type="date" name="birth_date" id="birth_date" class="form-control"
                                value="{{ old('birth_date', $resident->birth_date) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="birth_place">Tempat Lahir</label>
                            <input type="text" name="birth_place" id="birth_place" class="form-control"
                                value="{{ old('birth_place', $resident->birth_place) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Nomor Handphone</label>
                            <input type="text" inputmode="numeric" name="phone" id="phone" class="form-control"
                                value="{{ old('phone', $resident->phone) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control">{{ old('alamat', $resident->alamat) }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="agama">Agama</label>
                            <input type="text" name="agama" id="agama" class="form-control"
                                value="{{ old('agama', $resident->agama) }}"">
                        </div>
                        <div class="form-group mb-3">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                                value="{{ old('pekerjaan', $resident->pekerjaan) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="marital_status">Status Perkawinan</label>
                            <select name="marital_status" id="marital_status" class="form-control">
                                <option value="Single" {{ $resident->marital_status == 'Single' ? 'selected' : '' }}>Belum
                                    Menikah</option>
                                <option value="Married" {{ $resident->marital_status == 'Married' ? 'selected' : '' }}>
                                    Menikah</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Status Kependudukan</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Aktif" {{ $resident->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Almarhum" {{ $resident->status == 'Almarhum' ? 'selected' : '' }}>Almarhum
                                </option>
                                <option value="Pindahan" {{ $resident->status == 'Pindahan' ? 'selected' : '' }}>Pindahan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <a href="/resident" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" id="btn-submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script-resident-create')
    <script>
        document.querySelectorAll('#btn-submit').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah form submit langsung
                const form = button.closest('form'); // Mendapatkan form terdekat

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah data yang anda isi sudah benar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika pengguna mengkonfirmasi
                    }
                })
            })
        })
    </script>
@endsection
