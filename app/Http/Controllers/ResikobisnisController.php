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
class ResikobisnisController extends Controller
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
        
        $risikobisnis = Risikobisnis::byPeriod($periodeaktif->nama)
            ->byYear($periodeaktif->tahun)
            ->byUnit($unitid)
            ->first();
        if(isset($request->periode)){
           $pecahperiod = explode("-",$request->periode);
           $namaperoiod = $pecahperiod[0];
           $tahunperiod = $pecahperiod[1];
           $risikobisnis = Risikobisnis::byPeriod($namaperoiod)
            ->byYear($tahunperiod)
            ->byUnit($unitid)
            ->first();
            
        }else{
            $risikobisnis = Risikobisnis::byPeriod($periodeaktif->nama)
            ->byYear($periodeaktif->tahun)
            ->byUnit($unitid)
            ->first();
            

        }
        $kpi = Kpi::tahunAktif()->get();
        $klasifikasi = Klasifikasi::get();
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

        return view('resiko.resikobisnis.index', compact(
            'risikobisnis', 'periodeaktif', 'kpi','klasifikasi','peluang','hasildampak','periodeall','periode','unitkerja','namarisiko','unituser'
        ));
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
    public function sumberrisiko(Request $request,$id){
        $return = [];
        $sumber = Sumberrisiko::where('risikobisnisdetail_id',$id)->get();
        foreach($sumber as $key => $value){
            array_push($return,
            array(
            'no'=>$key+1,
            'namasumber'=>$value->namasumber,
            'mitigasi'=>$value->mitigasi,
            'biaya'=>$value->biaya,
            'start_date'=>$value->start_date,
            'end_date'=>$value->end_date,
            'pic'=>$value->pic,
            'statussumber'=>$value->statussumber
            )
        );

    }
    //dd($return);
           return array('data'=>$return);
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
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unituser = unitkerja::where('kode',$unitid)->first();
        $kpi = Kpi::tahunAktif()->get();
        $klasifikasi = Klasifikasi::get();
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
        return view('resiko.resikobisnis.addrisiko', compact('periodeaktif','unituser','kpi','klasifikasi','peluang','hasildampak'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unitid         = $request->unitid;
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
        
        //dapatkan informasi user
        $user = Auth::user();
        
        //cari risiko bisnis berdasarkan periode,tahun dan unit id
        $countrisk = Risikobisnis::byPeriod($periode)
            ->byYear($tahun)
            ->byUnit($unitid)
            ->count();
        
       if( $countrisk > 0){
        //cari data risk
        $risikobisnis = Risikobisnis::byPeriod($periode)
            ->byYear($tahun)
            ->byUnit($unitid)
            ->first();
        
        $datariskdetail = new Risikobisnisdetail();
        $datariskdetail->risikobisnis_id    = $risikobisnis->id;
        $datariskdetail->kpi_id             = $kpi;
        $datariskdetail->risiko             = $risiko;
        $datariskdetail->akibat             = $akibat;
        $datariskdetail->klasifikasi_id     = $klasifikasi;
        $datariskdetail->peluang_id         = $peluang;
        $datariskdetail->dampak_id          = $iddampak;
        $datariskdetail->kategori_id        = $idkategori;
        $datariskdetail->warna              = $warna;
        $datariskdetail->indikator          = $indikator;
        $datariskdetail->nilaiambang        = $nilaiambang;
        $datariskdetail->creator            = $user->nik;
        $datariskdetail->save();
        if($datariskdetail){
            if($risikobisnis->statusrisiko_id=='0'){
                $risikobisnis = Risikobisnis::where('id',$risikobisnis->id)->update(['statusrisiko_id' => '1']);
            }
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){
                    $datasumber = new Sumberrisiko();
                    $datasumber->risikobisnisdetail_id    = $datariskdetail->id;
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
            ->route('resikobisnis.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan Risiko!'
            ]);
        }else{
            return redirect()
            ->route('resikobisnis.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan Risiko!'
            ]);
        }
         
       }else{
        return redirect()
        ->route('resikobisnis.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Risiko bisnis belum disetting !'
            ]);
           
       }
       
       

    }
    function validasibisnis(Request $request,$id){
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '2']);    
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
            $dtval->aktorvalidasi_id = 1;
            $dtval->statusvalidasi_id =2;
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
        
        if($datariskbisnis->statusrisiko_id > 2){
            $hsl='gagal';
            return $hsl;
        }else{
            $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '1']);
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
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['kaidah'=>1,'tglkaidah'=>date("Y-m-d H::s")]);
        }

    }
    public function tidaksesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['kaidah'=>0,'tglkaidah'=>date("Y-m-d H::s")]);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $riskdetail = Risikobisnisdetail::where('id',$id)->first();
        $riskbisnis = Risikobisnis::where('id',$riskdetail->risikobisnis_id)->first();
        $kpi = Kpi::tahunAktif()->get();
        $klasifikasi = Klasifikasi::get();
        $peluang = Peluang::get();
        $kriteria = Kriteria::where('dampak_id',$riskdetail->dampak_id)->where('kategori_id',$riskdetail->kategori_id)->first();
        $matrik = Matrikrisiko::where('dampak_id',$riskdetail->dampak_id)->where('peluang_id',$riskdetail->peluang_id)->first();
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
        
        return view('resiko.resikobisnis.editrisiko', compact('riskdetail','riskbisnis','kpi','klasifikasi','peluang','kriteria','matrik','hasildampak','sumberrisiko'));
        
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
