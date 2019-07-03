<div class="modal fade" id="modal-komentar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                        <div class="box box-primary direct-chat direct-chat-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Komentar</h3>
                    
                                  <div class="box-tools pull-right">
                                    {{-- <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span> --}}
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool"><i class="fa fa-refresh" onclick="readkomen(@if(isset($risikobisnis->id)){{$risikobisnis->id}}@endif)"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                                      <i class="fa fa-comments"></i></button> --}}
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <!-- Conversations are loaded here -->
                                  <div class="direct-chat-messages" id="komentar">
                                    
                                  </div>
                                  <!--/.direct-chat-messages-->
                    
                                  <!-- Contacts are loaded here -->
                                  <div class="direct-chat-contacts">
                                    <ul class="contacts-list">
                                      <li>
                                        <a href="#">
                                          <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Image">
                    
                                          <div class="contacts-list-info">
                                                <span class="contacts-list-name">
                                                  Count Dracula
                                                  <small class="contacts-list-date pull-right">2/28/2015</small>
                                                </span>
                                            <span class="contacts-list-msg">How have you been? I was...</span>
                                          </div>
                                          <!-- /.contacts-list-info -->
                                        </a>
                                      </li>
                                      <!-- End Contact Item -->
                                    </ul>
                                    <!-- /.contatcts-list -->
                                  </div>
                                  <!-- /.direct-chat-pane -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                  
                                    <div class="input-group">
                                      <form id="formkomentar">
                                          <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                          <input type="hidden" name="idrisiko" id="idrisiko" value="@if(isset($risikobisnis->id)){{$risikobisnis->id}}@endif">
                                      <input type="text" id="message" name="message" placeholder="Ketik pesan ..." class="form-control">
                                    </form>
                                          <span class="input-group-btn">
                                            <button class="btn btn-primary btn-flat" onclick="kirimkomentar()">Kirim</button>
                                          </span>
                                    </div>
                                  
                                </div>
                                <!-- /.box-footer-->
                              </div>
                </div>
            
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>