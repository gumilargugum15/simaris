@extends('layouts.app')
@section('style')

@endsection
@section('content')
<script>

</script>
<section class="content-header">
<h1>
    Data
    <small>Tambah Project</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li><li class="active">Tambah Project</li>
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
                    <form action="{{ url('storeproject') }}" method="post" enctype="multipart/form-data">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <div class="form-group">
                        <label>Nama project</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                        <label>Unit</label>
                        <select class="form-control select2" style="width: 100%;" name="unit" id="unit">
                            @foreach ($unitkerja as $data)
                            <option value="{{$data->kode}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="keyperson" id="keyperson" placeholder="Input nik keyperson" value="{{ old('keyperson') }}">
                            <a class="btn btn-primary" onclick="carikeyperson('kp')"><i class="fa fa-search (alias)" title="" >&nbsp;Cari</i></a><br><br>
                            </div>
                
                            <div class="form-group">
                            <label>Nama keyperson</label>
                            
                            <input type="text" class="form-control" name="namakeyperson" id="namakeyperson" readonly value="{{ old('namakeyperson') }}">
                            </div>
                            <div class="form-group">
                            <label>Jabatan keyperson</label>
                            <input type="text" class="form-control" name="jabkeyperson" id="jabkeyperson" readonly value="{{ old('jabkeyperson') }}">
                            </div>
                            <div class="form-group">
                            <input type="text" class="form-control" name="pm" id="pm" placeholder="Input nik project manager">
                            <a class="btn btn-primary" onclick="carikeyperson('pm')"><i class="fa fa-search (alias)" title="">&nbsp;Cari</i></a><br><br>
                            </div>
                            <div class="form-group">
                            <label>Nama PM</label>
                            
                            <input type="text" class="form-control" name="namapm" id="namapm" readonly value="{{ old('namapm') }}">
                            </div>
                            <div class="form-group">
                            <label>Jabatan PM</label>
                            <input type="text" class="form-control" name="jabpm" id="jabpm" readonly value="{{ old('jabpm') }}">
                            </div>
                            <div class="form-group">
                            <label>Nama Kontrak</label>
                            <input type="text" class="form-control" name="namakontrak" id="namakontrak" value="{{ old('namakontrak') }}">
                            </div>
                            <div class="form-group">
                            <label>Nomor Kontrak</label>
                            <input type="text" class="form-control" name="nomorkontrak" id="nomorkontrak" value="{{ old('nomorkontrak') }}">
                            </div>
                            <div class="form-group">
                            <label>Startdate - Enddate</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="startenddate" name="startenddate">
                            </div>
                            <!-- /.input group -->
                        </div>
                    
                    <a type="button" href="{{ url('project') }}" class="btn btn-default pull-left">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </form>
                </div>
        </div>

</div>
@include('resiko/risikoproject/modal/datakaryawan')
<script>
function carikeyperson(e){
 if(e=='kp'){
    var nik =$("#keyperson").val();
 }
 if(e=='pm'){
    var nik =$("#pm").val();
 }
 
 if(nik==''){
    alert('input nik dulu !');
 }else{
    $.ajax({
        url:"{{ url('carikeyperson') }}/"+nik,
        method: 'GET',
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status+" : "+thrownError);
            $(".loading").hide();
            },
        success: function(data) {
            var data = JSON.parse(data);
            if(e=='kp'){
                $("#namakeyperson").val(data.name);
                $("#jabkeyperson").val(data.position_name);
            }
            if(e=='pm'){
                $("#namapm").val(data.name);
                $("#jabpm").val(data.position_name);
            }
            
        }
    });

 }
 
}
</script>
</section>

    
@endsection
