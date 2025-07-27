@extends('layouts.aps')

@section('content')
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h4>Edit Data Jabatan</h4>
        <div class="d-md-flex justify-content-md-end">
            <a class="btn btn-dark btn-sm" href="{{ route('jabatan.index') }}"> Kembali</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2 mt-3">
        <div class="table-responsive p-0">
            <div class="container">
            <form action="{{ route('jabatan.update',$jabatan->id) }}" method="POST"> 
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="jabatan" class="form-label"><strong>Jabatan</strong></label>
                    <input 
                        type="text" 
                        name="jabatan" 
                        value="{{ $jabatan->jabatan }}"
                        class="form-control @error('jabatan') is-invalid @enderror" 
                        id="jabatan">
                    @error('jabatan')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="mb-3">
                    <label for="gajipokok" class="form-label"><strong>Gaji Pokok (Rp)</strong></label>
                    <input 
                        class="form-control @error('gajipokok') is-invalid @enderror" 
                        type="number" 
                        name="gajipokok" 
                        value="{{ $jabatan->gajipokok }}"
                        id="gajipokok">
                    @error('gajipokok')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Ubah</button>
            </form>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
