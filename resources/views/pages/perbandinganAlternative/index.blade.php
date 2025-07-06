@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perbandingan Alternatif per Kriteria</h1>
        <a href="/alternatives/create" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Alternatif
        </a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card p-3">
                <table class="table-bordered w-100 mx-auto table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Laptop</th>
                            <th>Spesifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($values->unique('alternative_id') as $item)
                            <tr>
                                <td> {{ $item->alternative->name }} </td>
                                <td> {{ $item->alternative->description }} </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <table class="table-bordered table-striped mt-4 table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Alternatif</th>
                            @foreach ($criterias as $criteria)
                                <th>{{ $criteria->name }}</th>
                            @endforeach
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($values->groupBy('alternative_id') as $item)
                            <tr>
                                <td>{{ 'A' . $item->first()->alternative->id }}</td>
                                <td>{{ $item->first()->alternative->name }}</td>
                                @foreach ($criterias as $criteria)
                                    @php
                                        $comparison = $item->firstWhere('criteria_id', $criteria->id);
                                        $value = $comparison?->value ?? '-';
                                    @endphp
                                    <td>{{ is_numeric($value) ? number_format($value) : $value }}</td>
                                @endforeach
                                <td>
                                    <div class="d-flex">
                                        <a href="/alternatives-comparisons/edit/{{ $item->first()->alternative_id }}"
                                            class="btn btn-sm btn-warning mr-2"><i class="fas fa-pen"></i></a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
