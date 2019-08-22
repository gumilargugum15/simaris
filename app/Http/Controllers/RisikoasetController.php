<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitkerja;
use App\Statusrisiko;
use App\Peluang;
use App\Dampak;
use App\Kategori;
use App\Kriteria;
use App\Kelompokaset;
use App\Matrikrisiko;
use App\Perioderisikoaset;
use App\Risikoaset;
use App\Sensitivitaskriteria;
use App\sensitivitaskritikalitas;
use App\Kritikalitassensitivitasdesk;
use Storage;
use File;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Otorisasi;
class RisikoasetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $namarisiko ="Risiko Aset";
        $user = Auth::user();
        $role = Role::findByName('verifikatur');
        $users = $role->users;
        $nikuser = $user->nik;
        $unitid = $user->unit_id;
        $unitkerja = Unitkerja::where('objectabbr',$unitid)->get();
        $periodeall = Perioderisikoaset::get();
        $periodeaktif = Perioderisikoaset::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
        $jmlkpinull=0;
        $risikoaset = Risikoaset::
        byPeriod($periodeaktif->nama)
        ->byYear($periodeaktif->tahun)
        ->byUnit($unitid)
        ->first();
        
        // $risikoaset = $risikoaset[0]->risikoasetdetail->map(function($item,$key){

        //     $where =array('dampak_id'=>$item->dampak_id,'kategori_id'=>$item->kategori_id);
        //     $k =Kriteria::where($where)->first();
        //     $item->kriteria = $k;
        //     return $item;
        //  });
        if(isset($request->periode)){
            $pecahperiod = explode("-",$request->periode);
            $namaperoiod = $pecahperiod[0];
            $tahunperiod = $pecahperiod[1];
            $risikoaset = Risikoaset::byPeriod($namaperoiod)
             ->byYear($tahunperiod)
             ->byUnit($unitid)
             ->first();

           
         }else{
             $risikoaset = Risikoaset::byPeriod($periodeaktif->nama)
             ->byYear($periodeaktif->tahun)
             ->byUnit($unitid)
             ->first();

         }
        //  dd($risikoaset->risikoasetdetail);
         
        return view('resiko.resikoaset.index', compact(
            'risikoaset','periodeaktif', 'periodeall','unitkerja','nikuser','jmlkpinull','unituser','namarisiko'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $unitid = $user->unit_id;
        $periodeaktif = Perioderisikoaset::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
        $kelompokaset = Kelompokaset::get();
        $peluang = Peluang::get();
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

        $sensitivitaskriteria = $this->modalkriteria();
        return view('resiko.resikoaset.addrisiko', compact('periodeaktif','unituser','klasifikasi','peluang','hasildampak','kelompokaset','sensitivitaskriteria'));
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
    function modalkriteria(){
        $sensitivkriteria = Sensitivitaskriteria::get();
        $sensitivitaskritikalitas = Sensitivitaskritikalitas::get();
        $hsl='';
        $hsl.='<table class="table table-bordered table-striped">';
        $hsl.='<tr><td><b>KRITERIA</b></td><td><b>URAIAN</b></td>';
        foreach($sensitivitaskritikalitas as $rkritikal){
            $hsl.='<td><b>'.strtoupper($rkritikal->nama).'</b></td>';
        }
        
        foreach($sensitivkriteria as $key=>$value){
            $hsl.='<tr><td><b>'.$value->nama.'</b></td><td><b>'.$value->uraian.'</b></td>';
            
            foreach($sensitivitaskritikalitas as $keykat=>$valkat){
                $hsl.='<td>';
                $hsl.=$this->getkritikaldesk($value->id,$valkat->id);
                $hsl.='</td>';}
            
            $hsl.='</tr>';
        }
        $hsl.='</tr></table>';
        return $hsl;
    }
    function getkritikaldesk($sensitivkriteriaid,$sensitivkritikid){
        $hsl='';
        $kritik = Kritikalitassensitivitasdesk::where('sensitivitaskriteria_id',$sensitivkriteriaid)->where('sensitivitaskritikalitas_id',$sensitivkritikid)->get();
        // dd($kritik[0]->deskripsi);
        //$hsl.='<ul>';
            $no=0;
            foreach($kritik as $rkri){
                // $no++;
                // if(count($kritik)>1){
                //     $hsl.='<a href="#" onclick="pilihkritikal(\'' .$rkri->deskripsi. '\','.$sensitivkriteriaid.','.$sensitivkritikid.')">'.$no.')'.$rkri->deskripsi.'</a><hr><br>';
                // }else{
                //     $hsl.='<a href="#" onclick="pilihkritikal(\'' .$rkri->deskripsi. '\','.$sensitivkriteriaid.','.$sensitivkritikid.')">'.$rkri->deskripsi.'</a><br>';
                // }
                $hsl.='<a href="#" onclick="pilihkritikal(\'' .$rkri->deskripsi. '\','.$sensitivkriteriaid.','.$sensitivkritikid.')">'.$rkri->deskripsi.'</a><br>';
            }
            return $hsl;
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
