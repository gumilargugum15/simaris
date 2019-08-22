@extends('layouts.app')
@section('style')

@endsection
@section('content')
<script>

</script>
<section class="content-header">
<h1>
    Data
    <small>Tambah risiko aset</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li><li class="active">Tambah risiko aset</li>
</ol>
</section>
<section class="content">
<div class="box">
        <div class="box-body">
                <div class="box box-warning">
                    @if (count($errors) > 0)
                   
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                        <form action="{{ url('storeaset') }}" method="post" enctype="multipart/form-data">
                        
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <div class="form-group">
                
                            <label>Periode/tahun</label>
                            <div class="row">
                            <div class="col-xs-8">
                            @if(isset($unituser->objectabbr))
                            <input type="hidden" name="unitid" id="unitid" value="{{ $unituser->objectabbr }}">
                            @endif
                            <input type="text" class="form-control" name="periode" id="periode" value="{{ $periodeaktif->nama }}" placeholder="Periode ..." readonly>
                            </div>
                            <div class="col-xs-4">
                            <input type="text" class="form-control" name="tahun" id="tahun" value="{{ $periodeaktif->tahun }}" placeholder="Tahun ..." readonly>
                            </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        <label>Kelompokaset</label>
                        <select class="form-control select2" style="width: 100%;" name="kelompokaset" id="kelompokaset" required>
                            @foreach ($kelompokaset as $rowkelompokaset)
                            <option value="{{$rowkelompokaset->id}}">{{$rowkelompokaset->nama}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                                <label>Nama Aset</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." name="namaaset" id="namaaset" required>{{ old('namaaset') }}</textarea>
                        </div>
                        <div class="form-group">
                        
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-kriteria"><i class="fa fa-search (alias)" title="">&nbsp;Kriteria</i></a><br><br>
                        <input type="hidden" class="form-control" name="sensitivitaskriteria_id" id="sensitivitaskriteria_id" value="{{ old('sensitivitaskriteria_id') }}" readonly>
                        <input type="hidden" class="form-control" name="sensitivitaskritikalitas_id" id="sensitivitaskritikalitas_id" value="{{ old('sensitivitaskritikalitas_id') }}"  readonly>
                        <input type="text" class="form-control" name="kritikalitas" id="kritikalitas" value="{{ old('kritikalitas') }}" placeholder="Kritikalitas ..." readonly required>
                        </div>
                        <div class="form-group">
                            <label>Ancaman</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="ancaman" id="ancaman" required>{{ old('ancaman') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Pengendalian yang ada</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="pengendalian" id="pengendalian" required>{{ old('pengendalian') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Kerawanan</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="kerawanan" id="kerawanan" required>{{ old('kerawanan') }}</textarea>
                        </div>
                        <div class="form-group">
                        <label>Peluang</label>
                        <select class="form-control select2" style="width: 100%;" name="peluang" id="peluang">
                            @foreach ($peluang as $rowpeluang)
                            <option value="{{$rowpeluang->id}}">{{$rowpeluang->level}}-{{$rowpeluang->nama}}-{{$rowpeluang->kriteria}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-dampakrisiko"><i class="fa fa-search (alias)" title="">&nbsp;Dampak</i></a><br><br>
                        <input type="hidden" class="form-control" name="iddampak" id="iddampak" value="{{ old('iddampak') }}" readonly>
                        <input type="hidden" class="form-control" name="idkategori" id="idkategori" value="{{ old('idkategori') }}"  readonly>
                        <input type="text" class="form-control" name="dampak" id="dampak" value="{{ old('dampak') }}" placeholder="Dampak ..." readonly required>
                        </div>
                        <div class="form-group">
                        <label>Warna</label>
                        <input type="hidden" class="form-control" name="warna" id="warna" value="{{ old('warna') }}"  readonly>
                        <div id="buttonwarna"></div>
                        </div>
                    <div class="form-group">
                        <label>Mitigasi</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="mitigasi" id="mitigasi" required>{{ old('mitigasi') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Biaya</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="biaya" id="biaya" required>{{ old('biaya') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Target(waktu)</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="targetwaktu" id="targetwaktu" required>{{ old('targetwaktu') }}</textarea>
                    </div>
                    <div class="form-group">
                            <label>Pic</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="pic" id="pic" required>{{ old('pic') }}</textarea>
                        </div>
                    <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" name="status" id="status" value="{{ old('status') }}" required>
                    </div>
                    <a type="button" href="{{ url('resikobisnis') }}" class="btn btn-default pull-left">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    
                </form>
                </div>
        </div>

</div>
@include('resiko/resikobisnis/modal/dampakrisiko')
@include('modal/kriteria')
</section>

    
@endsection
