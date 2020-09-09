<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kpi;
use App\Unitkerja;
use App\Perioderisikobisnis;

use Illuminate\Support\Facades\Auth;
use App\Imports\KpiImport;
use Maatwebsite\Excel\Facades\Excel;
class KpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $judul = "KPI";
        //$kpi =Kpi::tahunAktif()
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unitkerja = Unitkerja::get();
        // dd($periodeaktif->id);
        $requnit = $request->unitkerja;
        // dd($requnit);
        if(isset($request->unitkerja)){
            $kpi =Kpi::
        join('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->leftJoin('level_kpi', 'level_kpi.id', '=', 'kpi.level')
        ->join('perioderisikobisnis', 'perioderisikobisnis.id', '=', 'kpi.perioderisikobisnis_id')
        ->select('kpi.*', 'unitkerja.nama as namaunit','perioderisikobisnis.nama as namaperiode','perioderisikobisnis.tahun as tahunperiode','level_kpi.nama as namalevel','level_kpi.warna')
        ->where('kpi.deleted',0)
        ->where('kpi.unit_id',$request->unitkerja)
        ->where('kpi.perioderisikobisnis_id',$periodeaktif->id)
        ->orderBy('tahun','desc')
        ->get();
        }else{
            $kpi =Kpi::
        join('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->leftJoin('level_kpi', 'level_kpi.id', '=', 'kpi.level')
        ->join('perioderisikobisnis', 'perioderisikobisnis.id', '=', 'kpi.perioderisikobisnis_id')
        ->select('kpi.*', 'unitkerja.nama as namaunit','perioderisikobisnis.nama as namaperiode','perioderisikobisnis.tahun as tahunperiode','level_kpi.nama as namalevel','level_kpi.warna')
        ->where('kpi.deleted',0)
        ->where('kpi.perioderisikobisnis_id',$periodeaktif->id)
        ->orderBy('tahun','desc')
        ->get();
        }
        
        
        return view('administrator.kpi.index', compact('judul', 'kpi','periodeaktif','unitkerja','requnit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request) 
    {
        $import = Excel::import(new KpiImport, request()->file('excel'));
        
        if($import){
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil import KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal import KPI!'
            ]);
        }
    }
    public function create()
    {
        $unitkerja = Unitkerja::get();
        return view('administrator.kpi.addkpi', compact('unitkerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $kode         = $request->kode;
        $nama         = $request->nama;
        $unit         = $request->unit;
        $tahun        = $request->tahun;

        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();

        $user = Auth::user();
        $datakpi = new Kpi();
        $datakpi->kode                      = $kode;
        $datakpi->nama                      = $nama;
        $datakpi->unit_id                   = $unit;
        $datakpi->tahun                     = $tahun;
        $datakpi->creator                   = $user->nik;
        $datakpi->perioderisikobisnis_id    = $periodeaktif->id;
        $datakpi->status                    = 0;
        $datakpi->deleted                    = 0;
        $datakpi->save();
        if($datakpi){
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan KPI!'
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
        $kpi = Kpi::where('id',$id)->first();
        $unitkerja = Unitkerja::get();
        return view('administrator.kpi.editkpi', compact('kpi','unitkerja'));
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
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal update KPI!'
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
        //$delete =  Kpi::where('id',$id)->delete();
        $dataupdate = ['deleted'=>1];
        $delete = Kpi::where('id',$id)->update($dataupdate);
        if($delete){
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus KPI!'
            ]);
        }else{
            return redirect()
            ->route('kpi.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus KPI!'
            ]);
        }

    }
}
