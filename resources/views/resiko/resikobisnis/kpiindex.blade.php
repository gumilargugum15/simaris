@extends('layouts.app')
@section('style')

@endsection

@section('content')
<script>
  
</script>
<section class="content-header">
  <h1>
    Data
    <small>{{$judul}}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Periode aktif : <b>{{$periodeaktif->nama." ".$periodeaktif->tahun}}</b> dari tanggal : <b>{{$periodeaktif->start_date}}</b> sampai tanggal <b>{{$periodeaktif->end_date}}</b>
                <br>KPI yang diupload otomatis masuk ke periode aktif saat ini, pastikan data yang akan diimport sudah benar !
              </div>
            @include('layouts.flash')
            @if(isset($dataoto))
            @if($dataoto->status=='1')
            <a class="btn btn-primary" href="{{ url('addkpikeyperson') }}"><i class="fa  fa-plus" title=""> KPI Baru</i></a>
            @endif
            @endif
            <div align="right">
                <form action="{{ url('importkpi') }}" method="post" enctype="multipart/form-data">
                  <input name="_token" value="{{ csrf_token() }}" type="hidden">
                  <input type="file" id="file" name="excel" required>
                  <button class="btn btn-success" type="submit" class="btn btn-primary pull-right"><i class="fa fa-file-excel-o" title=""> Import KPI</i></button>
                </form>
              </div>
        </div>
        <div class="box-body">
            <form id="fm-level">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <table id="tblkpi" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th width="20%">Unit</th>
                    <th>Tahun</th>
                    <th>Level</th>
                    <th>KPI utama</th>
                    <th width="15%">Nama (tahun) Periode</th>
                    <th width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;
                    @endphp
                  @foreach($kpi as $data)
                  @php
                  $no++;
                  @endphp
                  <tr>
                    <td><input type="checkbox" name="level[]" class="form-controll" value="{{$data->id}}"></td>
                    <td>{{$no}}</td>
                    <td>{{$data->kode}}</td>
                    <td>{{$data->nama}}</td>
                    <td>{{$data->namaunit}} ( {{$data->unit_id}} )</td>
                    <td>{{$data->tahun}}</td>
                    <td><a class="btn btn-{{$data->warna}}" href="#">{{$data->namalevel}}</a></td>
                    <td>
                      @if($data->utama=='Y')
                      <a class="btn btn-primary" href="#">{{$data->utama}}</a>
                      @endif
                    </td>
                    <td>{{$data->namaperiode}} ( {{$data->tahunperiode}} )</td>
                    <td>
                      @if(isset($dataoto))
                      @if($dataoto->status=='1')
                      <a href="{{url('editkpikeyperson',['id'=>$data->id])}}" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                      {{-- <a href="{{url('destroykpikeyperson',['id'=>$data->id])}}" class="btn btn-small"><i class="fa fa-trash" title="Hapus"></i></a> --}}
                      @endif
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4"><input type="checkbox" id="selectall" onClick="selectAllkpi(this)" />&nbsp;Pilih semua</th> 
                        <th>
                            <a class="btn btn-success" onclick="levelbiasa()"><i class="fa fa-cog" title="Biasa"></i></a>
                            <a class="btn btn-danger" onclick="levelhight()"><i class="fa fa-cog" title="Hight"></i></a>
                            <a class="btn btn-primary" onclick="kpiutama()"><i class="fa fa-bookmark" title="kpi Utama"></i></a>
                            <a class="btn btn-warning" onclick="batalkpiutama()"><i class="fa fa-bookmark" title="Batal kpi Utama"></i></a>
                            
                        </th>
                        <th></th>
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
    <script>
      $(function () {
        // $('#tblkpi').DataTable()
        $('#tblkpi thead tr').clone(true).appendTo( '#tblkpi thead' );
        $('#tblkpi thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input size="5" type="text" placeholder="Cari..."/>' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
        } );
    var table = $('#tblkpi').DataTable( {
      orderCellsTop: true,
        fixedHeader: true,
       responsive: true
    } );
      })
      function selectAllkpi(source) {
		checkboxes = document.getElementsByName('level[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	  }
    function levelbiasa(){
      if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-level').serialize();
        $.ajax({
                url: "{{ url('levelbiasa') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
    }
    function levelhight(){
      if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-level').serialize();
        $.ajax({
                url: "{{ url('levelhight') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
    }
    function kpiutama(){
      if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-level').serialize();
        $.ajax({
                url: "{{ url('kpiutama') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
    }
    function batalkpiutama(){
      if (confirm("Apakah anda yakin ?") == true) {
        var data_val = $('#fm-level').serialize();
        $.ajax({
                url: "{{ url('batalkpiutama') }}",
                method: 'post',
                data	: data_val,
                success: function (data) {
                    location.reload();
                }
            });

    }
    }
    </script>
</section>
@endsection