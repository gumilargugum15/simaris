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
use App\Komentar;
use Illuminate\Support\Facades\Auth;

class RiskbisnisverifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ public $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=> false,
            "verify_peer_name"=> false,
        ),
      );

    public function index(Request $request)
    {
        $namarisiko ="Risiko Bisnis";
        $user = Auth::user();
        $nikuser = $user->nik;
        $unitkerja = Unitkerja::get();
        // dd($unitkerja);
        $periodeall = Perioderisikobisnis::get();
        if(isset($request->periode ) && isset($request->unitkerja)){
           $pecahperiod = explode("-",$request->periode);
           $namaperoiod = $pecahperiod[0];
           $tahunperiod = $pecahperiod[1];
           $risikobisnis = Risikobisnis::byPeriod($namaperoiod)
            ->byYear($tahunperiod)
            ->byUnit($request->unitkerja)
            // ->byStatusrisk('1')
            ->first();
            
            
        }
    
        return view('resiko.risikobisnisverifi.index', compact('risikobisnis','periodeall','namarisiko','unitkerja','nikuser'));
    }
    function validasibisnis(Request $request,$id){
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '3']);    
        if($risikobisnis){
            $user = Auth::user();
            $retval    = [];
            //$retval    = file_get_contents('http://eos.krakatausteel.com/api/structdisp/'.$user->nik);
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
            $dtval->aktorvalidasi_id = 2;
            $dtval->statusvalidasi_id =3;
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
        
        if($datariskbisnis->statusrisiko_id > 3){
            $hsl='gagal';
            return $hsl;
        }else{
            $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '2']);
            if($risikobisnis){
                $hapus = Validasibisnis::where('nik',$user->nik)->where('risikobisnis_id',$id)->delete();
                $hsl='success';
                return $hsl;
            }
        }
        
        return Redirect::back()->withErrors(['msg', 'Error']);
    }
    public function sesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['kaidah'=>1,'tglkaidah'=>date("Y-m-d H:i:s")]);
        }

    }
    public function tidaksesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['kaidah'=>0,'tglkaidah'=>date("Y-m-d H:i:s")]);
        }

    }
    public function highlight(Request $request){
        $highlight         = $request->kaidah;
        foreach($highlight as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['highlight'=>1,'tglhighlight'=>date("Y-m-d H:i:s")]);
        }

    }
    public function batalhighlight(Request $request){
        $highlight         = $request->kaidah;
        foreach($highlight as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['highlight'=>0,'tglhighlight'=>date("Y-m-d H:i:s")]);
        }

    }
    public function readkomen(Request $request,$id){
        $komen = Komentar::where('risikobisnisdetail_id',$id)->orderBy('id', 'DESC')->get();
        return $komen;

    }
    public function kirimkomentar(Request $request){
        $user = Auth::user();
        $roles = Auth::user()->roles;
        $message    = $request->message;
        $id         = $request->idrisiko;
        $detid      = $request->detailrisikoid;

        $dtval = new Komentar();
        $dtval->risikobisnisdetail_id  =  $detid;
        $dtval->risikobisnis_id        =  $id;
        $dtval->nik      =  $user->nik;
        $dtval->nama     =  $user->name;
        $dtval->komentar =  $message;
        $dtval->creator  =  $user->nik;
        $dtval->save();

        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '1']);
            if($risikobisnis){
                $hapus = Validasibisnis::where('nik',$user->nik)->where('risikobisnis_id',$id)->delete();
            }
        
    }
    public function kpi(Request $request){
        $user = Auth::user();
        $unitid = $user->unit_id;
        $judul = "KPI";
        $kpi =Kpi::tahunAktif()
        ->join('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->select('kpi.*', 'unitkerja.nama as namaunit')
        // ->byUnit($unitid)
        ->get();
        return view('resiko.risikobisnisverifi.kpiindex', compact('judul', 'kpi'));
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
