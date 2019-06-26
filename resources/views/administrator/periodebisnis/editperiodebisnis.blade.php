@extends('layouts.app')
@section('style')

@endsection
@section('content')
<script>

</script>
<section class="content-header">
<h1>
   
    <small>Edit Periode Bisnis</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li><li class="active">Edit Periode Bisnis</li>
</ol>
</section>
<section class="content">
<div class="box">
        <div class="box-body">
                <div class="box box-warning">
                    <form action="{{ url('updateperiodbisnis') }}" method="post" enctype="multipart/form-data">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <input name="id" value="{{$periodebisnis->id}}" type="hidden">
                        <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{$periodebisnis->nama}}">
                        </div>
                        <div class="form-group">
                            <label>Startdate - Enddate</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                             
                              <input type="text" class="form-control pull-right" id="startenddate" name="startenddate" value="{{$startenddate}}">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" class="form-control" name="tahun" id="tahun" value="{{$periodebisnis->tahun}}">
                        </div>
                    
                    <a type="button" href="{{ url('periodebisnis') }}" class="btn btn-default pull-left">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </form>
                </div>
        </div>

</div>
</section>

    
@endsection
