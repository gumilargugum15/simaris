<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perioderisikobisnis;
use App\Kpi;
use App\Risikobisnis;
use App\Risikobisnisdetail;
use App\Temp_riskbisnis_id;
use App\Temp_riskbisnisdet_id;
use App\Sumberrisiko;
use Illuminate\Support\Facades\Auth;
class PeriodebisnisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $judul = "Periode bisnis";
        $periodbisnis =Perioderisikobisnis::where('deleted',0)->get();
        return view('administrator.periodebisnis.index', compact('judul', 'periodbisnis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun = date("Y");
        return view('administrator.periodebisnis.addperiodebisnis',compact('tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama                 = $request->nama;
        $startenddate         = $request->startenddate;
        $pecah                = explode("-",$startenddate);
        $arrstdate            = explode("/",$pecah[0]);
        $arrendate            = explode("/",$pecah[1]);
        $startdate            = trim($arrstdate[2]).'-'.trim($arrstdate[0]).'-'.trim($arrstdate[1]);
        $enddate              = trim($arrendate[2]).'-'.trim($arrendate[0]).'-'.trim($arrendate[1]);
        $tahun                = $request->tahun;

        $user = Auth::user();
        $dataperiod = new Perioderisikobisnis();
        $dataperiod->nama          = $nama;
        $dataperiod->start_date    = $startdate;
        $dataperiod->end_date      = $enddate;
        $dataperiod->tahun         = $tahun;
        $dataperiod->aktif         = 0;
        $dataperiod->creator       = $user->nik;
        $dataperiod->deleted       = 0;
        $dataperiod->save();
        if($dataperiod){
            return redirect()
            ->route('periodebisnis.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan periode bisnis!'
            ]);
        }else{
            return redirect()
            ->route('periodebisnis.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan periode bisnis!'
            ]);
        }
    }
    public function update(Request $request)
    {
        $id           = $request->id;
        $nama                 = $request->nama;
        $startenddate         = $request->startenddate;
        $pecah                = explode("-",$startenddate);
        $arrstdate            = explode("/",$pecah[0]);
        $arrendate            = explode("/",$pecah[1]);
        $startdate            = trim($arrstdate[2]).'-'.trim($arrstdate[0]).'-'.trim($arrstdate[1]);
        $enddate              = trim($arrendate[2]).'-'.trim($arrendate[0]).'-'.trim($arrendate[1]);
        $tahun                = $request->tahun;
        $user         = Auth::user();

        $dataupdate = ['nama'=>$nama,'start_date'=>$startdate,'end_date'=>$enddate,'tahun'=>$tahun,'modifier'=>$user->nik];

        $Perioderisikobisnis = Perioderisikobisnis::where('id',$id)->update($dataupdate);
        if($Perioderisikobisnis){
            return redirect()
            ->route('periodebisnis.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update Periode bisnis!'
            ]);
        }else{
            return redirect()
            ->route('periodebisnis.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal update Periode bisnis!'
            ]);
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
    public function edit(Request $request,$id)
    {
        $periodebisnis = Perioderisikobisnis::where('id',$id)->first();
        $sdate = $periodebisnis->start_date;
        $edate = $periodebisnis->end_date;
        $arrstdate     = explode("-",$sdate);
        $arrendate     = explode("-",$edate);
        $startdate = $arrstdate[1].'/'.$arrstdate[2].'/'.$arrstdate[0];
        $enddate   = $arrendate[1].'/'.$arrendate[2].'/'.$arrendate[0];
        $startenddate = $startdate.' - '.$enddate;
       // dd($startenddate);
        return view('administrator.periodebisnis.editperiodebisnis', compact('periodebisnis','startenddate'));
    }
    public function aktifperiode(Request $request,$id){
        $periodebisnis = Perioderisikobisnis::where('id',$id)->first();
        // dd($periodebisnis);
        $periodesebelum = Perioderisikobisnis::where('aktif','1')->where('tahun',$periodebisnis->tahun)->first();
        // dd($periodesebelum);
        $kwartalsebelum = $periodesebelum->nama;
        $periodeidsebelum = $periodesebelum->id;
        // dd($periodeidsebelum);
        // $kpi = Kpi::where('tahun',$periodebisnis->tahun)->where('kwartal',$kwartalsebelum)->get();
        $kpi = Kpi::where('perioderisikobisnis_id',$periodeidsebelum)->get();
        // dd($kpi);
        // $risikobisnis     = Risikobisnis::where('tahun',$periodebisnis->tahun)->where('periode',$kwartalsebelum)->get();
        $risikobisnis     = Risikobisnis::where('perioderisikobisnis_id',$periodeidsebelum)->get();
        // dd($risikobisnis);
        $riskbisnisdetail = Risikobisnisdetail::where('perioderisikobisnis_id',$periodeidsebelum)->get();

        $sumberrisiko = Sumberrisiko::where('perioderisikobisnis_id',$periodeidsebelum)->get();
        
        $update  = Perioderisikobisnis::where('aktif','1')->update(['aktif' => '2']);
        $periode = Perioderisikobisnis::where('id',$id)->update(['aktif' => '1']);
        
        
        
        foreach($kpi as $kpi){
            $dtkpi = new Kpi();
            $dtkpi->kode     =  $kpi->kode;
            $dtkpi->nama     =  $kpi->nama;
            $dtkpi->unit_id  =  $kpi->unit_id;
            $dtkpi->tahun    =  $kpi->tahun;
            $dtkpi->level    =  $kpi->level;
            $dtkpi->utama    =  $kpi->utama;
            $dtkpi->kwartal  =  $periodebisnis->nama;
            $dtkpi->perioderisikobisnis_id  =  $periodebisnis->id;
            $dtkpi->status   =  1;
            $dtkpi->deleted   =  0;
            $dtkpi->save();
        }
        
        foreach($risikobisnis as $risikobisnis){
            
            $dtrisk = new Risikobisnis();
            $dtrisk->periode                =  $periodebisnis->nama;
            $dtrisk->tahun                  =  $risikobisnis->tahun;
            $dtrisk->unit_id                =  $risikobisnis->unit_id;
            $dtrisk->perioderisikobisnis_id =  $periodebisnis->id;
            $dtrisk->statusrisiko_id        =  1;
            $dtrisk->creator                =  $risikobisnis->creator;
            $dtrisk->delete        =  0;
            $dtrisk->save();

            $dtemp = new Temp_riskbisnis_id();
            $dtemp->idlama = $risikobisnis->id;
            $dtemp->idbaru = $dtrisk->id;
            $dtemp->save();

        }
        foreach($riskbisnisdetail as $riskbisnisdetail){
                $temp = Temp_riskbisnis_id::where('idlama',$riskbisnisdetail->risikobisnis_id)->first();
                $riskidbaru = $temp->idbaru;
                $dtriskdetail = new Risikobisnisdetail();
                $dtriskdetail->risikobisnis_id   =  $riskidbaru;
                $dtriskdetail->kpi_id            =  $riskbisnisdetail->kpi_id;
                $dtriskdetail->risiko            =  $riskbisnisdetail->risiko;
                $dtriskdetail->akibat            =  $riskbisnisdetail->akibat;
                $dtriskdetail->klasifikasi_id    =  $riskbisnisdetail->klasifikasi_id;
                $dtriskdetail->peluang_id        =  $riskbisnisdetail->peluang_id;
                $dtriskdetail->dampak_id         =  $riskbisnisdetail->dampak_id;
                $dtriskdetail->warna             =  $riskbisnisdetail->warna;
                $dtriskdetail->indikator         =  $riskbisnisdetail->indikator;
                $dtriskdetail->nilaiambang       =  $riskbisnisdetail->nilaiambang;
                $dtriskdetail->kaidah            =  $riskbisnisdetail->kaidah;
                $dtriskdetail->tglkaidah         =  $riskbisnisdetail->tglkaidah;
                $dtriskdetail->creator           =  $riskbisnisdetail->creator;
                $dtriskdetail->kategori_id       =  $riskbisnisdetail->kategori_id;
                $dtriskdetail->highlight         =  $riskbisnisdetail->highlight;
                $dtriskdetail->tglhighlight      =  $riskbisnisdetail->tglhighlight;
                $dtriskdetail->perioderisikobisnis_id  =  $periodebisnis->id;
                $dtriskdetail->jenisrisiko       =  $riskbisnisdetail->jenisrisiko;
                $dtriskdetail->delete        =  0;
                $dtriskdetail->save();

                $dtemp = new Temp_riskbisnisdet_id();
                $dtemp->idlama = $riskbisnisdetail->id;
                $dtemp->idbaru = $dtriskdetail->id;
                $dtemp->save();
        }
        foreach($sumberrisiko as $sumberrisiko){
            $temp = Temp_riskbisnisdet_id::where('idlama',$sumberrisiko->risikobisnisdetail_id)->first();
            $riskdetidbaru = $temp->idbaru;
            $dtsumber = new Sumberrisiko();
            $dtsumber->risikobisnisdetail_id   =  $riskdetidbaru;
            $dtsumber->namasumber              =  $sumberrisiko->namasumber;
            $dtsumber->mitigasi                =  $sumberrisiko->mitigasi;
            $dtsumber->biaya                   =  $sumberrisiko->biaya;
            $dtsumber->start_date              =  $sumberrisiko->start_date;
            $dtsumber->end_date                =  $sumberrisiko->end_date;
            $dtsumber->pic                     =  $sumberrisiko->pic;
            $dtsumber->statussumber            =  $sumberrisiko->statussumber;
            $dtsumber->creator                 =  $sumberrisiko->creator;
            $dtsumber->modifier                =  $sumberrisiko->modifier;
            $dtsumber->file                    =  $sumberrisiko->file;
            $dtsumber->kpi_id                  =  $sumberrisiko->kpi_id;
            $dtsumber->perioderisikobisnis_id  =  $periodebisnis->id;
            $dtsumber->delete        =  0;
            $dtsumber->save();

    }
        
        $hsl='success';
        return $hsl;
       
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //$delete =  Kpi::where('id',$id)->delete();
        $dataupdate = ['deleted'=>1];
        $delete = Perioderisikobisnis::where('id',$id)->update($dataupdate);
        if($delete){
            return redirect()
            ->route('periodebisnis.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus periode bisnis!'
            ]);
        }else{
            return redirect()
            ->route('periodebisnis.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus periode bisnis!'
            ]);
        }

    }
}
