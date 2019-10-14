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
          $role = Role::findByName('verifikatur');
          $users = $role->users;
          $nikuser = $user->nik;
          
          $unitid = $user->unit_id;
          $unitkerja = Unitkerja::where('objectabbr',$unitid)->get();
          $periodeall = Perioderisikoproject::get();
          $periodeaktif = Perioderisikoproject::periodeAktif()->first();
          $unituser = unitkerja::where('objectabbr',$unitid)->first();
          
          $risikoproject = risikoproject::byPeriod($periodeaktif->nama)
              ->byYear($periodeaktif->tahun)
              ->byUnit($unitid)
              ->first();
          if(isset($request->periode)){
             $pecahperiod = explode("-",$request->periode);
             $namaperoiod = $pecahperiod[0];
             $tahunperiod = $pecahperiod[1];
             $risikoproject = risikoproject::byPeriod($namaperoiod)
              ->byYear($tahunperiod)
              ->byUnit($unitid)
              ->first();
              
          }else{
              $risikoproject = risikoproject::byPeriod($periodeaktif->nama)
              ->byYear($periodeaktif->tahun)
              ->byUnit($unitid)
              ->first();
              
  
          }
          $status = null;
          
          $klasifikasi = Klasifikasi::get();
          $peluang = Peluangproject::get();
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
          // dd($risikoproject->risikoprojectdetail[0]);
          return view('resiko.risikoprojectverif.index', compact(
              'risikoproject', 'periodeaktif','klasifikasi','peluang','hasildampak','periodeall','periode','unitkerja','namarisiko','unituser','nikuser'
          ));
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
