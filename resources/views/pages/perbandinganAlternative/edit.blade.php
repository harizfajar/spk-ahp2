@extends('layouts.app')

@section('content')
    @if ($values->isNotEmpty())
        <h4>Ubah Nilai Bobot Alternatif: <strong>{{ $values->first()->alternative->name }}</strong></h4>

        <div class="row">
            <div class="col">
                <form action="/alternatives-comparisons/update/{{ $values->first()->alternative_id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-body">
                            @foreach ($values as $index => $item)
                                <div class="form-group mb-3">
                                    <label for="value_{{ $item->id }}">
                                        Kriteria: {{ $item->criteria->name ?? 'Kriteria tidak ditemukan' }}
                                    </label>
                                    <input type="hidden" name="comparison_ids[]" value="{{ $item->id }}">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        name="values[]" 
                                        id="value_{{ $item->id }}"
                                        class="form-control @error("values.$index") is-invalid @enderror"
                                        value="{{ old("values.$index", $item->value) }}"
                                        required
                                    >
                                    @error("values.$index")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <a href="/alternatives-comparisons" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Data perbandingan alternatif belum tersedia. Silakan isi data terlebih dahulu.
        </div>
    @endif
@endsection
