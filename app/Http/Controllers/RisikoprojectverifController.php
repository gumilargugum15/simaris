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
        $periodeall = Perioderisikoproject::get();
        if(isset($request->periode ) && isset($request->unitkerja)){
           $pecahperiod = explode("-",$request->periode);
           $namaperoiod = $pecahperiod[0];
           $tahunperiod = $pecahperiod[1];
           $risikoproject = risikoproject::byPeriod($namaperoiod)
            ->byYear($tahunperiod)
            ->byUnit($request->unitkerja)
            ->first();
           
        }
    
        return view('resiko.risikoprojectverif.index', compact('risikoproject','periodeall','namarisiko','unitkerja','nikuser'));
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
