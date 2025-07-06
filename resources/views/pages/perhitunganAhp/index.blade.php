@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Perhitungan AHP</h4>

    <div class="card p-4">
        <h5>Matriks Perbandingan</h5>
        <table class="table-bordered table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Kriteria</th>
                    @foreach ($criterias as $col)
                        <th>{{ $col->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($matrix as $i => $row)
                    <tr>
                        <th>{{ $criterias[$i]->name }}</th>
                        @foreach ($row as $value)
                            <td>@php
                                $formatNilai = is_numeric($value)
                                    ? (floor($value) == $value
                                        ? number_format($value, 0, ',', '.') // angka bulat tanpa desimal
                                        : number_format($value, 3, ',', '.')) // angka pecahan dengan 3 desimal
                                    : $value;
                            @endphp
                                {{ $formatNilai }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-4 p-4">
        <h5>Matriks Ternormalisasi</h5>
        <table class="table-bordered table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Kriteria</th>
                    @foreach ($criterias as $col)
                        <th>{{ $col->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($normalizedMatrix as $i => $row)
                    <tr>
                        <th>{{ $criterias[$i]->name }}</th>
                        @foreach ($row as $value)
                            <td>{{ number_format($value, 3, ',', '.') }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-4 p-4">
        <h5>Bobot Prioritas (Priority Vector)</h5>
        <table class="table-bordered w-50 mx-auto table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Kriteria</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($priorityVector as $i => $value)
                    <tr>
                        <td>{{ $criterias[$i]->name }}</td>
                        <td>{{ number_format($value, 3, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-4 p-4">
        <h5>Rangkuman Konsistensi</h5>
        <table class="table-bordered w-50 mx-auto table">
            <tr>
                <th>λ Max</th>
                <td>{{ number_format($lambdaMax, 3, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Consistency Index (CI)</th>
                <td>{{ number_format($CI, 3, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Consistency Ratio (CR)</th>
                <td>{{ number_format($CR, 3, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status Konsistensi</th>
                <td>
                    @if ($isConsistent)
                        <span class="text-success font-weight-bold">Konsisten</span>
                    @else
                        <span class="text-danger font-weight-bold">Tidak Konsisten</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="card mt-4 p-4">
        <h5>Normalisasi Alternatif</h5>
        <table class="table-bordered w-75 mx-auto table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Alternatif</th>
                    @foreach ($criterias as $criteria)
                        <th>{{ $criteria->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($normalizedAlternatives as $altId => $criteriaValues)
                    <tr>
                        <th>{{ $alternatifMap[$altId]->name ?? 'A' . $altId }}</th>
                        @foreach ($criterias as $criteria)
                            <td>
                                {{ isset($criteriaValues[$criteria->id])
                                    ? number_format($criteriaValues[$criteria->id], 4, ',', '.')
                                    : '0,0000' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card mt-4 p-4">
        <h5>Ranking Alternatif</h5>
        <table class="table-bordered w-75 mx-auto table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Alternatif</th>
                    <th>Deskripsi</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alternativeScores as $index => $alt)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $alt['name'] }}</td>
                        <td>{{ $alt['deskripsi'] }}</td>
                        <td>{{ number_format($alt['score'], 4, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
