@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>
  function addrisiko(){
    var no=$('#rowsumber').val();
    $('#sumberresikobisnis tbody').append(`
        <tr id="input_${no}">
        <td><textarea class="form-control" rows="2" name="sumberrisiko[]" id="sumberrisiko[]"></textarea></td>
        <td><textarea class="form-control" rows="2" name="mitigasi[]" id="mitigasi[]"></textarea></td>
        <td><input  class="form-control" type="number" name="biaya[]" id="biaya[]"></td>
        <td><input size="5" type="date" class="form-control" id="startdate[]" name="startdate[]" placeholder="yyyy-m-d"></td>
        <td><input size="5" type="date" class="form-control" id="enddate[]" name="enddate[]" placeholder="yyyy-m-d"></td>
        <td><input type="text" class="form-control" name="pic[]" id="pic[]"></td>
        <td><input type="text" class="form-control" name="status[]" id="status[]"></td>
        <td><button type="button" class="btn btn-warning" onclick="hapustempsumber(${no})"><i class="fa fa-trash"></i></button></td>
        </tr>
             `);
             no = (no-1) + 2;
            $('#rowsumber').val(no);
  }
  function hapustempsumber(e){
         if(confirm("Apakah anda yakin ?")){
          $("#input_"+e).remove();
    }}
  
  function pilihdampak(krinama,dampakid,katid,level){
    //alert(dmapakid+'-'+katid+'-'+level+'-'+krinama);
    var peluangid = $("#peluang").val();
    getmatrix(peluangid,dampakid);
    $("#iddampak").val(dampakid);
    $("#dampak").val(krinama);
    $('#modal-dampakrisiko').modal('toggle');
  }
  function getmatrix(peluangid,dampakid){
    $.ajax({
            url:"{{ url('getmatrixrisiko') }}/"+peluangid+"/"+dampakid,
            method: 'GET',
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status+" : "+thrownError);
                $(".loading").hide();
              },
            success: function(data) {
              console.log(data.warna);
              $("#warna").val(data.warna);
              $("#buttonwarna").html('<button type="button" class="btn btn-'+data.warna+' btn-sm">'+data.tingkat+'</button>');
           }
        });
  }
  function validriskbisnis(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('validasibisnis') }}/" + id,
                method: 'get',
                success: function (data) {
                    if (data == 'success') {
                        alert('Validasi berhasil !');
                        location.reload();
                       
                    } else {
                        alert('Validasi gagal !');
                    }

                }
            });
        }
  }
  function batalvalidriskbisnis(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('batalvalidasibisnis') }}/" + id,
                method: 'get',
                success: function (data) {
                    if (data == 'success') {
                        alert('Batal validasi berhasil !');
                        location.reload();
                       
                    } else if(data == 'gagal'){
                        alert('validasi tidak bisa dibatalkan !');
                    }else{
                      alert('Batal Validasi gagal !');
                    }

                }
            });
        }

  }
  
</script>
<section class="content-header">
  <h1>
    Data
    <small>Risiko Proses Bisnis</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  {{-- <div class="callout callout-success"> --}}
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th rowspan="2"><form id="formperiod" method="GET">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-10">
                        <select class="form-control select2" style="width: 100%;" name="periode" id="periode">
                            <option value="">Pilih Periode</option>
                              @foreach ($periodeall as $period)
                              @if(isset($risikobisnis->periode))
                              @if(($period->nama."-".$period->tahun)==($risikobisnis->periode."-".$risikobisnis->tahun)){
                                <option value="{{$period->nama}}-{{$period->tahun}}" selected>{{$period->nama}}/{{$period->tahun}}</option>
                              @else
                              <option value="{{$period->nama}}-{{$period->tahun}}">{{$period->nama}}/{{$period->tahun}}</option>
                              @endif
                              @else
                              <option value="{{$period->nama}}-{{$period->tahun}}">{{$period->nama}}/{{$period->tahun}}</option>
                              @endif
                              @endforeach
                        </select>
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        </div>
                        <div class="col-xs-2">
                            <button type="submit" class="btn btn-primary pull-right">Cari</button>
                        <div>
                      </div>

                  </div>
                  
                  
              </form></th>
            {{-- <th>Periode</th> --}}
            <th>Unit Kerja</th>
            <th>Grup Kriteria</th>
            <th style="width: 100px">Status</th>
            <th style="width: 100px">Aksi</th>
          </tr>
          <tr>
            {{-- <td>
                @if(isset($risikobisnis->periode)){{ $risikobisnis->periode }}@else{{ ' ' }}@endif
               /
               @if(isset($risikobisnis->tahun)){{ $risikobisnis->tahun }}@else{{ ' ' }}@endif
            </td> --}}
            <td>
                @if(isset($unituser->nama)){{ $unituser->nama }}@else{{ ' ' }}@endif
            </td>
            <td>
              @if(isset($namarisiko))
              {{$namarisiko}}
              @endif
             
            </td>
            <td>
              @if(isset($risikobisnis->statusrisiko_id))
              @if($risikobisnis->statusrisiko_id=='0')
              <a href="#"
                class="btn btn-small btn-danger">Belum input risiko...</a>
              @else
              @if(isset($risikobisnis->statusrisiko->nama))
                <a href="#"
                class="btn btn-small btn-success">@if(isset($risikobisnis->statusrisiko->nama)){{ $risikobisnis->statusrisiko->nama }}@else{{ ' ' }}@endif</a>
              @endif
              @endif
              @endif
              
              </td>
            <td>
              @if(isset($risikobisnis->statusrisiko_id))
              @if($risikobisnis->statusrisiko_id=='1')
              <a href="#"
                class="btn btn-small btn-primary" onclick="validriskbisnis({{ $risikobisnis->id }})"><i class="fa fa-check-square"></i> Validasi</a>
              @elseif($risikobisnis->statusrisiko_id=='0')
              <a href="#"
                class="btn btn-small btn-danger">Belum input risiko...</a>
              @elseif($risikobisnis->statusrisiko_id > '2')
              -
              @else
              <a href="#"
              class="btn btn-small btn-warning" onclick="batalvalidriskbisnis({{ $risikobisnis->id }})"><i class="fa fa-undo"></i> Batal validasi</a>
              
              @endif</td>
              @endif
            </tr>

        </table>
      </div>
    </div>
    {{-- </div> --}}
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          {{-- <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-addresiko"><i class="fa  fa-plus"
              title=""> Risiko Baru</i></a> --}}
          @include('layouts.flash')
          <a class="btn btn-primary" href="{{ url('addrisikobisnis') }}"><i class="fa  fa-plus"
                title=""> Risiko Baru</i></a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
              <tr>
                {{-- <th>Periode</th> --}}
                <th>No</th>
                <th>KPI</th>
                <th>Kaidah</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              
                @if(isset($risikobisnis->risikobisnisdetail))
                @php
                $no=0;
                @endphp
                @foreach ($risikobisnis->risikobisnisdetail as $riskdetail)
                @php
                $no++;
                @endphp
              <tr>
                {{-- <td>{{ $risikobisnis->periode." ".$risikobisnis->tahun }}</td> --}}
               <td>{{$no}}</td>
               <td>{{ $riskdetail->kpi->nama }}</td>
               <td align="center">
                  @if($riskdetail->kaidah=='1')
                  <a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a>
                  @else
                  <a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a>
                  @endif
              </td>
                
                <td>{{ $riskdetail->risiko }}</td>
                <td>{{ $riskdetail->peluang->nama }}</td>
                <td>{{ $riskdetail->dampak->nama }}</td>
                <td><button type="button" class="btn btn-{{ $riskdetail->warna }} btn-sm"></button></td>
                <td><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-sumberresikobisnis"
                    onclick="sumberrisiko({{ $riskdetail->id }})"><i class="fa fa-reorder (alias)" title="List sumber risiko"></i></a>
                </td>
                <td>{{ $riskdetail->indikator }}</td>
                <td>{{ $riskdetail->nilaiambang }}</td>
              <td><a href="{{url('edit')}}" class="btn btn-small"><i class="fa fa-edit"></i> Edit</a>
                <a href="{{url('destroy')}}" class="btn btn-small"><i class="fa fa-trash"></i> Hapus</a>
              </td>
              </tr>
              @endforeach
                @endif
              
            </tbody>
           
            
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  @include('resiko/resikobisnis/modal/sumberresikobisnis')
  @include('resiko/resikobisnis/modal/addrisiko')
</section>
@endsection