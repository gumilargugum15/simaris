@extends('layouts.app')
@section('style')

@endsection
@section('content')
<script>

</script>
<section class="content-header">
<h1>
    Data
    <small>Tambah Unit</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li><li class="active">Tambah Unit</li>
</ol>
</section>
<section class="content">
<div class="box">
        <div class="box-body">
                <div class="box box-warning">
                    <form action="{{ url('storeunit') }}" method="post" enctype="multipart/form-data">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="kode" id="kode">
                        </div>
                        <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                        <div class="form-group">
                            <label>Objectabbr</label>
                            <input type="text" class="form-control" name="objectabbr" id="objectabbr">
                        </div>
                    
                    <a type="button" href="{{ url('unit') }}" class="btn btn-default pull-left">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </form>
                </div>
        </div>

</div>
</section>

    
@endsection
