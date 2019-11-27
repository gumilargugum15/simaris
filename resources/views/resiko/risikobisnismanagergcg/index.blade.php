@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>
function validriskbisnisgcg(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('validasibisnismanagergcg') }}/" + id,
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
function batalvalidriskbisnisgcg(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('batalvalidasibisnismanagergcg') }}/" + id,
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
                                            {{-- <option value="{{$period->nama}}-{{$period->tahun}}" selected>
                                                {{$period->nama}}/{{$period->tahun}}</option> --}}
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
                        @if($risikobisnis->statusrisiko_id=='4')
                        <a href="#" class="btn btn-small btn-primary"
                            onclick="validriskbisnisgcg({{ $risikobisnis->id }})"><i class="fa fa-check-square"></i>
                            Validasi</a>
                        @elseif($risikobisnis->statusrisiko_id > '5'||$risikobisnis->statusrisiko_id < '4')
                        -
                        @else<a href="#" class="btn btn-small btn-warning"
                            onclick="batalvalidriskbisnisgcg({{ $risikobisnis->id }})"><i class="fa fa-undo"></i> Batal
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
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                        <form id="fm-kaidah">
                            <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <table id="tblresikobisnis" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                
                                <th>No</th>  
                                <th>KPI</th>
                                <th>Utama</th>
                                <th>Jenis</th>
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
               
                                <td>{{$no}}</td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->kpi->nama }}</p>@else{{ $riskdetail->kpi->nama }}@endif</td>
                                <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->kpi->utama }}</p>@else{{ $riskdetail->kpi->utama }}@endif</td>
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
                                 <td><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-sumberresikobisnis"
                                     onclick="sumberrisiko({{ $riskdetail->id }},'{{$riskdetail->risiko}}')"><i class="fa fa-reorder (alias)" title="List sumber risiko"></i></a>
                                 </td>
                                 <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->indikator }}</p>@else{{ $riskdetail->indikator }}@endif</td>
                                 <td>@if($riskdetail->highlight=='1')<p class="text-red">{{ $riskdetail->nilaiambang }}</p>@else{{ $riskdetail->nilaiambang }}@endif</td>
                                 <td></td>
                               </tr>
                               @endif
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
</section>
@endsection