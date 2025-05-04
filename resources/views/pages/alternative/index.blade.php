@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Alternative</h1>
        <a href="/alternatives/create" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Alternative</a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card p-3">
                <table class="table-bordered w-100 mx-auto table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Laptop</th>
                            <th>Spesifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alternatives as $alternativ)
                            <tr>
                                <td> {{ $alternativ->name }} </td>
                                <td> {{ $alternativ->description }} </td>

                                <td>
                                    <!-- Contoh tombol aksi -->
                                    <div class="d-flex">
                                        <a href="/alternatives/edit/{{ $alternativ->id }}"
                                            class="btn btn-sm btn-warning mr-2"><i class="fas fa-pen"></i></a>
                                        <form class="form-delete" data-nama="{{ $alternativ->name }}"
                                            action="/alternatives/delete/{{ $alternativ->id }}" method="POST">
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
                    text: "Alternatif " + nama + " akan dihapus permanen.",
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
