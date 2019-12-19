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
use App\Komentar_detail;
use App\Kelompokrisiko;
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
        $kelompokrisiko = Kelompokrisiko::get();
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $hsl='';
        if(isset($request->periode ) && isset($request->unitkerja)){
      
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
            // dd($risikobisnis->risikobisnisdetail);
            $status = 0;
            $cekkpinull = Kpi::byId($request->periode)->byStatus($status)->byUnit($request->unitkerja)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($request->periode)->byUnit($request->unitkerja)->get();
            $jmlkpiall = count($cekkpiall);

            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($request->periode)->byStatus($statusinput)->byUnit($request->unitkerja)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);

            $hsl='';
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            ->select('risikobisnisdetail.*', 'kpi.nama as namakpi', 'kpi.level as levelkpi', 'klasifikasi.nama as namaklas', 'peluang.kriteria as peluang', 'peluang.level as levelpeluang', 'kriteria.nama as dampak', 'kriteria.level as leveldampak', 'matrikrisiko.tingkat','kelompokrisiko.nama as namakelompok')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
            ->join('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
            ->join('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
            ->join("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
                })
            ->join("matrikrisiko",function($join){
                $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                })
            ->orderBy('kpi.level','desc')->get();
            // dd($detailrisk);
            $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="2%"></th> 
                    <th width="2%">No</th>  
                    <th>KPI</th>
                    <th>Kelompok</th>
                    <th width="10%">Kaidah</th>
                    <th>Risiko</th>
                    <th>Peluang</th>
                    <th>Dampak</th>
                    <th>Warna</th>
                    <th>Sumber risiko</th>
                    <th>Indikator</th>
                    <th>Nilai ambang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            $no =1;
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('risikobisnis_id',$data->risikobisnis_id)->where('kpi_id',$data->kpi_id)->get();
                $jmldetailkpi = count($detailkpi);
                if($jmldetailkpi > 1){
                $hsl.='<tr>
                <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$data->id.'"></td>
                <td>'.$no.' '.$key.' '.$jmldetailkpi.'</td>';
                if($jmldetailkpi > 1){
                $hsl.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
                
                $hsl.='</tr>';
                }else{
                $hsl.='';
                
                }
                
                }else{
                    $hsl.='<tr>
                <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$data->id.'"></td>
                <td>'.$no.' '.$key.' '.$jmldetailkpi.'</td>
                <td>'.$data->namakpi.'</td>';
                $hsl.='</tr>';
                }
                // $hsl.='<tr>
                // <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$data->id.'"></td>
                // <td>'.$no.' '.$key.' '.$jmldetailkpi.'</td>
                // <td>'.$data->namakpi.'</td>';
                // $hsl.='</tr>';
                $no++;

            }

            $hsl.='</tbody>
            <tfoot>
                <tr>
                    <th colspan="3"><input type="checkbox" id="selectall" onClick="selectAll(this)" />&nbsp;Pilih semua</th> 
                    <th colspan="7">    
                        <a class="btn btn-primary"  onclick="sesuaikaidah()"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a>
                        <a class="btn btn-warning" onclick="tidaksesuaikaidah()"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a> 
                    </th>
                    <th></th>
                    <th></th>
                    <th></th> 
                </tr>
            </tfoot>
        </table>';
            
        }else{
            $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="2%"></th> 
                    <th width="2%">No</th>  
                    <th>KPI</th>
                    <th>Kelompok</th>
                    <th width="10%">Kaidah</th>
                    <th>Risiko</th>
                    <th>Peluang</th>
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
    
        return view('resiko.risikobisnisverifi.index', compact('risikobisnis','periodeall','namarisiko','unitkerja','nikuser','periodeaktif','jmlkpinull','jmlkpiall',
        'jmlkpisudahinput','kelompokrisiko','hsl'));
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
        $user = Auth::user();
        $dilihat = Komentar_detail::where('nik',$user->nik)->where('risikobisnisdetail_id',$id)->update(['baca'=>1,'tglbaca'=>date("Y-m-d H:i:s")]);
        $komen = Komentar::where('risikobisnisdetail_id',$id)->orderBy('id', 'DESC')->get();
        return $komen;

    }
    public function kirimkomentar(Request $request){
        $user = Auth::user();
        $roles = Auth::user()->roles;
        $message    = $request->message;
        $id         = $request->idrisiko;
        $detid      = $request->detailrisikoid;
        //getriskdetail

        $riskdetail = Risikobisnisdetail::where('id',$detid)->first();
        
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
                $komendet = new Komentar_detail();
                $komendet->komentar_id   = $dtval->id;
                $komendet->risikobisnisdetail_id  = $detid;
                $komendet->nik   = $riskdetail->creator;
                $komendet->nama  ='';
                $komendet->baca  = 0;
                $komendet->save();
            }
        
    }
    public function kpi(Request $request){
        $user = Auth::user();
        $unitid = $user->unit_id;
        $judul = "KPI";
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $kpi =Kpi::tahunAktif($periodeaktif->tahun)
        ->join('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->select('kpi.*', 'unitkerja.nama as namaunit')
        // ->byUnit($unitid)
        ->get();
        return view('resiko.risikobisnisverifi.kpiindex', compact('judul', 'kpi'));
    }
    public function cl(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'CL']);
        }

    }
    public function kri(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'KRI']);
        }

    }
    public function kri_rkap(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'KRI RKAP']);
        }

    }
    public function batalkri(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'']);
        }

    }
    public function rkap(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'RKAP']);
        }

    }
    public function batalrkap(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'']);
        }

    }
    public function kelompokrisiko(Request $request,$id){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>$id]);
        }
    }
    public function krirkap(Request $request){
        $namarisiko ="Risiko Bisnis KRI/RKAP";
        $user = Auth::user();
        $nikuser = $user->nik;
        $unitkerja = Unitkerja::get();
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        if(isset($request->periode ) && isset($request->unitkerja)){
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
           }
        
        return view('resiko.risikobisnisverifi.risikobisniskrirkap', compact('risikobisnis','periodeall','namarisiko','unitkerja','nikuser','periodeaktif'));
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
