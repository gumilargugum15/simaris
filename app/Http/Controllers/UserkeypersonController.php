<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Unitkerja;
use App\Otorisasi;
class UserkeypersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $judul = "Users keyperson";
        $user =user::select('users.*','unitkerja.nama as namaunit','otorisasi.status')
        ->join('unitkerja','unitkerja.objectabbr','=','users.unit_id')
        ->join('model_has_roles','model_has_roles.model_id','=','users.nik')
        ->leftJoin('otorisasi','otorisasi.nik','=','users.nik')
        ->where('model_has_roles.role_id','1')
        ->get();
       
        return view('konfigurasi.userskeyperson.index', compact('judul', 'user'));
    }
    function tutupotorisasi(Request $request,$nik){
        $otor = Otorisasi::where('nik',$nik)->update(['status'=>0]);
        if($otor){
            return redirect()
            ->route('userkeyperson.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan periode bisnis!'
            ]);
        }else{
            return redirect()
            ->route('userkeyperson.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan periode bisnis!'
            ]);
        }

    }
    function bukaotorisasi(Request $request,$nik){
        $dataoto = Otorisasi::where('nik',$nik)->get();
        $module ="Kpi";
        $ada = count($dataoto);
        if($ada > 0 ){
            $otor = Otorisasi::where('nik',$nik)->update(['status'=>1]);
            if($otor){
                return redirect()
                ->route('userkeyperson.index')
                ->with('flash_notification', [
                    'level' => 'info',
                    'message' => 'Berhasil menyimpan periode bisnis!'
                ]);
            }else{
                return redirect()
                ->route('userkeyperson.index')
                ->with('flash_notification', [
                    'level' => 'warning',
                    'message' => 'Gagal menyimpan periode bisnis!'
                ]);
            }
        }else{
        
        $status = 1;
        $otor = new Otorisasi();
        $otor->nik     = $nik;
        $otor->module  = $module;
        $otor->status  = $status;
        $otor->save();
        if($otor){
            return redirect()
            ->route('userkeyperson.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan periode bisnis!'
            ]);
        }else{
            return redirect()
            ->route('userkeyperson.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan periode bisnis!'
            ]);
        }
        }
        
        
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
