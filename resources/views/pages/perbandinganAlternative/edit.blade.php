@extends('layouts.app')
@section('content')
    @if ($values->isNotEmpty())
        <h4>Ubah Nilai Bobot Alternatif {{ $values->first()->alternative->name }}</h4>

        <div class="row">
            <div class="col">
                <form action="/alternatives-comparisons/update/{{ $values->first()->alternative_id }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-body">
                            @foreach ($values as $item)
                                <div class="form-group mb-3">
                                    <label for="value_{{ $item->criteria_id }}">
                                        Kriteria: {{ $item->criteria->name }}
                                    </label>
                                    <input type="hidden" name="comparison_ids[]" value="{{ $item->id }}">
                                    <input type="number" step="1" name="values[]" id="value_{{ $item->criteria_id }}"
                                        class="form-control" value="{{ old('values.' . $loop->index, $item->value) }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <a href="/alternatives-comparisons" class="btn btn-secondary mr-2">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p>Data perbandingan alternatif belum tersedia.</p>
    @endif
@endsection
