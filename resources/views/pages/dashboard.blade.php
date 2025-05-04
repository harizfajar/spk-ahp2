@extends('layouts.app')
@section('content')
    <h3>Laptop Terbaik</h3>
    <div class="card mt-4 p-4">
        <table class="table-bordered w-75 mx-auto table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Peringkat</th>
                    <th>Laptop</th>
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
