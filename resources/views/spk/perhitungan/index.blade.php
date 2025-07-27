<style>
    .btn {
        padding: 10px !important;
    }

    td {
        font-size: 14px;
    }
</style>

@extends('layouts.apps')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            @session('success')
                <div class="alert alert-success" role="alert"> {{ $value }} </div>
            @endsession
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Input Alternatif</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <div class="container">
                        <form action="{{ route('perhitungan.store') }}" method="POST">
                            @csrf
                            <table class="table mt-4" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>
                                        <th>Nama Karyawan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatifs as $alternatif)
                                        @php
                                            $sudahAda = $perhitungan->where('alternatif_id', $alternatif->id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $alternatif->alternatif }}</td>
                                            <td>{{ $alternatif->karyawan->nama }}</td>
                                            <td>
                                                @if ($sudahAda)
                                                    <a class="btn btn-warning btn-xs"
                                                        href="{{ route('perhitungan.nilai', $sudahAda->id) }}">
                                                        <ion-icon name="create" style="font-size: 15px;"></ion-icon>
                                                    </a>
                                                @else
                                                    <form action="{{ route('perhitungan.store') }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="karyawan_id"
                                                            value="{{ $alternatif->karyawan_id }}">
                                                        <input type="hidden" name="alternatif_id"
                                                            value="{{ $alternatif->id }}">
                                                        <button class="btn btn-success btn-xs" type="submit">
                                                            <ion-icon name="add-circle" style="font-size: 15px;"></ion-icon>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-success">Simpan Semua</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kriteria-col {
            width: 100px;
        }

        .kriteria-col input {
            width: 80px;
            margin: 0 auto;
        }
    </style>

@endsection
