@extends('layouts.apps')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h4>Tambah Data Kriteria</h4>
                <div class="d-md-flex justify-content-md-end">
                    <a class="btn btn-dark btn-sm" href="{{ route('kriteria.index') }}">Kembali</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2 mt-3">
                <div class="container">

                    <form action="{{ route('kriteria.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nkriteria" class="form-label"><strong>Nama Kriteria</strong></label>
                                <input type="text" name="nkriteria" class="form-control @error('nkriteria') is-invalid @enderror" id="nkriteria">
                                @error('nkriteria')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="atribut" class="form-label"><strong>Atribut</strong></label>
                                <select name="atribut" id="atribut" class="form-control @error('atribut') is-invalid @enderror">
                                    <option value="">-- Pilih Atribut --</option>
                                    <option value="Benefit">Benefit</option>
                                    <option value="Cost">Cost</option>
                                </select>
                                @error('atribut')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bobot" class="form-label"><strong>Bobot</strong></label>
                                <input type="number" step="0.01" name="bobot" class="form-control @error('bobot') is-invalid @enderror" id="bobot">
                                @error('bobot')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror  
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Tambah</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
