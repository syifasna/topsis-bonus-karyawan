@extends('layouts.aps')

@section('content')
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h4>Tambah Jenis Gaji</h4>
        <div class="d-md-flex justify-content-md-end">
            <a class="btn btn-dark btn-sm" href="{{ route('jenisgaji.index') }}"> Kembali</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2 mt-3">
        <div class="table-responsive p-0">
            <div class="container">
            <form action="{{ route('jenisgaji.store') }}" method="POST"> @csrf
                <div class="mb-3">
                    <label for="jenis" class="form-label"><strong>Jenis</strong></label>
                    <input 
                        type="text" 
                        name="jenis" 
                        class="form-control @error('jenis') is-invalid @enderror" 
                        id="jenis" 
                        placeholder="Komisi Tiktok">
                    @error('jenis')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipe" class="form-label"><strong>Tipe</strong></label>
                    <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror">
                        <option value="" disabled>Pilih Tipe Gaji</option>
                        <option value="Potongan">Potongan</option>
                        <option value="Penghasilan">Penghasilan</option>
                    </select>
                    @error('tipe')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="mb-3">
                    <label for="nominal" class="form-label"><strong>Nominal (Rp)</strong></label>
                    <input 
                        class="form-control @error('nominal') is-invalid @enderror" 
                        type="number" 
                        name="nominal" 
                        id="nominal" 
                        placeholder="500.000">
                    @error('nominal')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Tambah</button>
            </form>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
