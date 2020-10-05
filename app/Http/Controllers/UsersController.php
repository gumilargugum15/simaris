<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Unitkerja;
use App\Roles;
use App\Model_has_roles;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
class UsersController extends Controller
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
        $judul = "Users";
        $user =User::select('users.*','unitkerja.nama as namaunit','roles.name as namarole')
        ->leftjoin('unitkerja','unitkerja.objectabbr','=','users.unit_id')
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
        $unitkerja = Unitkerja::get();
        $roles = Roles::get();
        
        return view('administrator.users.addusers', compact('unitkerja','roles'));
    }
    public function carinik(Request $request,$nik){
        
        $retval    = [];
        $retval = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$nik, false, stream_context_create($this->arrContextOptions));
        return $retval;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nik          = $request->nik;
        $nama         = $request->nama;
        $email        = $request->email;
        $password     = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm';
        $unit_id      = $request->unit;
        $namaunit      = $request->namaunit;
        $roles      = $request->roles;
        
        $cekuser = User::where('nik',$nik)->orWhere('email',$email)->get();
        // dd($cekuser);
        if(count($cekuser)>0){
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'User dengan nik '.$nik.' atau email '.$email.' sudah terdaftar!'
            ]);
        }else{
        $user = Auth::user();
        $datauser = new User();
        $datauser->nik              = $nik;
        $datauser->name             = $nama;
        $datauser->email            = $email;
        $datauser->password         = $password;
        $datauser->unit_id          = $unit_id;
        $datauser->nama_unit        = $namaunit;
        $datauser->save();
        if($datauser){
            foreach($roles as $key =>$value){
            $dataroles = new Model_has_roles();
            $dataroles->role_id                = $value;
            $dataroles->model_type             = 'App\User';
            $dataroles->model_id               = $nik;
            $dataroles->save();
            }
            
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan User!'
            ]);
        }else{
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan User!'
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
    public function edit(Request $request,$id)
    {
        $user = User::where('nik',$id)->first();
        $roles = Roles::get();
        $roles->map(function ($item, $key) use($id) {
        $where =array('role_id'=>$item->id,'model_id'=>$id);
        $a=Model_has_roles::where($where)->get();
        $b = count($a);
        $item->jml = $b;
        return $item;
        });
        
        return view('administrator.users.editusers', compact('user','roles'));
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
        $nik          = $request->nik;
        $nama         = $request->nama;
        $email        = $request->email;
        $unit_id      = $request->unit;
        $namaunit     = $request->namaunit;
        $roles        = $request->roles;
        
        $dataupdate = ['email'=>$email,'unit_id'=>$unit_id,'nama_unit'=>$namaunit];
        $user = User::where('nik',$nik)->update($dataupdate);
        if($user){
            $delete =  Model_has_roles::where('model_id',$nik)->delete();
            foreach($roles as $key =>$value){
                $dataroles = new Model_has_roles();
                $dataroles->role_id                = $value;
                $dataroles->model_type             = 'App\User';
                $dataroles->model_id               = $nik;
                $dataroles->save();
                }
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil update User!'
            ]);
        }else{
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal update User!'
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
         $delete =  User::where('nik',$id)->delete();
        // $dataupdate = ['deleted'=>1];
        // $delete = Kpi::where('id',$id)->update($dataupdate);
        if($delete){
            $delete =  Model_has_roles::where('model_id',$id)->delete();
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus user!'
            ]);
        }else{
            return redirect()
            ->route('users.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus user!'
            ]);
        }

    }
}
