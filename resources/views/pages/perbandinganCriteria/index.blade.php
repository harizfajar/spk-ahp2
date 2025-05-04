@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perbandingan Kriteria</h1>
        <a href="/criteria/create" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Criteria</a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card p-3">
                <h4 class="mt-4">Matriks Perbandingan Kriteria</h4>
                <form action="{{ route('criteria.compare') }}" method="POST" class="form-inline mb-4">
                    @csrf
                    <div class="form-group mx-2">
                        <label for="criteria_id_1" class="mr-2">Kriteria 1</label>
                        <select name="criteria_id_1" class="form-control">
                            @foreach ($comparisons->unique('criteria1') as $item)
                                <option value="{{ $item->criteria1->id }}">{{ $item->criteria1->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-2">
                        <label for="value" class="mr-2">Nilai</label>
                        <select name="value" id="value" class="form-control">
                            @foreach ($nilaiPerbandingan as $nilai => $label)
                                <option value="{{ $nilai }}"> {{ $nilai }} - {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-2">
                        <label for="criteria_id_2" class="mr-2">Kriteria 2</label>
                        <select name="criteria_id_2" class="form-control">
                            @foreach ($comparisons->unique('criteria2') as $item)
                                <option value="{{ $item->criteria2->id }}">{{ $item->criteria2->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary mx-2">Simpan</button>
                </form>

                <table class="table-bordered table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($comparisons->unique('criteria_id_1') as $col)
                                <th>{{ $col->criteria1->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisons->unique('criteria_id_1') as $row)
                            <tr>
                                <th>{{ $row->criteria1->name }}</th>
                                @foreach ($comparisons->unique('criteria_id_2') as $col)
                                    @php
                                        $comparison = $comparisons->first(function ($item) use ($row, $col) {
                                            return $item->criteria_id_1 == $row->criteria_id_1 &&
                                                $item->criteria_id_2 == $col->criteria_id_2;
                                        });

                                        $value = $comparison
                                            ? $comparison->value
                                            : ($row->criteria_id_1 == $col->criteria_id_2
                                                ? 1
                                                : '-');
                                    @endphp


                                    <td>@php
                                        $formatNilai = is_numeric($value)
                                            ? (floor($value) == $value
                                                ? number_format($value)
                                                : number_format($value, 3, ',', '.'))
                                            : $value;
                                    @endphp
                                        {{ $formatNilai }}</td>
                                @endforeach
                            </tr>
                        @endforeach
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
                    text: "Kriteria " + nama + " akan dihapus permanen.",
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
