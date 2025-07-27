@extends('layouts.apps')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h4>Detail Data Alternatif</h4>
                <div class="d-md-flex justify-content-md-end">
                    <a class="btn btn-dark btn-sm" href="{{ route('alternatif.index') }}">Kembali</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2 mt-3">
                <div class="container">

                    <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alternatif" class="form-label"><strong>Alternatif</strong></label>
                                <input type="text" name="alternatif"
                                    class="form-control @error('alternatif') is-invalid @enderror" id="alternatif"
                                    value="{{ $alternatif->alternatif }}">
                                @error('alternatif')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                            <div class="col-md-6 mt-4">
                                <button type="button" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
