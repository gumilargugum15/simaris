<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitkerja;

use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
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
        $judul="Unit";
        $unit = Unitkerja::get();
        
        return view('administrator.unit.index', compact('judul', 'unit'));
    }
    public function updateunit()
    {
        $ret = file_get_contents('https://portal.krakatausteel.com/eos/api/organization', false, stream_context_create($this->arrContextOptions));
        $jess=json_decode($ret);
        $collection = collect($jess);
        $user = Auth::user();
        
        $unitkerja = Unitkerja::truncate();
        foreach($collection as $data){
            $unit = new Unitkerja();
            $unit->kode = $data->ObjectID;
            $unit->nama = $data->Objectname;
            $unit->objectabbr = $data->Objectabbr;
            $unit->creator = $user->nik;
            $unit->save();
            
        }
        return redirect()
        ->route('unit.index')
        ->with('flash_notification', [
            'level' => 'info',
            'message' => 'Unit kerja sudah diupdate!'
        ]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.unit.addunit');
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
        $objectabbr   = $request->objectabbr;
        
        $user = Auth::user();
        $dataunit = new Unitkerja();
        $dataunit->kode             = $kode;
        $dataunit->nama             = $nama;
        $dataunit->objectabbr          = $objectabbr;
        $dataunit->creator          = $user->nik;
        $dataunit->save();
        if($dataunit){
            return redirect()
            ->route('unit.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan unit!'
            ]);
        }else{
            return redirect()
            ->route('unit.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan unit!'
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
        $delete =  Unitkerja::where('id',$id)->delete();
        if($delete){
            return redirect()
            ->route('unit.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil hapus unit!'
            ]);
        }else{
            return redirect()
            ->route('unit.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal hapus unit!'
            ]);
        }

    }
}
