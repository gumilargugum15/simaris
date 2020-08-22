<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Risikobisnis;
use App\Unitkerja;
use App\Statusrisiko;
use App\Risikobisnisdetail;
use App\Validasibisnis;
use App\Sumberrisiko;
use App\Kpi;
use App\Peluang;
use App\Dampak;
use App\Kategori;
use App\Kriteria;
use App\Perioderisikobisnis;
use App\Klasifikasi;
use App\Matrikrisiko;
use Illuminate\Support\Facades\Auth;

class RiskbisnispimpinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=> false,
            "verify_peer_name"=> false,
        ),
      );
    public function index(Request $request)
    {
        $jmlkpiall = 0;
        $jmlkpisudahinput = 0;
        $jmlkpinull = 0;
        $namarisiko ="Risiko Bisnis";
        $user = Auth::user();
        $unitid = $user->unit_id;
        $unitkerja = Unitkerja::where('objectabbr',$unitid)->get();
        
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();

        $tabel='';
        if(isset($request->periode)){
       
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($unitid)->first();
            if($risikobisnis){
                $tabel='';
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->paginate(10);
            $detailrisk->withPath('resikobisnis?periode='.$request->periode.'&_token=cZYtqdssnfDLjJZxC8D5wfbsmCFksv1H1oNHIkPx');
            $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Kelompok</th>
                <th width="10%">Kaidah</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'matrikrisiko.tingkat')
                ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                ->join("matrikrisiko",function($join){
                    $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                         ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                    })
                ->leftjoin("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
                    ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");
                })
                ->get();
                $kpi = Kpi::where('id',$data->kpi_id)->first();
                $jmldetailkpi = count($detailkpi);
                
                $tabel.='<tr>';
                if($jmldetailkpi > 1){
                    $tabel.='<td rowspan="'.$jmldetailkpi.'">'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $tabel.='<td>'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td>'.$data->namakpi.'</td>';
                    }
                    
                }
                foreach($detailkpi as $keys=>$values){
                    if($keys==0){
                        $tabel.='
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>';
                        if($risikobisnis->statusrisiko_id <=1){
                            $tabel.='<td>
                        <a href="'.url('edit',['id'=>$values->id]).'" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>
                        </td>';
                        }else{
                            $tabel.='<td></td>';
                        }
                        $tabel.='</tr>';
                    }else{
                        $tabel.='<tr>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>';
                        if($risikobisnis->statusrisiko_id <=1){
                            $tabel.='<td>
                        <a href="'.url('edit',['id'=>$values->id]).'" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>
                        </td>';
                        }else{
                            $tabel.='<td></td>';
                        }
                        $tabel.='</tr>';
                    }
                }

            }
            $tabel.='</tbody></table>';
            $tabel.=$detailrisk->links();
            }else{
                $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>KPI</th>
                    <th>Risiko</th>
                    <th>Peluang</th>
                    <th>Kelompok</th>
                    <th width="10%">Kaidah</th>
                    <th>Dampak</th>
                    <th>Warna</th>
                    <th>Sumber risiko</th>
                    <th>Indikator</th>
                    <th>Nilai ambang</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="12" align="center"><b>Tidak Ada Data</b></td></tr></tbody></table>';
            
            }
            $status = 0;
            $cekkpinull = Kpi::byId($request->periode)->byStatus($status)->byUnit($unitid)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($request->periode)->byUnit($unitid)->get();
            $jmlkpiall = count($cekkpiall);

            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($request->periode)->byStatus($statusinput)->byUnit($unitid)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);
            
            
        }else{
           
            $risikobisnis = Risikobisnis::byId($periodeaktif->id)->byUnit($unitid)->first();
            if($risikobisnis==null){
                $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Kelompok</th>
                <th width="10%">Kaidah</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            $tabel.='</tbody></table>';
            }else{
                $status = 0;
            $cekkpinull = Kpi::byId($periodeaktif->id)->byStatus($status)->byUnit($unitid)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($periodeaktif->id)->byUnit($unitid)->get();
            $jmlkpiall = count($cekkpiall);

            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($periodeaktif->id)->byStatus($statusinput)->byUnit($unitid)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);
            $tabel='';
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->paginate(10);
            $detailrisk->withPath('resikobisnis?periode='.$request->periode.'&_token=cZYtqdssnfDLjJZxC8D5wfbsmCFksv1H1oNHIkPx');
            $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Kelompok</th>
                <th width="10%">Kaidah</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'matrikrisiko.tingkat')
                ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                ->join("matrikrisiko",function($join){
                    $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                         ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                    })
                ->leftjoin("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
                    ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");
                })
                ->get();
                $kpi = Kpi::where('id',$data->kpi_id)->first();
                $jmldetailkpi = count($detailkpi);
                
                $tabel.='<tr>';
                if($jmldetailkpi > 1){
                    $tabel.='<td rowspan="'.$jmldetailkpi.'">'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $tabel.='<td>'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td>'.$data->namakpi.'</td>';
                    }
                    
                }
                foreach($detailkpi as $keys=>$values){
                    if($keys==0){
                        $tabel.='
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                        <td>
                        </td>';
                        $tabel.='</tr>';
                    }else{
                        $tabel.='<tr>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                        <td>
                        </td>';
                        $tabel.='</tr>';
                    }
                }

            }
            $tabel.='</tbody></table>';
            $tabel.=$detailrisk->links();
            }
            

        }
        

        $kpi = Kpi::tahunAktif($periodeaktif->tahun)->get();
        $klasifikasi = Klasifikasi::get();
        $peluang = Peluang::get();
        $dampak = Dampak::orderBy('level', 'DESC')->get();
        $kategori = Kategori::get();
        

        return view('resiko.resikobisnisatasan.index', compact(
            'risikobisnis', 'periodeaktif', 'kpi','klasifikasi','peluang','periodeall','periode','unitkerja','namarisiko','unituser','jmlkpinull','jmlkpiall',
            'jmlkpisudahinput','tabel'
        ));
    }
    function cek_kri($jenis,$param){
        $hsl='';
        if($jenis=='1'||$jenis=='4'||$jenis=='5'||$jenis=='7'){
            $hsl.='<p class="text-red">'.$param.'</p>';
        }else{
            $hsl.=''.$param.'';
        }
        return $hsl;
    }
    function validasibisnis(Request $request,$id){
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '4']);    
        if($risikobisnis){
            $user = Auth::user();
            $retval    = [];
            $retval = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$user->nik, false, stream_context_create($this->arrContextOptions));
        
            $jessval   =json_decode($retval);
            $personnel_no     = $jessval->personnel_no;
            $name             = $jessval->name;
            $position_name    = $jessval->position_name;
            
            $dtval = new Validasibisnis();
            $dtval->risikobisnis_id     =  $id;
            $dtval->nik     =  $personnel_no;
            $dtval->nama    =  $name;
            $dtval->jabatan =  $position_name;
            $dtval->aktorvalidasi_id = 3;
            $dtval->statusvalidasi_id =4;
            $dtval->tglvalidasi =date("Y-m-d H:i:s");
            $dtval->save();

            $hsl='success';
            return $hsl;
        }
        return Redirect::back()->withErrors(['msg', 'Error']);
    }
    function batalvalidasibisnis(Request $request,$id){
        //dapatkan informasi user
        $user = Auth::user();
        $datariskbisnis = Risikobisnis::where('id',$id)->first();
        
        if($datariskbisnis->statusrisiko_id > 4){
            $hsl='gagal';
            return $hsl;
        }else{
            $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '3']);
            if($risikobisnis){
                $hapus = Validasibisnis::where('nik',$user->nik)->where('risikobisnis_id',$id)->delete();
                $hsl='success';
                return $hsl;
            }
        }
        
        return Redirect::back()->withErrors(['msg', 'Error']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $unitid = $user->unit_id;
        $riskdetail = Risikobisnisdetail::where('id',$id)->first();
        $riskbisnis = Risikobisnis::where('id',$riskdetail->risikobisnis_id)->first();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $kpi = Kpi::tahunAktif($periodeaktif->tahun)->byUnit($unitid)->get();
        $klasifikasi = Klasifikasi::get();
        $peluang = Peluang::get();
        $kriteria = Kriteria::where('dampak_id',$riskdetail->dampak_id)->where('kategori_id',$riskdetail->kategori_id)->first();
        $matrik = Matrikrisiko::where('dampak_id',$riskdetail->dampak_id)->where('peluang_id',$riskdetail->peluang_id)->first();
        // dd($matrik);
        $sumberrisiko = Sumberrisiko::where('risikobisnisdetail_id',$riskdetail->id)->get();
        
        $dampak = Dampak::orderBy('level', 'DESC')->get();
        $kategori = Kategori::get();
        $hsl='';
        $hsl.='<table class="table table-bordered table-striped">';
        $hsl.='<tr><td><b>LEVEL</b></td><td><b>DAMPAK</b></td>';
        foreach($kategori as $rkat){
            $hsl.='<td><b>'.strtoupper($rkat->nama).'</b></td>';
        }
        
        foreach($dampak as $key=>$value){
            $hsl.='<tr><td><b>'.$value->level.'</b></td><td><b>'.$value->nama.'</b></td>';
            
            foreach($kategori as $keykat=>$valkat){
                $hsl.='<td>';
                $hsl.=$this->getkriteria($value->id,$valkat->id,$value->level);
                $hsl.='</td>';}
            
            $hsl.='</tr>';
        }
        $hsl.='</tr></table>';
        $hasildampak = $hsl;
        
        return view('resiko.resikobisnisatasan.editrisikopimpinan', compact('riskdetail','riskbisnis','kpi','klasifikasi','peluang','kriteria','matrik','hasildampak','sumberrisiko'));
        
    }
    public function getkriteria($dampakid,$kategoriid,$level){
        $hsl='';
        $kriteria = Kriteria::where('dampak_id',$dampakid)->where('kategori_id',$kategoriid)->where('level',$level)->get();
            //$hsl.='<ul>';
            $no=0;
            foreach($kriteria as $rkri){
                $no++;
                if(count($kriteria)>1){
                    $hsl.='<a href="#" onclick="pilihdampak(\'' .$rkri->nama. '\','.$dampakid.','.$kategoriid.','.$level.')">'.$no.')'.$rkri->nama.'</a><hr><br>';
                }else{
                    $hsl.='<a href="#" onclick="pilihdampak(\'' .$rkri->nama. '\','.$dampakid.','.$kategoriid.','.$level.')">'.$rkri->nama.'</a><br>';
                }
                
            }
            //$hsl.='</ul>';
        return $hsl;
    }
    public function getmatrixrisiko(Request $request,$peluangid,$dampakid){
        //return $peluangid."-".$dampakid;
        $matrik = Matrikrisiko::where('peluang_id',$peluangid)->where('dampak_id',$dampakid)->first();
        //dd($matrik);
        return $matrik;


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        //dd($user->roles[0]->name);
        $idriskdetail   = $request->idriskdetail;
        $periode        = $request->periode;
        $tahun          = $request->tahun;
        $kpi            = $request->kpi;
        $risiko         = $request->risiko;
        $akibat         = $request->akibat;
        $klasifikasi    = $request->klasifikasi;
        $peluang        = $request->peluang;
        $iddampak       = $request->iddampak;
        $idkategori     = $request->idkategori;
        $warna          = $request->warna;
        $sumberrisiko   = $request->sumberrisiko;
        $mitigasi       = $request->mitigasi;
        $biaya          = $request->biaya;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;
        $pic            = $request->pic;
        $status         = $request->status;
        $indikator      = $request->indikator;
        $nilaiambang    = $request->nilaiambang;

        $dataupdate = ['kpi_id'=>$kpi,'risiko'=>$risiko,'akibat'=>$akibat,'klasifikasi_id'=>$klasifikasi,
        'peluang_id'=>$peluang,'dampak_id'=>$iddampak,'warna'=>$warna,'indikator'=>$indikator,'nilaiambang'=>$nilaiambang,
        'modifier'=>$user->nik
        ];

        $riskdetail = Risikobisnisdetail::where('id',$idriskdetail)
        ->update($dataupdate);
        if($riskdetail){
            Sumberrisiko::where('risikobisnisdetail_id',$idriskdetail)->delete();
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){
                    $datasumber = new Sumberrisiko();
                    $datasumber->risikobisnisdetail_id    = $idriskdetail;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->save();
                }
            }
            return redirect()
            ->route('resikobisnispimpinan.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update risiko!'
            ]);
            
        }else{
            return redirect()
            ->route('resikobisnispimpinan.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update risiko!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
