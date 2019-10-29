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
            <a class="btn btn-primary" href="{{ url('addproject') }}"><i class="fa  fa-plus" title=""> {{$judul}} Baru</i></a>
           
        </div>
        <div class="box-body">
            <table id="tblproject" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama project</th>
                    <th>Unit kerja</th>
                    <th>Keyperson</th>
                    <th>Project Manajer</th>
                    <th>Tujuan</th>
                    <th>Nomor(nama kontrak)</th>
                    <th>Startdate/Enddate</th>
                    <th>Status</th>
                    <th width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;
                    @endphp
                  @foreach($project as $data)
                  @php
                  $no++;
                  @endphp
                  <tr>
                    <td>{{$no}}</td>
                    <td>{{$data->nama}}</td>
                    <td>{{$data->namaunit}}</td>
                    <td>{{$data->namakeyperson}} ( {{$data->keyperson}} )</td>
                    <td>{{$data->namapm}} ( {{$data->pm}} )</td>
                    <td>{{$data->tujuan}}</td>
                    <td>{{$data->nomorkontrak}} ( {{$data->namakontrak}} )</td>
                    <td>{{$data->start_date}} / {{$data->end_date}}</td>
                    <td>{{$data->statusproject}}</td>
                    <td><a href="{{url('editproject',['id'=>$data->id])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{url('destroyproject',['id'=>$data->id])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>   
    </div>
    <script>
      $(function () {
        $('#tblproject').DataTable()
      })
    </script>
</section>
@endsection