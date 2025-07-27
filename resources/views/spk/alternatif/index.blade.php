<style>
    .btn{
        padding: 10px!important;
    }
    td{
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
            <h6>Data Alternatif</h6>
        </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <div class="container">
                <table class="table mt-4" style="text-align: center">
                    <thead>
                        <tr>
                            <th width="80px">No</th>
                            <th>Kode Alternatif</th>
                            <th>Nama Karyawan</th>
                            <th width="250px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($alternatif as $alt)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $alt->alternatif }}</td>
                            <td>{{ $alt->karyawan->nama }}</td>
                            <td>
                                <form action="{{ route('alternatif.destroy',$alt->id) }}" method="POST">
                                    <a class="btn btn-warning btn-xs" href="{{ route('alternatif.edit',$alt->id) }}"><ion-icon name="create" style="font-size: 15px;"></ion-icon></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"><ion-icon name="trash-bin" style="font-size: 15px;"></ion-icon></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Data masih kosong..</td>
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
