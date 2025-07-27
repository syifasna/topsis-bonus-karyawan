<style>
    .btn{
        padding: 10px!important;
    }
    td{
        font-size: 14px;
    }
</style>

@extends('layouts.aps')

@section('content')
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h6>Masukan Periode Gaji</h6>
        </div>
        
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <div class="container">
                    <form action="{{ route('gaji.index') }}" method="GET">
                        @csrf
                        <table class="table mt-4" style="text-align: center">
                            <thead>
                                <tr>
                                    <th>Periode (Bulan - Tahun)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input 
                                            type="month" 
                                            id="tahun_bulan" 
                                            name="tahun_bulan" 
                                            class="form-control"
                                            value="{{ $tahun_bulan ?? old('tahun_bulan') }}"
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h6>Data Gaji</h6>
        </div>
        
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <div class="container">
                    <table class="table mt-4" style="text-align: center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Gaji</th>
                                <th>Penghasilan</th>
                                <th>Potongan</th>
                                <th>Total Diterima</th>
                                <th width="250px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($gaji as $gj)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $gj->karyawan->nama }}</td>
                                <td>@currency($gj->gajipokok)</td>
                                <td>@currency($gj->totalHasil)</td>
                                <td>@currency($gj->totalPot)</td>
                                <td>@currency($gj->total)</td>
                                <td>
                                    <form action="{{ route('gaji.destroy', $gj->id) }}" method="POST">
                                        <a class="btn btn-primary btn-xs" href="{{ route('gaji.edit', $gj->id) }}">
                                            <ion-icon name="create" style="font-size: 15px;"></ion-icon>
                                        </a>
                                        <a class="btn btn-dark btn-xs" target="_blank" href="{{ route('admin.gaji.slipgaji', $gj->id) }}">
                                            <ion-icon name="print-outline" style="font-size: 15px;"></ion-icon>
                                        </a>                                                                              
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <ion-icon name="trash-bin" style="font-size: 15px;"></ion-icon>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Data masih kosong..</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
