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
                        @elseif($data->aktif=='2')
                        <a class="btn btn-default"><i class="fa fa-power-off" title="Tidak aktif"></i></a>
                        @else
                        <a id="loading" class="btn btn-info" style="display:none;">Sedang memproses...</a>
                        <a id="btninaktif" class="btn btn-danger" onclick="aktifperiode({{$data->id}});"><i class="fa fa-minus" title="Tidak Aktif"></i></a>
                        @endif
                    </td>
                    <td><a href="{{url('editperiodbisnis',['id'=>$data->id])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                      @if($data->aktif!=1)
                        <a href="{{url('destroyperiodbisnis',['id'=>$data->id])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a>
                        @endif
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
        if (confirm("Proses ini akan menduplikasi data sebelumnya ke periode aktif saat ini, apakah anda yakin  ?") == true) {
        $.ajax({
                url: "{{ url('aktifperiode') }}/"+id,
                method: 'get',
                beforeSend: function() {
                $("#loading").show();
                $("#btninaktif").hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status+" : "+thrownError);
                $("#loading").hide();
              },
                success: function (data) {
                    location.reload();
                    $("#loading").hide();
                }
            });
        }
      }
    </script>
</section>
@endsection