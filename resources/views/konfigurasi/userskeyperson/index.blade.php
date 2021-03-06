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
            {{-- <a class="btn btn-primary" href="{{ url('addusers') }}"><i class="fa  fa-plus" title=""> User baru</i></a> --}}
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
                    <th width="10%">Aksi</th>
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
                    <td align="center">
                      @if($data->status=='1')
                      <a class="btn btn-success" onclick="tutupotorisasi({{$data->nik}});"><i class="fa fa-power-off" title="Tutup otorisasi"></i></a>
                      @else
                      <a class="btn btn-danger" onclick="bukaotorisasi({{$data->nik}});"><i class="fa fa-power-off" title="Buka otorisasi"></i></a>
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
        $('#tbluser').DataTable()
      })
      function bukaotorisasi(nik){ 
        
        $.ajax({
                url: "{{ url('bukaotorisasi') }}/"+nik,
                method: 'get',
                success: function (data) {
                    location.reload();
                }
            });
      }
      function tutupotorisasi(nik){ 
        
        $.ajax({
                url: "{{ url('tutupotorisasi') }}/"+nik,
                method: 'get',
                success: function (data) {
                    location.reload();
                }
            });
      }
    </script>
</section>
@endsection