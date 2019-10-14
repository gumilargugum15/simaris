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
class RisikoprojectController extends Controller
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
        return view('resiko.risikoproject.index', compact(
            'risikoproject', 'periodeaktif', 'kpi','klasifikasi','peluang','hasildampak','periodeall','periode','unitkerja','namarisiko','unituser','nikuser'
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
        $sumber = Sumberrisikoproject::where('risikoprojectdetail_id',$id)->get();
        // dd($sumber);
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
        $periodeaktif = Perioderisikoproject::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
        $klasifikasi = Klasifikasi::get();
        $project = Project::get();
        $tahapproject = Tahapproject::get();
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
        return view('resiko.risikoproject.addrisiko', compact('periodeaktif','unituser','klasifikasi','peluang','hasildampak','project','tahapproject'));
    
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
        $periode        = $request->periode;
        $tahun          = $request->tahun;
        $tahapproject   = $request->tahapproject;
        $project        = $request->project;
        $risiko         = $request->risiko;
        $akibat         = $request->akibat;
        $klasifikasi    = $request->klasifikasi;
        $peluang        = $request->peluang;
        $iddampak       = $request->iddampak;
        $dampak       = $request->dampak;
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
        $countrisk = risikoproject::byPeriod($periode)
            ->byYear($tahun)
            ->byUnit($unitid)
            ->count();
        
       if( $countrisk > 0){
        //cari data risk
        $risikoproject = risikoproject::byPeriod($periode)
            ->byYear($tahun)
            ->byUnit($unitid)
            ->first();
        
        $datariskdetail = new Risikoprojectdetail();
        $datariskdetail->risikoproject_id    = $risikoproject->id;
        $datariskdetail->project_id         = $project;
        $datariskdetail->tahapproject_id    = $tahapproject;
        $datariskdetail->risiko             = $risiko;
        $datariskdetail->akibat             = $akibat;
        $datariskdetail->klasifikasi_id     = $klasifikasi;
        $datariskdetail->peluang_id         = $peluang;
        $datariskdetail->dampak_id          = $iddampak;
        $datariskdetail->namadampak         = $dampak;
        $datariskdetail->kategori_id        = $idkategori;
        $datariskdetail->warna              = $warna;
        $datariskdetail->indikator          = $indikator;
        $datariskdetail->nilaiambang        = $nilaiambang;
        $datariskdetail->creator            = $user->nik;
        $datariskdetail->save();
        if($datariskdetail){
           
            if($risikoproject->statusrisiko_id=='0'){
                $risikoproject = risikoproject::where('id',$risikoproject->id)->update(['statusrisiko_id' => '1']);
            }
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){
                    $path ='';
                    
                    if($gambar[$key]<>null){
                        $path = $gambar[$key]->store('risikoproject');
                    }
                    
                    $datasumber = new Sumberrisikoproject();
                    $datasumber->risikoprojectdetail_id    = $datariskdetail->id;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->file                     = $path;
                    $datasumber->save();

                    
                }
            }
            
            return redirect()
            ->route('risikoproject.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan Risiko!'
            ]);
        }else{
            return redirect()
            ->route('risikoproject.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan Risiko!'
            ]);
        }
         
       }else{
           $datarisk = new Risikoproject();
           $datarisk->periode            = $periode;
           $datarisk->tahun              = $tahun;
           $datarisk->unit_id            = $unitid;
           $datarisk->statusrisiko_id    = 0;
           $datarisk->creator            = $user->nik;
           $datarisk->save();

           $risikoproject = Risikoproject::byPeriod($periode)
            ->byYear($tahun)
            ->byUnit($unitid)
            ->first();
        
            $datariskdetail = new Risikoprojectdetail();
            $datariskdetail->risikoproject_id   = $risikoproject->id;
            $datariskdetail->project_id         = $project;
            $datariskdetail->tahapproject_id    = $tahapproject;
            $datariskdetail->risiko             = $risiko;
            $datariskdetail->akibat             = $akibat;
            $datariskdetail->klasifikasi_id     = $klasifikasi;
            $datariskdetail->peluang_id         = $peluang;
            $datariskdetail->dampak_id          = $iddampak;
            $datariskdetail->namadampak         = $dampak;
            $datariskdetail->kategori_id        = $idkategori;
            $datariskdetail->warna              = $warna;
            $datariskdetail->indikator          = $indikator;
            $datariskdetail->nilaiambang        = $nilaiambang;
            $datariskdetail->creator            = $user->nik;
            $datariskdetail->save();
            if($datariskdetail){
            
            if($risikoproject->statusrisiko_id=='0'){
                $risikoproject = Risikoproject::where('id',$risikoproject->id)->update(['statusrisiko_id' => '1']);
            }
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){

                    $path ='';
                    $pathurl='';
                    if(isset($gambar[$key])){
                        $path = $gambar[$key]->store('risikoproject');
                    }

                    $datasumber = new Sumberrisikoproject();
                    $datasumber->risikoprojectdetail_id    = $datariskdetail->id;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->file                     = $path;
                    $datasumber->save();
                }
            }
            return redirect()
            ->route('risikoproject.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan Risiko!'
            ]);
            }else{
                return redirect()
                ->route('risikoproject.index')
                ->with('flash_notification', [
                    'level' => 'warning',
                    'message' => 'Gagal menyimpan Risiko!'
                ]);
            }

       }
       
       

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
        $riskdetail = Risikoprojectdetail::where('id',$id)->first();
        $riskproject = Risikoproject::where('id',$riskdetail->risikoproject_id)->first();
        $periodeaktif = Perioderisikoproject::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$unitid)->first();
        $klasifikasi = Klasifikasi::get();
        $project = Project::get();
        $tahapproject = Tahapproject::get();
        $peluang = Peluangproject::get();
        $kriteria = Kriteria::where('dampak_id',$riskdetail->dampak_id)->where('kategori_id',$riskdetail->kategori_id)->first();
        $matrik = Matrikrisiko::where('dampak_id',$riskdetail->dampak_id)->where('peluang_id',$riskdetail->peluang_id)->first();
        $sumberrisiko = Sumberrisikoproject::where('risikoprojectdetail_id',$riskdetail->id)->get();
        $sumberrisiko = $sumberrisiko->map(function($item, $key){
            $item->filex = $item->file;
            $item->file = Storage::url($item->file);
            return $item;
        });
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
        return view('resiko.risikoproject.editrisiko', compact('riskdetail','riskproject','periodeaktif','unituser','klasifikasi','peluang','hasildampak','project','tahapproject','kriteria','matrik','sumberrisiko'));
    
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
        $periode        = $request->periode;
        $tahun          = $request->tahun;
        $risiko         = $request->risiko;
        $project        = $request->project;
        $tahapproject   = $request->tahapproject;
        $akibat         = $request->akibat;
        $klasifikasi    = $request->klasifikasi;
        $peluang        = $request->peluang;
        $iddampak       = $request->iddampak;
        $dampak         = $request->dampak;
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

        $dataupdate = ['risiko'=>$risiko,'akibat'=>$akibat,'klasifikasi_id'=>$klasifikasi,
        'peluang_id'=>$peluang,'dampak_id'=>$iddampak,'warna'=>$warna,'indikator'=>$indikator,'nilaiambang'=>$nilaiambang,
        'modifier'=>$user->nik,'project_id'=>$project,'tahapproject_id'=>$tahapproject,'namadampak'=>$dampak
        ];

        $riskdetail = Risikoprojectdetail::where('id',$idriskdetail)
        ->update($dataupdate);
        if($riskdetail){
            
            if($sumberrisiko!=null){
                foreach($sumberrisiko as $key =>$value){
                    $path='';
                    
                    if($sumberid[$key]==null){
                    if($gambar[$key]<> null){
                        $path = $gambar[$key]->store('risikobisnis');
                    }
                    $datasumber = new Sumberrisikoproject();
                    $datasumber->risikoprojectdetail_id    = $idriskdetail;
                    $datasumber->namasumber               = $value;
                    $datasumber->mitigasi                 = $mitigasi[$key];
                    $datasumber->biaya                    = $biaya[$key];
                    $datasumber->start_date               = $startdate[$key];
                    $datasumber->end_date                 = $enddate[$key];
                    $datasumber->pic                      = $pic[$key];
                    $datasumber->statussumber             = $status[$key];
                    $datasumber->file                     = $path;
                    $datasumber->save();
                    }else{

                    if(isset($gambar[$key])){
                        Storage::delete($gambarfile[$key]);
                        $path = $gambar[$key]->store('risikobisnis');
                        $datasumber = [
                            'namasumber'=>$value,'mitigasi'=>$mitigasi[$key],'mitigasi'=>$biaya[$key],
                            'start_date'=>$startdate[$key],'end_date'=>$enddate[$key],'pic'=>$pic[$key],'statussumber'=>$status[$key],'file'=>$path
                        ];
                    $sumberrisk = Sumberrisikoproject::where('id',$sumberid[$key])->update($datasumber);

                    }else{
                        
                        $datasumber = [
                            'namasumber'=>$value,'mitigasi'=>$mitigasi[$key],'mitigasi'=>$biaya[$key],
                            'start_date'=>$startdate[$key],'end_date'=>$enddate[$key],'pic'=>$pic[$key],'statussumber'=>$status[$key]
                        ];
                    $sumberrisk = Sumberrisikoproject::where('id',$sumberid[$key])->update($datasumber);

                    }
                    
                    }
                    
                }
            }
            return redirect()
            ->route('risikoproject.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update risiko!'
            ]);
            
        }else{
            return redirect()
            ->route('risikoproject.index')
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
        $dataupdate = ['destroy'=>1];
        $riskdetail = Risikoprojectdetail::where('id',$id)
        ->update($dataupdate);
        if($riskdetail){
            return redirect()
            ->route('risikoproject.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus risiko!'
            ]);

        }else{

            return redirect()
            ->route('risikoproject.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus risiko!'
            ]);
        }
    }
    function validriskproject(Request $request,$id){
        $risikoproject = Risikoproject::where('id',$id)->update(['statusrisiko_id' => '2']);    
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
            $dtval->aktorvalidasi_id = 1;
            $dtval->statusvalidasi_id =2;
            $dtval->tglvalidasi =date("Y-m-d H:i:s");
            $dtval->save();

            $hsl='success';
            return $hsl;
        }
        return Redirect::back()->withErrors(['msg', 'Error']);
    }

}
