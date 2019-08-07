<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perioderisikobisnis;
use App\Kpi;
use App\Risikobisnis;
use App\Risikobisnisdetail;
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
        $periodbisnis =Perioderisikobisnis::get();
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
        
        $periodesebelum = Perioderisikobisnis::where('aktif','1')->where('tahun',$periodebisnis->tahun)->first();
        // dd($periodesebelum);
        $kwartalsebelum = $periodesebelum->nama;
        //dd($kwartalsebelum);
        $kpi = Kpi::where('tahun',$periodebisnis->tahun)->where('kwartal',$kwartalsebelum)->get();
        $risikobisnis     = Risikobisnis::where('tahun',$periodebisnis->tahun)->where('periode',$kwartalsebelum)->get();
        // dd($risikobisnis);
        $update  = Perioderisikobisnis::where('aktif','1')->update(['aktif' => '2']);
        $periode = Perioderisikobisnis::where('id',$id)->update(['aktif' => '1']);
        
        
        // $riskbisnisdetail = Risikobisnisdetail::get();
        
        foreach($kpi as $kpi){
            $dtkpi = new Kpi();
            $dtkpi->kode     =  $kpi->kode;
            $dtkpi->nama     =  $kpi->nama;
            $dtkpi->unit_id  =  $kpi->unit_id;
            $dtkpi->tahun    =  $kpi->tahun;
            $dtkpi->kwartal  =  $periodebisnis->nama;
            $dtkpi->save();
        }
        
        foreach($risikobisnis as $risikobisnis){
            $dtrisk = new Risikobisnis();
            $dtrisk->periode             =  $periodebisnis->nama;
            $dtrisk->tahun               =  $risikobisnis->tahun;
            $dtrisk->unit_id             =  $risikobisnis->unit_id;
            $dtrisk->statusrisiko_id     =  $risikobisnis->statusrisiko_id;
            $dtrisk->creator             =  $risikobisnis->creator;
            $dtrisk->save();

            // $this->storeriskdetail($dtrisk->id,$riskbisnisdetail);

        }
        
        $hsl='success';
        return $hsl;
       
    }
    public function storeriskdetail($riskid,$riskbisnisdetail){
     
        foreach($riskbisnisdetail as $riskbisnisdetail){
            if($riskbisnisdetail->kaidah=='1'){
                $kaidah    = $riskbisnisdetail->kaidah;
                $tglkaidah = $riskbisnisdetail->tglkaidah;
            }else{
                $kaidah=0;
                $tglkaidah='';
            }
            if($riskbisnisdetail->highlight=='1'){
                $highlight    = $riskbisnisdetail->highlight;
                $tglhighlight = $riskbisnisdetail->tglhighlight;
            }else{
                $highlight=0;
                $tglhighlight='';
            }
                $dtriskdetail = new Risikobisnisdetail();
                $dtriskdetail->risikobisnis_id   =  $riskid;
                $dtriskdetail->kpi_id            =  $riskbisnisdetail->kpi_id;
                $dtriskdetail->risiko            =  $riskbisnisdetail->risiko;
                $dtriskdetail->akibat            =  $riskbisnisdetail->akibat;
                $dtriskdetail->klasifikasi_id    =  $riskbisnisdetail->klasifikasi_id;
                $dtriskdetail->peluang_id        =  $riskbisnisdetail->peluang_id;
                $dtriskdetail->dampak_id         =  $riskbisnisdetail->dampak_id;
                $dtriskdetail->warna             =  $riskbisnisdetail->warna;
                $dtriskdetail->indikator         =  $riskbisnisdetail->indikator;
                $dtriskdetail->nilaiambang       =  $riskbisnisdetail->nilaiambang;
                $dtriskdetail->kaidah            =  $kaidah;
                $dtriskdetail->tglkaidah         =  $tglkaidah;
                $dtriskdetail->creator           =  $riskbisnisdetail->creator;
                $dtriskdetail->kategori_id       =  $riskbisnisdetail->kategori_id;
                $dtriskdetail->highlight         =  $highlight;
                $dtriskdetail->tglhighlight      =  $tglhighlight;
                $dtriskdetail->save();
        }
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
