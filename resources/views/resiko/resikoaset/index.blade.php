@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>
  
  
</script>
<section class="content-header">
  <h1>
    Data
    <small>Risiko Aset</small>
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
                <input type="hidden" id="nikuser" value="{{$nikuser}}">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-10">
                        <select class="form-control select2" style="width: 100%;" name="periode" id="periode">
                            <option value="">Pilih Periode</option>
                              @foreach ($periodeall as $period)
                              @if(isset($risikoaset->periode))
                              @if(($period->nama."-".$period->tahun)==($risikoaset->periode."-".$risikoaset->tahun)){
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
            <td>
                @if(isset($unituser->nama)){{ $unituser->nama }}@else{{ ' ' }}@endif
            </td>
            <td>
              @if(isset($namarisiko))
              {{$namarisiko}}
              @endif
             
            </td>
            <td>
              @if(isset($risikoaset->statusrisiko_id))
              @if($risikoaset->statusrisiko_id=='0')
              <a href="#"
                class="btn btn-small btn-danger">Belum input risiko...</a>
              @else
              @if(isset($risikoaset->statusrisiko->nama))
                <a href="#"
                class="btn btn-small btn-success">@if(isset($risikoaset->statusrisiko->nama)){{ $risikoaset->statusrisiko->nama }}@else{{ ' ' }}@endif</a>
              @endif
              @endif
              @endif
              
              </td>
            <td>
              
              @if(isset($risikoaset->statusrisiko_id))
              @if($risikoaset->statusrisiko_id=='1')
                @if($jmlkpinull<1)
                <a href="#"
                class="btn btn-small btn-primary" onclick="validriskbisnis({{ $risikoaset->id }})"><i class="fa fa-check-square"></i> Validasi</a>
                @endif
                @elseif($risikoaset->statusrisiko_id=='0')
              <a href="#"
                class="btn btn-small btn-danger">Belum input risiko...</a>
              @elseif($risikoaset->statusrisiko_id > '2')
              -
              @else
              <a href="#"
              class="btn btn-small btn-warning" onclick="batalvalidriskbisnis({{ $risikoaset->id }})"><i class="fa fa-undo"></i> Batal validasi</a>
              
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
          <a class="btn btn-primary" href="{{ url('addrisikoaset') }}"><i class="fa  fa-plus"
                title=""> Risiko Baru</i></a>
                <a class="btn btn-success" onclick="reload()"><i class="fa  fa-refresh" title=""> Refresh</i></a>
                
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
            <table id="tblresikoaset" class="table table-bordered table-striped">
                <thead>
                  <tr align="center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kelompok Aset</th>
                    <th rowspan="2">Nama Aset</th>
                    <th colspan="2">Analisa sensitivitas aset</th>
                    <th rowspan="2">Ancaman</th>
                    <th rowspan="2">Pengendalian yang ada</th>
                    <th rowspan="2">Kerawanan</th>
                    <th rowspan="2">Peluang</th>
                    <th rowspan="2">Level</th>
                    <th rowspan="2">Dampak</th>
                    <th rowspan="2">Level</th>
                    <th rowspan="2">Warna</th>
                    <th rowspan="2">Mitigasi</th>
                    <th rowspan="2">Biaya</th>
                    <th rowspan="2">Target</th>
                    <th rowspan="2">PIC</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Tanggal setuju</th>
                    <th rowspan="2">Validasi security</th>
                    <th rowspan="2" width="15%">Aksi</th>
                  </tr>
                  <tr>
                      <th>Kriteria</th>
                      <th>Kritikalitas</th>
                  </tr>
                </thead>
                <tbody>
                    @if(isset($risikoaset->risikoasetdetail))
                    @php
                    $no=0;
                    @endphp
                    @foreach ($risikoaset->risikoasetdetail as  $key=>$riskdetail)
                    @php
                    $no++;
                    @endphp
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$riskdetail->kelompokaset->nama}}</td>
                        <td>{{$riskdetail->namaaset}}</td>
                        <td>{{$riskdetail->sensitivitaskriteria->nama}}</td>
                        <td>{{$riskdetail->kritikalitas}}</td>
                        <td>{{$riskdetail->ancaman}}</td>
                        <td>{{$riskdetail->pengendalian}}</td>
                        <td>{{$riskdetail->kerawanan}}</td>
                        <td>{{$riskdetail->peluang->kriteria}}</td>
                        <td>{{$riskdetail->peluang->level}}</td>
                        <td>{{$riskdetail->dampak->nama}}</td>
                        <td>{{$riskdetail->dampak->level}}</td>
                        <td>{{$riskdetail->warna}}</td>
                        <td>{{$riskdetail->mitigasi}}</td>
                        <td>{{$riskdetail->biaya}}</td>
                        <td>{{$riskdetail->targetwaktu}}</td>
                        <td>{{$riskdetail->pic}}</td>
                        <td>{{$riskdetail->status}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  
</section>
@endsection