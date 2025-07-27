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
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h6>Jenis Gaji</h6>
            <div class="d-md-flex justify-content-md-end">
                <a class="btn btn-success btn-sm" href="{{ route('jenisgaji.create') }}"> 
                    +Jenis Gaji
                </a>
            </div>
        </div>        
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <div class="container">
                <table class="table mt-4" style="text-align: center">
                    <thead>
                        <tr>
                            <th width="80px">No</th>
                            <th>Jenis</th>
                            <th>Tipe</th>
                            <th>Nominal (Rp)</th>
                            <th width="250px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($jenisgaji as $jenis)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $jenis->jenis }}</td>
                            <td>{{ $jenis->tipe }}</td>
                            <td>@currency($jenis->nominal)</td>
                            <td>
                                <form action="{{ route('jenisgaji.destroy',$jenis->id) }}" method="POST">
                                    <a class="btn btn-primary btn-xs" href="{{ route('jenisgaji.edit',$jenis->id) }}"><ion-icon name="create" style="font-size: 15px;"></ion-icon></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"><ion-icon name="trash-bin" style="font-size: 15px;"></ion-icon></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Data masih kosong..</td>
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
