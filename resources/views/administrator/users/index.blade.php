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
            <a class="btn btn-primary" href="{{ url('addusers') }}"><i class="fa  fa-plus" title=""> User baru</i></a>
        </div>
        <div class="box-body">
            <table id="tbluser" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Unit</th>
                    <th>Role</th>
                    <th width="10%">Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;
                    @endphp
                  @foreach($user as $data)
                  @php
                  $no++;
                  @endphp
                  <tr>
                    <td>{{$no}}</td>
                    <td>{{$data->nik}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->namaunit}}</td>
                    <td>{{$data->namarole}}</td>
                    <td align="center">
                      @if($data->status=='1')
                      <a class="btn btn-success" onclick="nonaktifuser({{$data->nik}});"><i class="fa fa-power-off" title="Non aktifkan"></i></a>
                      @else
                      <a class="btn btn-danger" onclick="aktifkanuser({{$data->nik}});"><i class="fa fa-power-off" title="Aktifkan"></i></a>
                      @endif
                  </td>
                  <td><a href="{{url('edituser',['id'=>$data->nik])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{url('destroyuser',['id'=>$data->nik])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>   
    </div>
    <script>
      $(function () {
        $('#tbluser').DataTable()
      })
      function nonaktifuser(id){
        $.ajax({
                url: "{{ url('nonaktifuser') }}/"+id,
                method: 'get',
                success: function (data) {
                    location.reload();
                }
            });
      }
      function aktifkanuser(id){
        $.ajax({
                url: "{{ url('aktifkanuser') }}/"+id,
                method: 'get',
                success: function (data) {
                    location.reload();
                }
            });
      }
    </script>
</section>
@endsection