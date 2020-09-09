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

class RiskbisnismanagController extends Controller
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
        $namarisiko ="Risiko Bisnis";
        $user = Auth::user();
        $unitkerja = Unitkerja::get();
        // dd($unitkerja);
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $hsl='';
        if(isset($request->periode ) && isset($request->unitkerja)){
        
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
            if($risikobisnis){
                $hsl='';
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)->where('delete',0)
            ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->paginate(10);
            $detailrisk->withPath('resikobisnisverifikatur?periode='.$request->periode.'&_token=fW4QxaWL7FS0nrPa0bXOXPsi2EgeHMrR1vFpplZb&unitkerja='.$request->unitkerja.'');
            $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
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
            $no =0;
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)->where('kpi_id',$data->kpi_id)->where('delete',0)
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
                $no++;
                $hsl.='<tr>';
                if($jmldetailkpi > 1){
                    $hsl.='<td rowspan="'.$jmldetailkpi.'">'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $hsl.='<td rowspan="'.$jmldetailkpi.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $hsl.='<td rowspan="'.$jmldetailkpi.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $hsl.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $hsl.='<td>'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $hsl.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $hsl.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $hsl.='<td>'.$data->namakpi.'</td>';
                    }
                    
                }
                
                foreach($detailkpi as $keys=>$values){
                    if($keys==0){
                        $hsl.='
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $hsl.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $hsl.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $hsl.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                        <td></td>';
                        $hsl.='</tr>';
                    }else{
                        $hsl.='<tr>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $hsl.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $hsl.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $hsl.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                        <td></td>';
                        $hsl.='</tr>';
                    }
                }
                
            }
           
            $hsl.='</tbody></table>';
            $hsl.=$detailrisk->links();
            }else{
                $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>KPI</th>
                    <th>Pilih</th>
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
                <tbody><tr><td colspan="13" align="center"><b>Tidak Ada Data</b></td></tr></tbody></table>';
                
            }
            $status = 0;
            $cekkpinull = Kpi::byId($request->periode)->byStatus($status)->byUnit($request->unitkerja)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($request->periode)->byUnit($request->unitkerja)->get();
            $jmlkpiall = count($cekkpiall);

            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($request->periode)->byStatus($statusinput)->byUnit($request->unitkerja)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);

            
            
        }else{
            $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Pilih</th>
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
            <tbody></tbody></table>';
        }
    
        return view('resiko.risikobisnismanagergcg.index', compact('risikobisnis','periodeall','namarisiko','unitkerja','periodeaktif','jmlkpinull','jmlkpiall',
        'jmlkpisudahinput','hsl'));
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
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '5']);    
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
            $dtval->aktorvalidasi_id = 4;
            $dtval->statusvalidasi_id =5;
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
        
        if($datariskbisnis->statusrisiko_id > 5){
            $hsl='gagal';
            return $hsl;
        }else{
            $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '4']);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
