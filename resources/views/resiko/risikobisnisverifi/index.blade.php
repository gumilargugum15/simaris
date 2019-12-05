@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>

function sesuaikaidah(){  
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('sesuaikaidah') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });
    }
    function tidaksesuaikaidah(){
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('tidaksesuaikaidah') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });
    }
function validriskbisnisverif(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('validasibisnisverif') }}/" + id,
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
                url: "{{ url('batalvalidasibisnisverif') }}/" + id,
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
  function highlight(){
    if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('highlight') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
  }
  function kri(){
    if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('kri') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
  }
  function batalkri(){
    if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('batalkri') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
  }
  function rkap(){
    if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('rkap') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
  }
  function batalrkap(){
    if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('batalrkap') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
  }
  function batalhighlight(){
    if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-kaidah').serialize();
        $.ajax({
                url: "{{ url('batalhighlight') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
  }
  function notifkomen(id){
      alert(id);
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
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Periode aktif : <b>{{$periodeaktif->nama." ".$periodeaktif->tahun}}</b> dari tanggal : <b>{{$periodeaktif->start_date}}</b> sampai tanggal <b>{{$periodeaktif->end_date}}</b>
              </div>    
            <table class="table table-bordered">
                <tr>
                    <th>Periode</th>
                    {{-- <th>Periode</th> --}}
                    <th>Unit Kerja</th>
                    <th>Grup Kriteria</th>
                    <th style="width: 100px">Status</th>
                    <th style="width: 100px">Aksi</th>
                </tr>
                <tr>
                    <td>
                        <form id="formcari" method="GET">
                        <input type="hidden" id="nikuser" value="{{$nikuser}}">
                        
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-10">
                                        <select class="form-control select2" style="width: 100%;" name="periode"
                                            id="periode" required>
                                            <option value="">Pilih Periode</option>
                                            @foreach ($periodeall as $period)
                                            @if(isset($risikobisnis->periode))
                                            {{-- @if(($period->nama."-".$period->tahun)==($risikobisnis->periode."-".$risikobisnis->tahun)){ --}}
                                            @if(($period->id)==($risikobisnis->perioderisikobisnis_id)){
                                            {{-- <option value="{{$period->nama}}-{{$period->tahun}}" selected> --}}
                                                {{-- {{$period->nama}}/{{$period->tahun}}</option> --}}
                                                <option value="{{$period->id}}" selected>{{$period->nama}}/{{$period->tahun}}</option>
                                            @else
                                            {{-- <option value="{{$period->nama}}-{{$period->tahun}}">
                                                {{$period->nama}}/{{$period->tahun}}</option> --}}
                                            <option value="{{$period->id}}">{{$period->nama}}/{{$period->tahun}}</option>
                                            @endif
                                            @else
                                            {{-- <option value="{{$period->nama}}-{{$period->tahun}}">
                                                {{$period->nama}}/{{$period->tahun}}</option> --}}

                                            <option value="{{$period->id}}">{{$period->nama}}/{{$period->tahun}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                    </div>
                                </div>
                            </div>


                    </td>
                    <td>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-10">
                                    <select class="form-control select2" style="width: 100%;" name="unitkerja"
                                        id="unitkerja" required>
                                        <option value="">Pilih Unit</option>
                                        
                                        @foreach($unitkerja as $runit)
                                        @if(isset($risikobisnis))
                                        @if($risikobisnis->unit_id==$runit->objectabbr)
                                        <option value="{{$runit->objectabbr}}" selected>{{$runit->nama}}</option>
                                        @else
                                        <option value="{{$runit->objectabbr}}">{{$runit->nama}}</option>
                                        @endif
                                        @else
                                        <option value="{{$runit->objectabbr}}">{{$runit->nama}}</option>
                                        @endif
                                        @endforeach
                                       
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                        <button type="submit" class="btn btn-primary pull-right">Cari</button>
                                    <div>
                            </div>
                        </div>
                        </form>
                    </td>
                    <td>
                        @if(isset($namarisiko))
                        {{$namarisiko}}
                        @endif

                    </td>
                    <td>
                        @if(isset($risikobisnis->statusrisiko->nama))
                        <a href="#"
                            class="btn btn-small btn-success">@if(isset($risikobisnis->statusrisiko->nama)){{ $risikobisnis->statusrisiko->nama }}@else{{ ' ' }}@endif</a>
                        @endif
                    </td>
                    <td>
                        @if(isset($risikobisnis->statusrisiko_id))
                        @if($risikobisnis->statusrisiko_id=='2')
                        <a href="#" class="btn btn-small btn-primary"
                            onclick="validriskbisnisverif({{ $risikobisnis->id }})"><i class="fa fa-check-square"></i>
                            Validasi</a>
                        @elseif($risikobisnis->statusrisiko_id > '3'||$risikobisnis->statusrisiko_id < '2')
                        -
                        @else<a href="#" class="btn btn-small btn-warning"
                            onclick="batalvalidriskbisnis({{ $risikobisnis->id }})"><i class="fa fa-undo"></i> Batal
                            validasi</a>
                        @endif
                        @endif</td>
                </tr>

            </table>
        </div>
    </div>
    {{-- </div> --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                        <table class="table table-bordered table-striped">
                                <tr align="center"><th>Total KPI</th><th>Sudah diinput</th><th>Belum diinput</th></tr>
                                <tr align="center"><td><a class="btn btn-primary" href="#">@if(isset($jmlkpiall)){{$jmlkpiall}}@endif</a></td>
                                  <td><a class="btn btn-success" href="#">@if(isset($jmlkpisudahinput)){{$jmlkpisudahinput}}@endif</a></td>
                                  <td><a class="btn btn-warning" href="#">@if(isset($jmlkpinull)){{$jmlkpinull}}@endif</a></td>
                                </tr>
                              </table>
                    <a class="btn btn-success" onclick="reload()"><i class="fa  fa-refresh" title=""> Refresh</i></a>
                    {{-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(@if(isset($risikobisnis->id)){{$risikobisnis->id}}@endif)"><i class="fa fa-commenting-o" title="Komentar"> Komentar</i></a> --}}
                </div>
                
                <div class="box-body">
                    <form id="fm-kaidah">
                            <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <table id="tblresikobisnis" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="2%"></th> 
                                <th width="2%">No</th>  
                                <th>KPI</th>
                                {{-- <th>Utama</th>
                                <th>Jenis</th> --}}
                                <th>Kelompok</th>
                                <th width="10%">Kaidah</th>
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
                            @if($riskdetail->delete!='1')
                            <tr>
                                <td>
                                    @if($periodeaktif->id==$riskdetail->perioderisikobisnis_id)
                                    <input type="checkbox" name="kaidah[]" class="form-controll" value="{{$riskdetail->id}}"></td>
                                    @endif
                                    <td>{{$no}}</td>
                                {{-- <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->kpi->nama }}</p>@else{{ $riskdetail->kpi->nama }}@endif</td> --}}
                                <td><b>@if($riskdetail->kpi->level=='2')<p class="text-red">{{ $riskdetail->kpi->nama }}</p>@elseif($riskdetail->kpi->level=='1')<p class="text-yellow">{{ $riskdetail->kpi->nama }}</p>@else{{ $riskdetail->kpi->nama }}@endif</b></td>
                                {{-- <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->kpi->utama }}</p>@else{{ $riskdetail->kpi->utama }}@endif</td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->jenisrisiko }}</p>@else{{ $riskdetail->jenisrisiko }}@endif</td> --}}
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->jenisrisiko }}</p>@else{{ $riskdetail->jenisrisiko }}@endif</td>
                                <td align="center">
                                    @if($riskdetail->kaidah=='1')
                                    <a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a>
                                    @else
                                    <a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a>
                                    @endif
                                </td>
                                
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->risiko }}</p>@else{{ $riskdetail->risiko }}@endif</td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->peluang->nama }}</p>@else{{ $riskdetail->peluang->nama }}@endif</td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->dampak->nama }}</p>@else{{ $riskdetail->dampak->nama }}@endif</td>
                                <td><button type="button" class="btn btn-{{ $riskdetail->warna }} btn-sm"></button></td>
                                <td><a class="btn btn-primary" href="#" data-toggle="modal"
                                        data-target="#modal-sumberresikobisnis"
                                        onclick="sumberrisiko({{ $riskdetail->id }},'{{$riskdetail->risiko}}')"><i class="fa fa-reorder (alias)"
                                            title="List sumber risiko"></i></a>
                                </td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->indikator }}</p>@else{{ $riskdetail->indikator }}@endif</td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->nilaiambang }}</p>@else{{ $riskdetail->nilaiambang }}@endif</td>
                                <td>
                                @if($periodeaktif->id==$risikobisnis->perioderisikobisnis_id)
                                <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(@if(isset($riskdetail->id)){{$riskdetail->id}}@endif,'{{$riskdetail->risiko}}')"><i class="fa fa-commenting-o" title="Komentar"></i></a>      
                                @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                           
                            @endif

                        </tbody>
                        <tfoot>
                            
                            <tr>
                                <th colspan="3"><input type="checkbox" id="selectall" onClick="selectAll(this)" />&nbsp;Pilih semua</th> 
                                <th colspan="7">
                                    
                                    <a class="btn btn-primary"  onclick="sesuaikaidah()"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a>
                                    <a class="btn btn-warning" onclick="tidaksesuaikaidah()"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a>
                                    <a class="btn btn-danger" onclick="highlight()"><i class="fa  fa-tags" title="KRI"></i></a>
                                    <a class="btn btn-success" onclick="batalhighlight()"><i class="fa  fa-tags" title="Batal KRI"></i></a>
                                    <a class="btn btn-info" onclick="kri()">CL</a>
                                    <a class="btn btn-warning" onclick="batalkri()">Batal CL</a>
                                    <a class="btn btn-info" onclick="rkap()">RKAP</a>
                                    <a class="btn btn-warning" onclick="batalrkap()">Batal RKAP</a> 
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                           
                        </tfoot>

                    </table>
                </form>
                </div>
                
            </div>
            
        </div>
        
    </div>
    @include('resiko/resikobisnis/modal/sumberresikobisnis')
    @include('resiko/risikobisnisverifi/modal/komentar')
</section>
@endsection