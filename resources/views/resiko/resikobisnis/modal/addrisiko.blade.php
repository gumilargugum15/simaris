<div class="modal fade" id="modal-addresiko" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('store') }}" method="post" enctype="multipart/form-data">
          <input name="_token" value="{{ csrf_token() }}" type="hidden">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah Risiko</h4>
        </div>
        <div class="modal-body" >
            <div class="box box-warning">
                {{-- <div class="box-header with-border">
                  <h3 class="box-title">General Elements</h3>
                </div> --}}
                <!-- /.box-header -->
                <div class="box-body">
                  
                    <!-- text input -->
                    <div class="form-group">
                       
                    <label>Periode/tahun</label>
                    <div class="row">
                      <div class="col-xs-8">
                      @if(isset($unituser->kode))
                      <input type="hidden" name="unitid" id="unitid" value="{{ $unituser->kode }}">
                      @endif
                      <input type="text" class="form-control" name="periode" id="periode" value="{{ $periodeaktif->nama }}" placeholder="Periode ..." readonly>
                      </div>
                      <div class="col-xs-4">
                      <input type="text" class="form-control" name="tahun" id="tahun" value="{{ $periodeaktif->tahun }}" placeholder="Tahun ..." readonly>
                      </div>
                  </div>
                  </div>
                    <div class="form-group">
                        <label>KPI</label>
                        <select class="form-control select2" style="width: 100%;" name="kpi" id="kpi">
                          @foreach ($kpi as $rowkpi)
                          <option value="{{$rowkpi->id}}">{{$rowkpi->nama}}</option>
                          @endforeach
                        </select>
                      </div>
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Risiko</label>
                      <textarea class="form-control" rows="3" placeholder="Enter ..." name="risiko" id="risiko"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Akibat</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="akibat" id="akibat"></textarea>
                      </div>
                      <div class="form-group">
                        <label>Klasifikasi</label>
                        <select class="form-control select2" style="width: 100%;" name="klasifikasi" id="klasifikasi">
                          @foreach ($klasifikasi as $rowklasifikasi)
                          <option value="{{$rowklasifikasi->id}}">{{$rowklasifikasi->nama}}</option>
                          @endforeach
                        </select>
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
                        {{-- <label>Dampak</label> --}}
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-dampakrisiko"><i class="fa fa-search (alias)" title="">&nbsp;Dampak</i></a><br><br>
                        <input type="hidden" class="form-control" name="iddampak" id="iddampak" value="1" readonly>
                        <input type="text" class="form-control" name="dampak" id="dampak" placeholder="Dampak ..." disabled>
                      </div>
                      <div class="form-group">
                        <label>Warna</label>
                        <input type="hidden" class="form-control" name="warna" id="warna" value="Hijau" readonly>
                        <div id="buttonwarna"></div>
                      </div>
                      <div class="form-group">
                        {{-- <label>Sumber risiko</label> --}}
                        <a class="btn btn-primary" href="#" onclick="addrisiko()"><i class="fa fa-plus (alias)" title=""></i></a>
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
                          
                          </tbody>
                        </table>
                      </div>
                      <div class="form-group">
                          <label>Indikator</label>
                          <textarea class="form-control" rows="3" placeholder="Enter ..." name="indikator" id="indikator"></textarea>
                      </div>
                      <div class="form-group">
                          <label>Nilai ambang</label>
                          <input type="number" class="form-control" name="nilaiambang" id="nilaiambang">
                        </div>
    
                    
                  
                </div>
                <!-- /.box-body -->
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary pull-right">Simpan</button>
        </div>
      </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @include('resiko/resikobisnis/modal/dampakrisiko')
  @include('resiko/resikobisnis/modal/addsumberrisikobisnis')