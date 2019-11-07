<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Unitkerja;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $judul = "Users";
        $user =user::select('users.*','Unitkerja.nama as namaunit','roles.name as namarole')
        ->join('Unitkerja','Unitkerja.objectabbr','=','users.unit_id')
        ->join('model_has_roles','model_has_roles.model_id','=','users.nik')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->get();
        //  dd($user);
        return view('administrator.users.index', compact('judul', 'user'));
    }
    function nonaktifuser(Request $request,$nik){
        $user = User::where('nik',$nik)->update(['status'=>0]);
        if($user){
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'User dengan '.$nik.' berhasil dinonaktifkan !'
            ]);
        }else{
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'User dengan '.$nik.' gagal dinonaktifkan !'
            ]);
        }

    }
    function aktifkanuser(Request $request,$nik){
        $user = User::where('nik',$nik)->update(['status'=>1]);
        if($user){
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'User dengan '.$nik.' berhasil diaktifkan !'
            ]);
        }else{
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'User dengan '.$nik.' gagal diaktifkan !'
            ]);
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
