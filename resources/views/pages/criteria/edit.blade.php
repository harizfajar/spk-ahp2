@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Alternatif</h1>
    </div>
    <div class="row">
        <div class="col">

            <form action="/criteria/update/{{ $criteria->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Laptop</label>
                            <input type="text" inputmode="numeric" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $criteria->name) }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="atribut">atribut</label>
                            <select name="atribut" id="atribut"
                                class="form-control @error('atribut') is-invalid @enderror">
                                <option value="Cost" {{ old('atribut', $criteria->atribut) == 'Cost' ? 'selected' : '' }}>
                                    Cost</option>
                                <option value="Benefit"
                                    {{ old('atribut', $criteria->atribut) == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                            </select>

                            @error('atribut')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <a href="/criteria" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>
                                    Kembali</a>
                                <button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
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
