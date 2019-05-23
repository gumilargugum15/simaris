@extends('layouts.app')
@section('style')

@endsection
@section('content')
<script>
function pilihdampak(krinama,dampakid,katid,level){
    var peluangid = $("#peluang").val();
    getmatrix(peluangid,dampakid);
    $("#idkategori").val(katid);
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
</script>
<section class="content-header">
<h1>
    Data
    <small>Tambah risiko bisnis</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li><li class="active">Edit risiko bisnis</li>
</ol>
</section>
<section class="content">
<div class="box">
        <div class="box-body">
                <div class="box box-warning">
                        <form action="{{ url('ubah') }}" method="post" enctype="multipart/form-data">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <div class="form-group">
                
                            <label>Periode/tahun</label>
                            <div class="row">
                            <div class="col-xs-8">
                            <input type="text" class="form-control" name="periode" id="periode" value="{{ $riskbisnis->periode }}" placeholder="Periode ..." readonly>
                            </div>
                            <div class="col-xs-4">
                            <input type="text" class="form-control" name="tahun" id="tahun" value="{{ $riskbisnis->tahun }}" placeholder="Tahun ..." readonly>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label>KPI</label>
                        
                        <select class="form-control select2" style="width: 100%;" name="kpi" id="kpi">
                            @foreach ($kpi as $rowkpi)
                            @if($riskdetail->kpi_id==$rowkpi->id)
                            <option value="{{$rowkpi->id}}" selected>{{$rowkpi->nama}}</option>
                            @else
                            <option value="{{$rowkpi->id}}">{{$rowkpi->nama}}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <label>Risiko</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="risiko" id="risiko">{{$riskdetail->risiko}}</textarea>
                        </div>
                        <div class="form-group">
                        <label>Akibat</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="akibat" id="akibat">{{$riskdetail->akibat}}</textarea>
                        </div>
                        <div class="form-group">
                        <label>Klasifikasi</label>
                        <select class="form-control select2" style="width: 100%;" name="klasifikasi" id="klasifikasi">
                            @foreach ($klasifikasi as $rowklasifikasi)
                            @if($riskdetail->klasifikasi_id==$rowklasifikasi->id)
                            <option value="{{$rowklasifikasi->id}}" selected>{{$rowklasifikasi->nama}}</option>
                            @else
                            <option value="{{$rowklasifikasi->id}}" >{{$rowklasifikasi->nama}}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <label>Peluang</label>
                        <select class="form-control select2" style="width: 100%;" name="peluang" id="peluang">
                            @foreach ($peluang as $rowpeluang)
                            @if($riskdetail->peluang_id==$rowpeluang->id)
                            <option value="{{$rowpeluang->id}}" selected>{{$rowpeluang->level}}-{{$rowpeluang->nama}}-{{$rowpeluang->kriteria}}</option>
                            @else
                            <option value="{{$rowpeluang->id}}">{{$rowpeluang->level}}-{{$rowpeluang->nama}}-{{$rowpeluang->kriteria}}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-dampakrisiko"><i class="fa fa-search (alias)" title="">&nbsp;Dampak</i></a><br><br>
                        <input type="hidden" class="form-control" name="iddampak" id="iddampak" value="{{$kriteria->dampak_id}}" readonly>
                        <input type="hidden" class="form-control" name="idkategori" id="idkategori" value="{{$kriteria->kategori_id}}" readonly>
                        <input type="text" class="form-control" name="dampak" id="dampak" placeholder="Dampak ..." value="{{$kriteria->nama}}" disabled>
                        </div>
                        <div class="form-group">
                        <label>Warna</label>
                        <input type="hidden" class="form-control" name="warna" id="warna" value="Hijau" readonly>
                        <div id="buttonwarna"><button type="button" class="btn btn-{{$matrik->warna}} btn-sm">{{$matrik->tingkat}}</button></div>
                        </div>
                        <div class="form-group">
                                
                            <a class="btn btn-primary" onclick="addrisiko()"><i class="fa fa-plus (alias)" title=""></i></a>
                            <table id="sumberresikobisnis" class="table table-bordered table-striped">
                                <input type="hidden" id="rowsumber" value="1">
                                <thead>
                                <tr>
                                <th>Sumber risiko</th>
                                <th>Mitigasi</th>
                                <th>Biaya</th>
                                <th>Startdate</th>
                                <th>Enddate</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th>Act</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sumberrisiko as $datasumber)
                                <tr>
                                    <td>{{$datasumber->namasumber}}</td>
                                    <td>{{$datasumber->mitigasi}}</td>
                                    <td>{{$datasumber->biaya}}</td>
                                    <td>{{$datasumber->start_date}}</td>
                                    <td>{{$datasumber->end_date}}</td>
                                    <td>{{$datasumber->pic}}</td>
                                    <td>{{$datasumber->statussumber}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                    
                    <a type="button" href="{{ url('resikobisnis') }}" class="btn btn-default pull-left">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Ubah</button>
                </form>
                </div>
        </div>

</div>
@include('resiko/resikobisnis/modal/dampakrisiko')
{{-- @include('resiko/resikobisnis/modal/addsumberrisikobisnis') --}}
</section>

    
@endsection
