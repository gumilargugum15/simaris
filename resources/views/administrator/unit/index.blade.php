@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>
  
</script>
<section class="content-header">
  <h1>
    Data
    <small>{{$judul}}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            @include('layouts.flash')
            <a class="btn btn-primary" href="{{ url('addunit') }}"><i class="fa  fa-plus" title=""> Unit Baru</i></a>
            {{-- <a class="btn btn-success" href="{{ url('updateunit') }}"><i class="fa  fa-refresh" title=""> Update Unit</i></a> --}}
        </div>
        <div class="box-body">
            <table id="tblunit" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Objectabbr</th>
                    <th>Nama</th>
                    <th width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;
                    @endphp
                  @foreach($unit as $data)
                  @php
                  $no++;
                  @endphp
                  <tr>
                    <td>{{$no}}</td>
                    <td>{{$data->kode}}</td>
                    <td>{{$data->objectabbr}}</td>
                    <td>{{$data->nama}}</td>
                    <td><a href="{{url('edit',['id'=>$data->id])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{url('destroyunit',['id'=>$data->id])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>   
    </div>
    <script>
      $(function () {
        $('#tblunit').DataTable()
      })
    </script>
</section>
@endsection