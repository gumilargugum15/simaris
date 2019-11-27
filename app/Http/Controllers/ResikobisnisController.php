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
use Storage;
use File;
use App\Komentar;
use App\Komentar_detail;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Otorisasi;
use App\Imports\KpiImport;
use Maatwebsite\Excel\Facades\Excel;
class ResikobisnisController extends Controller
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
        $role = Role::findByName('verifikatur');
        $users = $role->users;
        $nikuser = $user->nik;
        
        $unitid = $user->unit_id;
        $unitkerja = Unitkerja::where('objectabbr',$unitid)->get();
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
       
        $risikobisnis = Risikobisnis::byId($periodeaktif->id)->byUnit($unitid)->first();
        
        if(isset($request->periode)){
       
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($unitid)->first();
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
            $status = 0;
            $cekkpinull = Kpi::byId($periodeaktif->id)->byStatus($status)->byUnit($unitid)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($periodeaktif->id)->byUnit($unitid)->get();
            $jmlkpiall = count($cekkpiall);
    
            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($periodeaktif->id)->byStatus($statusinput)->byUnit($unitid)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);
            

        }
       
    
        $kpi = Kpi::byId($periodeaktif->id)->get();
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
            'risikobisnis', 'periodeaktif', 'kpi','klasifikasi','peluang','hasildampak','periodeall','periode','unitkerja','namarisiko','unituser','nikuser','jmlkpinull','jmlkpiall',
            'jmlkpisudahinput'
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
            'statussumber'=>$value->statussumber,
            'file'=>$value->file
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
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
        $kpi = Kpi::tahunAktif($periodeaktif->tahun)
        ->leftJoin('level_kpi', 'level_kpi.id', '=', 'kpi.level')
        ->select('kpi.*','level_kpi.nama as namalevel','level_kpi.warnatext')
        ->byUnit($unitid)
        ->byId($periodeaktif->id)
        ->orderby('level','desc')->get();
        // dd($kpi);
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
        // if($request->gambar!=null){
        //     $path = $request->gambar->store('');
        // }
        $this->validate($request,[
            'sumberrisiko' => 'required',
            'mitigasi' => 'required',
            'biaya' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'pic' => 'required',
            'status' => 'required'
         ]);

        $unitid         = $request->unitid;
        $periodeid      = $request->periodeid;
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
        $gambar         = $request->gambar;
        //dd($gambar);
        
        //dapatkan informasi user
        $user = Auth::user();
        
        //cari risiko bisnis berdasarkan periode,tahun dan unit id
        // $countrisk = Risikobisnis::byPeriod($periode)
        //     ->byYear($tahun)
        //     ->byUnit($unitid)
        //     ->count();
        $countrisk = Risikobisnis::byId($periodeid)->byUnit($unitid)->count();
        
       if( $countrisk > 0){
        //cari data risk
        // $risikobisnis = Risikobisnis::byPeriod($periode)
        //     ->byYear($tahun)
        //     ->byUnit($unitid)
        //     ->first();
        $risikobisnis = Risikobisnis::byId($periodeid)->byUnit($unitid)->first();
        
        $datariskdetail = new Risikobisnisdetail();
        $datariskdetail->risikobisnis_id            = $risikobisnis->id;
        $datariskdetail->kpi_id                     = $kpi;
        $datariskdetail->risiko                     = $risiko;
        $datariskdetail->akibat                     = $akibat;
        $datariskdetail->klasifikasi_id             = $klasifikasi;
        $datariskdetail->peluang_id                 = $peluang;
        $datariskdetail->dampak_id                  = $iddampak;
        $datariskdetail->kategori_id                = $idkategori;
        $datariskdetail->warna                      = $warna;
        $datariskdetail->indikator                  = $indikator;
        $datariskdetail->nilaiambang                = $nilaiambang;
        $datariskdetail->creator                    = $user->nik;
        $datariskdetail->perioderisikobisnis_id     = $periodeid;
        $datariskdetail->jenisrisiko                = '';
        $datariskdetail->delete                     = '0';
        $datariskdetail->save();
        if($datariskdetail){
            $updatekpi = Kpi::where('id',$kpi)->update(['status'=>'1']);
            if($risikobisnis->statusrisiko_id=='0'){
                $risikobisnis = Risikobisnis::where('id',$risikobisnis->id)->update(['statusrisiko_id' => '1']);
            }
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){
                    $path ='';
                    
                    if($gambar[$key]<>null){
                        $path = $gambar[$key]->store('risikobisnis');
                    }
                    
                    $datasumber = new Sumberrisiko();
                    $datasumber->risikobisnisdetail_id    = $datariskdetail->id;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->file                     = $path;
                    $datasumber->perioderisikobisnis_id   = $periodeid;
                    $datasumber->delete                     = '0';
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
           $datarisk = new Risikobisnis();
           $datarisk->periode                   = $periode;
           $datarisk->tahun                     = $tahun;
           $datarisk->unit_id                   = $unitid;
           $datarisk->statusrisiko_id           = 0;
           $datarisk->perioderisikobisnis_id    = $periodeid;
           $datarisk->creator                   = $user->nik;
           $datarisk->save();

        //    $risikobisnis = Risikobisnis::byPeriod($periode)
        //     ->byYear($tahun)
        //     ->byUnit($unitid)
        //     ->first();

            $risikobisnis = Risikobisnis::byId($periodeid)->byUnit($unitid)->first();
        
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
            $datariskdetail->perioderisikobisnis_id     = $periodeid;
            $datariskdetail->jenisrisiko                = '';
            $datariskdetail->delete                     = '0';
            $datariskdetail->save();
            if($datariskdetail){
            $updatekpi = Kpi::where('id',$kpi)->update(['status'=>'1']);
            if($risikobisnis->statusrisiko_id=='0'){
                $risikobisnis = Risikobisnis::where('id',$risikobisnis->id)->update(['statusrisiko_id' => '1']);
            }
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){

                    $path ='';
                    $pathurl='';
                    if(isset($gambar[$key])){
                        $path = $gambar[$key]->store('risikobisnis');
                    }

                    $datasumber = new Sumberrisiko();
                    $datasumber->risikobisnisdetail_id    = $datariskdetail->id;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->file                     = $path;
                    $datasumber->perioderisikobisnis_id   = $periodeid;
                    $datasumber->delete                   = '0';
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



        // return redirect()
        // ->route('resikobisnis.index')
        //     ->with('flash_notification', [
        //         'level' => 'warning',
        //         'message' => 'Risiko bisnis belum disetting oleh admin gcg!'
        //     ]);
           
       }
       
       

    }
    function validasibisnis(Request $request,$id){
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '2']);    
        if($risikobisnis){
            $user = Auth::user();
            $retval    = [];
            //$retval    = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$user->nik);
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
        $user = Auth::user();
        $unitid = $user->unit_id;
        $riskdetail = Risikobisnisdetail::where('id',$id)->first();
        $riskbisnis = Risikobisnis::where('id',$riskdetail->risikobisnis_id)->first();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $kpi = Kpi::tahunAktif($periodeaktif->tahun)->byUnit($unitid)->byId($periodeaktif->id)->get();
        $klasifikasi = Klasifikasi::get();
        $peluang = Peluang::get();
        $kriteria = Kriteria::where('dampak_id',$riskdetail->dampak_id)->where('kategori_id',$riskdetail->kategori_id)->first();
        $matrik = Matrikrisiko::where('dampak_id',$riskdetail->dampak_id)->where('peluang_id',$riskdetail->peluang_id)->first();
        // dd($matrik);
        $sumberrisiko = Sumberrisiko::where('risikobisnisdetail_id',$riskdetail->id)->get();
        $sumberrisiko = $sumberrisiko->map(function($item, $key){
            $item->filex = $item->file;
            $item->file = Storage::url($item->file);
            return $item;
        });
        //  dd($sumberrisiko);
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
    public function update(Request $request)
    {
        $this->validate($request,[
            'sumberrisiko' => 'required',
            'mitigasi' => 'required',
            'biaya' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'pic' => 'required',
            'status' => 'required'
         ]);
        $user = Auth::user();
        //dd($user->roles[0]->name);
        $idriskdetail   = $request->idriskdetail;
        $periodeid      = $request->periodeid;
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
        $gambar         = $request->gambar;
        $sumberid       = $request->sumberid;
        $gambarfile     = $request->gambarfile;
        
        // dd($gambarfile);

        $dataupdate = ['kpi_id'=>$kpi,'risiko'=>$risiko,'akibat'=>$akibat,'klasifikasi_id'=>$klasifikasi,
        'peluang_id'=>$peluang,'dampak_id'=>$iddampak,'warna'=>$warna,'indikator'=>$indikator,'nilaiambang'=>$nilaiambang,
        'modifier'=>$user->nik,'perioderisikobisnis_id'=>$periodeid
        ];

        $riskdetail = Risikobisnisdetail::where('id',$idriskdetail)
        ->update($dataupdate);
        if($riskdetail){
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){
                    $path='';
                    
                    if($sumberid[$key]==null){
                    if($gambar[$key]<> null){
                        $path = $gambar[$key]->store('risikobisnis');
                    }
                    $datasumber = new Sumberrisiko();
                    $datasumber->risikobisnisdetail_id    = $idriskdetail;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->file                     = $path;
                    $datasumber->perioderisikobisnis_id   = $periodeid;
                    $datasumber->save();
                    }else{

                    if(isset($gambar[$key])){
                        Storage::delete($gambarfile[$key]);
                        $path = $gambar[$key]->store('risikobisnis');
                        $datasumber = [
                            'namasumber'=>$value,'mitigasi'=>$mitigasi[$key],'biaya'=>$biaya[$key],
                            'start_date'=>$startdate[$key],'end_date'=>$enddate[$key],'pic'=>$pic[$key],'statussumber'=>$status[$key],'file'=>$path
                        ];
                    $sumberrisk = Sumberrisiko::where('id',$sumberid[$key])->update($datasumber);

                    }else{
                        
                        $datasumber = [
                            'namasumber'=>$value,'mitigasi'=>$mitigasi[$key],'biaya'=>$biaya[$key],
                            'start_date'=>$startdate[$key],'end_date'=>$enddate[$key],'pic'=>$pic[$key],'statussumber'=>$status[$key]
                        ];
                    $sumberrisk = Sumberrisiko::where('id',$sumberid[$key])->update($datasumber);

                    }
                    
                    }
                    
                }
            }
            return redirect()
            ->route('resikobisnis.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update risiko!'
            ]);
            
        }else{
            return redirect()
            ->route('resikobisnis.index')
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
    public function destroy(Request $request, $id)
    {
        $data = ['delete'=>1];
        $destroydetail = Risikobisnisdetail::where('id',$id)->update($data);
       //$destroydetail =  Risikobisnisdetail::where('id',$id)->delete();
       if($destroydetail){
        $datasumber = ['delete'=>1];
        Sumberrisiko::where('risikobisnisdetail_id',$id)->update($datasumber);
        $riskdetail = Risikobisnisdetail::where('id',$id)->first();
        $kpiid =  $riskdetail->kpi_id;
        
        $riskdetailkpi = Risikobisnisdetail::where('kpi_id',$kpiid)->where('delete',0)->get();
        $jmlkpirisk = count($riskdetailkpi);
        if($jmlkpirisk == 0){
            $datakpi = ['status'=>0];
            Kpi::where('id',$kpiid)->update($datakpi);
        }
        return redirect()
            ->route('resikobisnis.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus risiko!'
            ]);
       }else{
        return redirect()
        ->route('resikobisnis.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus risiko !'
            ]);
       }
    }
    public function kpi(Request $request){
        $user = Auth::user();
        $dataoto = Otorisasi::where('nik',$user->nik)->first();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unitid = $user->unit_id;
        $cekutama = Kpi::where('utama','Y')->where('deleted',0)->byId($periodeaktif->id)->byUnit($unitid)->get();
        $jmlkpiutama = count($cekutama);
        $cekhight = Kpi::where('level','2')->where('deleted',0)->byId($periodeaktif->id)->byUnit($unitid)->get();
        $jmlkpihight = count($cekhight);
        $cekbiasa = Kpi::where('level','1')->where('deleted',0)->byId($periodeaktif->id)->byUnit($unitid)->get();
        $jmlkpibiasa = count($cekbiasa);
        $judul = "KPI";
        $kpi =Kpi::leftJoin('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->leftJoin('level_kpi', 'level_kpi.id', '=', 'kpi.level')
        ->join('perioderisikobisnis', 'perioderisikobisnis.id', '=', 'kpi.perioderisikobisnis_id')
        ->select('kpi.*', 'unitkerja.nama as namaunit','level_kpi.nama as namalevel','level_kpi.warna','perioderisikobisnis.nama as namaperiode','perioderisikobisnis.tahun as tahunperiode')
        ->byUnit($unitid)
        ->where('kpi.deleted',0)
        ->orderby('level','desc')
        ->get();
        return view('resiko.resikobisnis.kpiindex', compact('judul', 'kpi','dataoto','periodeaktif','jmlkpiutama','jmlkpihight','jmlkpibiasa'));
    }
    public function addkpi(){
        $user = Auth::user();
        $unitid = $user->unit_id;
        $unitkerja = Unitkerja::byUnit($unitid)->get();
        return view('resiko.resikobisnis.addkpi', compact('unitkerja'));
    }
    public function storekpi(Request $request){
        $kode         = $request->kode;
        $nama         = $request->nama;
        $unit         = $request->unit;
        $tahun        = $request->tahun;

        $user = Auth::user();
        $datakpi = new Kpi();
        $datakpi->kode             = $kode;
        $datakpi->nama             = $nama;
        $datakpi->unit_id          = $unit;
        $datakpi->tahun            = $tahun;
        $datakpi->creator          = $user->nik;
        $datakpi->save();
        if($datakpi){
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan KPI!'
            ]);
        }
    }
    public function editkpi(Request $request,$id)
    {
        $user = Auth::user();
        $unitid = $user->unit_id;
        $kpi = Kpi::where('id',$id)->first();
        $unitkerja = Unitkerja::byUnit($unitid)->get();
        return view('resiko.resikobisnis.editkpi', compact('kpi','unitkerja'));
    }
    public function updatekpi(Request $request)
    {
        $id           = $request->id;
        $kode         = $request->kode;
        $nama         = $request->nama;
        $unit         = $request->unit;
        $tahun        = $request->tahun;
        $user         = Auth::user();

        $dataupdate = ['kode'=>$kode,'nama'=>$nama,'unit_id'=>$unit,'tahun'=>$tahun,'tahun'=>$tahun,'modifier'=>$user->nik];

        $Kpi = Kpi::where('id',$id)->update($dataupdate);
        if($Kpi){
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal update KPI!'
            ]);
        }

    }
    public function destroykpi(Request $request, $id)
    {
        $delete =  Kpi::where('id',$id)->delete();
        if($delete){
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus KPI!'
            ]);
        }

    }
    public function kirimkomentarkeyperson(Request $request){

        $user = Auth::user();
        $role = Role::findByName('verifikatur');
        $users = $role->users;
        
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

        foreach ($users as $users){
            $komendet = new Komentar_detail();
            $komendet->komentar_id   = $dtval->id;
            $komendet->risikobisnisdetail_id  =  $detid;
            $komendet->nik   = $users->nik;
            $komendet->nama  = $users->name;
            $komendet->baca  = 0;
            $komendet->save();
        }

        
    }
    public function levelbiasa(Request $request){
        $level         = $request->level;
        foreach($level as $key=>$value){
            $kpi = Kpi::where('id',$value)->update(['level'=>1]);
        }

    }
    public function levelhight(Request $request){
        $level         = $request->level;
        foreach($level as $key=>$value){
            $kpi = Kpi::where('id',$value)->update(['level'=>2]);
        }

    }
    public function kpiutama(Request $request){
        $level         = $request->level;
        foreach($level as $key=>$value){
            $kpi = Kpi::where('id',$value)->update(['utama'=>'Y']);
        }

    }
    public function batalkpiutama(Request $request){
        $level         = $request->level;
        foreach($level as $key=>$value){
            $kpi = Kpi::where('id',$value)->update(['utama'=>'N']);
        }

    }
    public function importkpikeyperson(Request $request) 
    {
        $import = Excel::import(new KpiImport, request()->file('excel'));
        
        if($import){
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil import KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpikeyperson.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal import KPI!'
            ]);
        }
    }
}
