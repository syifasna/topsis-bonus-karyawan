@extends('layouts.aps')

@section('content')
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h4>Ubah Absensi Karyawan</h4>
            <div class="d-md-flex justify-content-md-end">
                <a class="btn btn-dark btn-sm" href="{{ route('absensi.index') }}"> Kembali</a>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2 mt-3">
            <div class="table-responsive p-0">
                <div class="container">
                    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <input type="month" name="tahun_bulan" class="form-control @error('tahun_bulan') is-invalid @enderror" id="tahun_bulan" value="{{ $absensi->bulan }}" hidden>
                        
                        <div class="mb-3">
                            <label for="karyawan_id" class="form-label"><strong>Nama Lengkap</strong></label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror">
                                @foreach ($karyawan as $row)
                                    <option value="{{ $row->id }}" {{ (isset($absensi) && $absensi->karyawan_id == $row->id) ? 'selected' : '' }}>
                                        {{ $row->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <label for="masuk" class="form-label"><strong>Masuk</strong></label>
                            <input 
                                type="number" 
                                name="masuk" 
                                class="form-control @error('masuk') is-invalid @enderror" 
                                id="masuk" 
                                value="{{ $absensi->masuk }}">
                            @error('masuk')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="izin" class="form-label"><strong>Izin</strong></label>
                            <input 
                                type="number" 
                                name="izin" 
                                class="form-control @error('izin') is-invalid @enderror" 
                                id="izin" 
                                value="{{ $absensi->izin }}">
                            @error('izin')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sakit" class="form-label"><strong>Sakit</strong></label>
                            <input 
                                type="number" 
                                name="sakit" 
                                class="form-control @error('sakit') is-invalid @enderror" 
                                id="sakit" 
                                value="{{ $absensi->sakit }}">
                            @error('sakit')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
