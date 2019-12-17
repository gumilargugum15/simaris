@extends('layouts.app')
@section('style')

@endsection
@section('content')
<script>

</script>
<section class="content-header">
<h1>
    Data
    <small>Tambah Users</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li><li class="active">Tambah Users</li>
</ol>
</section>
<section class="content">
<div class="box">
        <div class="box-body">
                <div class="box box-warning">
                    <form action="{{ url('storeusers') }}" method="post" enctype="multipart/form-data">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <div class="form-group">
                        <input type="text" class="form-control" name="nik" id="nik" placeholder="Input nik" value="{{ old('nik') }}" required>
                        <a class="btn btn-primary" onclick="carinik()"><i class="fa fa-search (alias)" title="" >&nbsp;Cari Nik</i></a><br><br>
                        </div>
                        <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" readonly required>
                        <label>Kode unit</label>
                        <input type="text" class="form-control" name="unit" id="unit" readonly required>
                        <label>Nama unit</label>
                        <input type="text" class="form-control" name="namaunit" id="namaunit" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Roles</label>
                            @foreach ($roles as $data)
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="roles[]" value="{{$data->id}}">
                                {{$data->namalengkap}}
                              </label>
                            </div>
                            @endforeach
                        {{-- <div class="form-group">
                        <label>Roles</label>
                        <select class="form-control select2" style="width: 100%;" name="roles" id="roles" required>
                            @foreach ($roles as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                        </div> --}}
                       
                    <a type="button" href="{{ url('users') }}" class="btn btn-default pull-left">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </form>
                </div>
        </div>

</div>
<script>
    function carinik(){
    
     var nik =$("#nik").val();
     if(nik==''){
        alert('input nik dulu !');
     }else{
        $.ajax({
            url:"{{ url('carinik') }}/"+nik,
            method: 'GET',
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status+" : "+thrownError);
                $(".loading").hide();
                },
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);
                $("#nama").val(data.name);
                $("#unit").val(data.old_abbr.substr(0, 5));
                $("#namaunit").val(data.org_unit_name);
            }
        });
    
     }
     
    }
    </script>
</section>

    
@endsection
