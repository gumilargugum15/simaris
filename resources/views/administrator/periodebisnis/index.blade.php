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
            <a class="btn btn-primary" href="{{ url('addperiodbisnis') }}"><i class="fa  fa-plus" title=""> Periode bisnis baru</i></a>
        </div>
        <div class="box-body">
            <table id="tblperiodbisnis" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Startdate</th>
                    <th>Enddate</th>
                    <th>Tahun</th>
                    <th>Aktif</th>
                    <th width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;
                    @endphp
                  @foreach($periodbisnis as $data)
                  @php
                  $no++;
                  @endphp
                  <tr>
                    <td>{{$no}}</td>
                    <td>{{$data->nama}}</td>
                    <td>{{$data->start_date}}</td>
                    <td>{{$data->end_date}}</td>
                    <td>{{$data->tahun}}</td>
                    <td align="center">
                        @if($data->aktif=='1')
                        <a class="btn btn-success"><i class="fa fa-check" title="Aktif"></i></a>
                        @else
                        <a class="btn btn-danger" onclick="aktifperiode({{$data->id}});"><i class="fa fa-minus" title="Tidak Aktif"></i></a>
                        @endif
                    </td>
                    <td><a href="{{url('editperiodbisnis',['id'=>$data->id])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{url('destroyperiodbisnis',['id'=>$data->id])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>   
    </div>
    <script>
      $(function () {
        $('#tblperiodbisnis').DataTable()
      })
      function aktifperiode(id){
        
        $.ajax({
                url: "{{ url('aktifperiode') }}/"+id,
                method: 'get',
                success: function (data) {
                    location.reload();
                }
            });
      }
    </script>
</section>
@endsection