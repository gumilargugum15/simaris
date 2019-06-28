<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kpi;
use App\Unitkerja;

use Illuminate\Support\Facades\Auth;
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
        $kpi =Kpi::tahunAktif()
        ->join('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->select('kpi.*', 'unitkerja.nama as namaunit')
        ->get();
        return view('administrator.kpi.index', compact('judul', 'kpi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $delete =  Kpi::where('id',$id)->delete();
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
