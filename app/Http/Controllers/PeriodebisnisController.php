<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perioderisikobisnis;
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
