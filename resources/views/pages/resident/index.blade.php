@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penduduk</h1>
        <a href="/resident/create" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Penduduk</a>
    </div>

    <!-- table -->
    <div class="row">
        <div class="col">
            <div class="card p-3">
                <table class="table-bordered table-hover table-responsive table">
                    <thead class="thead-dark">
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tampat Tanggal Lahir</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Agama</th>
                            <th>Pekerjaan</th>
                            <th>Status Perkawinan</th>
                            <th>Status Penduduk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($residents as $resident)
                            <tr>
                                <td> {{ $resident->nik }} </td>
                                <td> {{ $resident->nama }} </td>
                                <td> {{ $resident->kelamin == 'Male' ? 'Laki-Laki' : 'Perempuan' }} </td>
                                <td> {{ $resident->birth_place }}, {{ $resident->birth_date }} </td>
                                <td> {{ $resident->phone }} </td>
                                <td> {{ $resident->alamat }} </td>
                                <td> {{ $resident->agama }} </td>
                                <td> {{ $resident->pekerjaan }} </td>
                                <td> {{ $resident->marital_status == 'Single' ? 'Belum Menikah' : 'Menikah' }} </td>
                                <td> {{ $resident->status }} </td>
                                <td>
                                    <!-- Contoh tombol aksi -->
                                    <div class="d-flex">
                                        <a href="/resident/edit/{{ $resident->id }}" class="btn btn-sm btn-warning mr-2"><i
                                                class="fas fa-pen"></i></a>
                                        <form class="form-delete" data-nama="{{ $resident->nama }}"
                                            action="/resident/{{ $resident->id }}/delete" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" id="btn-delete" class="btn btn-sm btn-danger btn-delete">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Data penduduk belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script-resident-index')
    <script>
        document.querySelectorAll('#btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah form submit langsung
                const form = this.closest('form');
                const nama = form.getAttribute('data-nama'); // Ambil nama dari atribut data-nama pada form

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data penduduk atas nama " + nama + " akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form setelah konfirmasi
                    }
                });
            });
        });
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
@endsection
