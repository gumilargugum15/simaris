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
    public function index(Request $request)
    {
        $namarisiko ="Risiko Bisnis";
        $user = Auth::user();
        $unitid = $user->unit_id;
        $unitkerja = Unitkerja::where('kode',$unitid)->get();
        
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unituser = unitkerja::where('kode',$unitid)->first();
        if(isset($request->periode)){
           $pecahperiod = explode("-",$request->periode);
           $namaperoiod = $pecahperiod[0];
           $tahunperiod = $pecahperiod[1];
           $risikobisnis = Risikobisnis::byPeriod($namaperoiod)
            ->byYear($tahunperiod)
            ->byUnit($unitid)
            //->byStatusrisk('2')
            ->first();
            
        }else{
            $risikobisnis = Risikobisnis::byPeriod($periodeaktif->nama)
            ->byYear($periodeaktif->tahun)
            ->byUnit($unitid)
            ->byStatusrisk('2')
            ->first();
            

        }
        $kpi = Kpi::tahunAktif()->get();
        $klasifikasi = Klasifikasi::get();
        $peluang = Peluang::get();
        $dampak = Dampak::orderBy('level', 'DESC')->get();
        $kategori = Kategori::get();
        

        return view('resiko.resikobisnisatasan.index', compact(
            'risikobisnis', 'periodeaktif', 'kpi','klasifikasi','peluang','periodeall','periode','unitkerja','namarisiko','unituser'
        ));
    }
    function validasibisnis(Request $request,$id){
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '4']);    
        if($risikobisnis){
            $user = Auth::user();
            $retval    = [];
            $retval    = file_get_contents('http://eos.krakatausteel.com/api/structdisp/'.$user->nik);
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
