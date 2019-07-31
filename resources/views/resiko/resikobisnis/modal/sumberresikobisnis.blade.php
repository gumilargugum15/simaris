<script>
function sumberrisiko(id,risiko) {
    $("#titlesumber").html('Risiko  '+risiko+' ');
    read_sumberrisiko(id);
  }
  function isifile(file){
     console.log(file);
    // $("#preview").empty();
    $("#preview").html('<object width="100%" height="100%" data="'+file+'"></object>');
    $('#modal-preview').modal({
            backdrop: 'static',
            keyboard: false
        });
    
  }
  function read_sumberrisiko(id) {

    $('#tblsumberresikobisnis').DataTable({
      "ajax": "{{ url('sumberrisiko') }}/" + id,
      "bDestroy": true,
      "columns": [
        { "data": "namasumber" },
        { "data": "mitigasi" },
        { "data": "biaya" },
        { "data": "start_date" },
        { "data": "end_date" },
        { "data": "pic" },
        { "data": "statussumber" },
        {
          "className": 'options',
          "data": "file",
          "render": function(data, type, full, meta){
            return '<a href="#" onclick="isifile(\'' +data+ '\')"><i class="fa fa-2x fa-file-picture-o"></i></a>'; 
          }
        }
      ]
    });
  }
  function previewlampiran(file){
    alert(file);
  }
</script>
<div class="modal fade" id="modal-sumberresikobisnis">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="titlesumber"></h4>
            </div>
            <div class="modal-body">
                    <table id="tblsumberresikobisnis" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Sumber</th>
                              <th>Mitigasi</th>
                              <th>Biaya</th>
                              <th>Startdate</th>
                              <th>Enddate</th>
                              <th>PIC</th>
                              <th>Status</th>
                              <th>Attachment</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                            <tfoot>
                                    <tr>
                                    <th>Sumber</th>
                                    <th>Mitigasi</th>
                                    <th>Biaya</th>
                                    <th>Startdate</th>
                                    <th>Enddate</th>
                                    <th>PIC</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    </tr>
                            </tfoot>
                          </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      @include('resiko/resikobisnis/modal/preview')