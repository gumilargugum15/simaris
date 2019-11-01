<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Risikoproject;
use App\Unitkerja;
use App\Statusrisiko;
use App\Risikoprojectdetail;
use App\Validasiproject;
use App\Sumberrisikoproject;
use App\Peluangproject;
use App\Dampak;
use App\Kategori;
use App\Kriteria;
use App\Perioderisikoproject;
use App\Klasifikasi;
use App\Matrikrisiko;
use App\Project;
use App\Tahapproject;
use Storage;
use File;
use App\Komentar;
use App\Komentar_detail;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Otorisasi;
class RisikoprojectverifController extends Controller
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
        $namarisiko ="Risiko Project";
        $user = Auth::user();
        $nikuser = $user->nik;
        $unitkerja = Unitkerja::get();
        $project = Project::get();
        // dd($project);
        $periodeall = Perioderisikoproject::get();
        if(isset($request->periode ) && isset($request->project)){
           $projectid   = $request->project;
           $pecahperiod = explode("-",$request->periode);
           $namaperoiod = $pecahperiod[0];
           $tahunperiod = $pecahperiod[1];
           $risikoproject = risikoproject::byPeriod($namaperoiod)
            ->byYear($tahunperiod)
            // ->byUnit($request->unitkerja)
            ->byProject($projectid)
            ->first();
           
        }
    
        return view('resiko.risikoprojectverif.index', compact('risikoproject','periodeall','namarisiko','unitkerja','nikuser','project'));
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
    function validriskproject(Request $request,$id){
        $risikoproject = Risikoproject::where('id',$id)->update(['statusrisiko_id' => '3']);    
        if($risikoproject){
            $user = Auth::user();
            $retval    = [];
            //$retval    = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$user->nik);
            $retval = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$user->nik, false, stream_context_create($this->arrContextOptions));
        
            $jessval   =json_decode($retval);
            $personnel_no     = $jessval->personnel_no;
            $name             = $jessval->name;
            $position_name    = $jessval->position_name;
            
            $dtval = new Validasiproject();
            $dtval->risikoproject_id     =  $id;
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
    function batalvalidriskproject(Request $request,$id){
        $user = Auth::user();
        $datariskproject = Risikoproject::where('id',$id)->first();
        
        if($datariskproject->statusrisiko_id > 3){
            $hsl='gagal';
            return $hsl;
        }else{
            $risikoproject = Risikoproject::where('id',$id)->update(['statusrisiko_id' => '2']);
            if($risikoproject){
                $hapus = Validasiproject::where('nik',$user->nik)->where('risikoproject_id',$id)->delete();
                $hsl='success';
                return $hsl;
            }
        }
        
        return Redirect::back()->withErrors(['msg', 'Error']);
        
    }
    public function sesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikoprojectdetail::where('id',$value)->update(['kaidah'=>1,'tglkaidah'=>date("Y-m-d H:i:s")]);
        }

    }
    public function tidaksesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikoprojectdetail::where('id',$value)->update(['kaidah'=>0,'tglkaidah'=>date("Y-m-d H:i:s")]);
        }

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
