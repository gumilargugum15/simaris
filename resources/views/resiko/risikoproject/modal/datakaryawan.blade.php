<div class="modal fade" id="modal-datakaryawan">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Data Karyawan</h4>
        </div>
        <div class="modal-body">
            <table id="tblkaryawan" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>Personel No</th>
                      <th>Name</th>
                      <th>Golongan</th>
                      <th>Cost Center</th>
                      <th>Position Name</th>
                      <th>Org Unit Name</th>
                      <th>Kode Unit</th>
                      <th>Emporid</th>
                      <th>Divisi</th>
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($jessval->data as $data)
                    <tr>
                      <td>{{$data->personnel_no}}</td>
                      <td>{{$data->name}}</td>
                      <td>{{$data->esgrp}}</td>
                      <td>{{$data->cost_ctr}}</td>
                      <td>{{$data->position_name}}</td>
                      <td>{{$data->org_unit_name}}</td>
                      <td>{{$data->kode_unit}}</td>
                      <td>{{$data->emporid}}</td>
                      <td>{{$data->divisi}}</td>
                      <td><a class="btn btn-small" title="Pilih" onclick="pilihkaryawan('{{$data->personnel_no}}','{{$data->name}}','{{$data->position_name}}')"><i class="fa fa-check"></i></a></td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>
            {{-- <a href="{{$jessval->next_page_url}}">Next</a> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script>
      $(function () {
        $('#tblkaryawan').DataTable()
      })
      function pilihkaryawan(nik,nama,jabatan){
        //alert(nik+'-'+nama+'-'+jabatan);
        $("#keyperson").val(nik);
        $("#namakeyperson").val(nama);
        $("#jabkeyperson").val(jabatan);
        $('#modal-datakaryawan').modal('toggle');
      }
    </script>