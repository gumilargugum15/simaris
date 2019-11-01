@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>
  
  function validriskproject(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('validriskproject') }}/" + id,
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
  function batalvalidriskproject(id){
    if (confirm("Apakah anda yakin ?") == true) {
            $.ajax({
                url: "{{ url('batalvalidasiproject') }}/" + id,
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
    <small>Risiko Project</small>
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
                        <div class="col-xs-5">
                        <select class="form-control select2" style="width: 100%;" name="periode" id="periode">
                            <option value="">Pilih Periode</option>
                              @foreach ($periodeall as $period)
                              @if(isset($risikoproject->periode))
                              @if(($period->nama."-".$period->tahun)==($risikoproject->periode."-".$risikoproject->tahun)){
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
                        <div class="col-xs-5">
                            <select class="form-control select2" style="width: 100%;" name="project" id="project">
                                <option value="">Pilih Project</option>
                                  @foreach ($project as $project)
                                  @if(isset($risikoproject->project_id))
                                  @if(($project->id)==($risikoproject->project_id)){
                                    <option value="{{$project->id}}" selected>{{$project->nama}}</option>
                                  @else
                                  <option value="{{$project->id}}">{{$project->nama}}</option>
                                  @endif
                                  @else
                                  <option value="{{$project->id}}">{{$project->nama}}</option>
                                  @endif
                                  @endforeach
                            </select>
                            
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
              @if(isset($risikoproject->statusrisiko_id))
              @if($risikoproject->statusrisiko_id=='0')
              <a href="#"
                class="btn btn-small btn-danger">Belum input risiko...</a>
              @else
              @if(isset($risikoproject->statusrisiko->nama))
                <a href="#"
                class="btn btn-small btn-success">@if(isset($risikoproject->statusrisiko->nama)){{ $risikoproject->statusrisiko->nama }}@else{{ ' ' }}@endif</a>
              @endif
              @endif
              @endif
              
              </td>
            <td>
              
              @if(isset($risikoproject->statusrisiko_id))
              @if($risikoproject->statusrisiko_id=='1')
                
                <a href="#"
                class="btn btn-small btn-primary" onclick="validriskproject({{ $risikoproject->id }})"><i class="fa fa-check-square"></i> Validasi</a>
               
                @elseif($risikoproject->statusrisiko_id=='0')
              <a href="#"
                class="btn btn-small btn-danger">Belum input risiko...</a>
              @elseif($risikoproject->statusrisiko_id > '2')
              -
              @else
              <a href="#"
              class="btn btn-small btn-warning" onclick="batalvalidriskproject({{ $risikoproject->id }})"><i class="fa fa-undo"></i> Batal validasi</a>
              
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
          <a class="btn btn-primary" href="{{ url('addrisikoproject') }}"><i class="fa  fa-plus"
            title=""> Risiko Baru</i></a>
          
                <a class="btn btn-success" onclick="reload()"><i class="fa  fa-refresh" title=""> Refresh</i></a>
                
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
              <tr>
                {{-- <th>Periode</th> --}}
                <th>No</th>
                <th>Kaidah</th>
                <th>Nama Project</th>
                <th>Tahap Project</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber Risiko</th>
                <th>Indikator</th>
                <th>Nilai Ambang</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              
                @if(isset($risikoproject->risikoprojectdetail))
                @php
                $no=0;
                @endphp
                @foreach ($risikoproject->risikoprojectdetail as $riskdetail)
                @php
                $no++;
                @endphp
                @if($riskdetail->destroy=='1')
                continue;
                @else
                <tr >
                {{-- <td>{{ $risikobisnis->periode." ".$risikobisnis->tahun }}</td> --}}
               <td>{{$no}}</td>
               <td align="center">
                @if($riskdetail->kaidah=='1')
                <a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a>
                @else
                <a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a>
                @endif
              </td>
               <td>{{$riskdetail->project->nama}}</td>
               <td>{{$riskdetail->tahapproject->nama}}</td>
               <td>{{$riskdetail->risiko}}</td>
               <td>{{$riskdetail->peluangproject->kriteria}}</td>
               <td>{{ $riskdetail->namadampak }}</td>
               <td><button type="button" class="btn btn-{{ $riskdetail->warna }} btn-sm"></button></td>
               <td><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-sumberresiko"
                onclick="sumberrisiko({{ $riskdetail->id}},'{{$riskdetail->risiko}}')"><i class="fa fa-reorder (alias)" title="List sumber risiko"></i></a>
               </td>
               <td>{{$riskdetail->indikator}}</td>
               <td>{{$riskdetail->nilaiambang}}</td>
               <td><a href="{{url('editriskproject',['id'=>$riskdetail->id])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                <a href="{{url('destroyriskproject',['id'=>$riskdetail->id])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a>
                
              </td>
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
  @include('resiko/risikoproject/modal/sumberresiko')
  {{-- @include('resiko/resikobisnis/modal/addrisiko') --}}
  {{-- @include('resiko/resikobisnis/modal/komentar') --}}
  
</section>
@endsection