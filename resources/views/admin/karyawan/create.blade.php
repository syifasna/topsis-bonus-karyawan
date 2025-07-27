@extends('layouts.aps')

@section('content')
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h4>Tambah Data Karyawan</h4>
        <div class="d-md-flex justify-content-md-end">
            <a class="btn btn-dark btn-sm" href="{{ route('karyawan.index') }}"> Kembali</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2 mt-3">
        <div class="table-responsive p-0">
            <div class="container">
            <form action="{{ route('karyawan.store') }}" method="POST"> @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label"><strong>Nama Lengkap</strong></label>
                    <input 
                        type="text" 
                        name="nama" 
                        class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" 
                        placeholder="Masukan Nama">
                    @error('nama')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="mb-3">
                    <label for="alamat" class="form-label"><strong>Alamat</strong></label>
                    <textarea 
                        class="form-control @error('alamat') is-invalid @enderror" 
                        style="height:150px" 
                        name="alamat" 
                        id="alamat" 
                        placeholder="Masukan Alamat"></textarea>
                    @error('alamat')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tglahir" class="form-label"><strong>Tanggal Lahir</strong></label>
                    <input 
                        type="date" 
                        name="tglahir" 
                        class="form-control @error('tglahir') is-invalid @enderror" 
                        id="tglahir">
                    @error('tglahir')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tglkerja" class="form-label"><strong>Tanggal Kerja</strong></label>
                    <input 
                        type="date" 
                        name="tglkerja" 
                        class="form-control @error('tglkerja') is-invalid @enderror" 
                        id="tglkerja" >
                    @error('tglkerja')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jabatan_id" class="form-label"><strong>Jabatan</strong></label>
                    <select name="jabatan_id" id="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror">
                        @foreach ($jabatan as $row)
                            <option value="{{ $row->id }}">{{ $row->jabatan }}</option>
                        @endforeach
                    </select>
                    @error('jabatan_id')
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
