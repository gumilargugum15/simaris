<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitkerja;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Auth;
class ProjectController extends Controller
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
        $judul = "Project";
        //$kpi =Kpi::tahunAktif()
        $project =Project::
          join('unitkerja as a', 'project.unit_id', '=', 'a.kode')
        ->join('users as b', 'b.nik', '=', 'project.keyperson')
        ->join('users as c', 'c.nik', '=', 'project.pm')
        ->join('statusproject as d', 'd.id', '=', 'project.statusproject_id')
        ->select('project.*', 'a.nama as namaunit','b.name as namakeyperson','c.name as namapm','d.nama as statusproject')
        ->orderBy('tahun','desc')
        ->get();
        //  dd($project);
        return view('administrator.project.index', compact('judul', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $retval    = [];
        $retval = file_get_contents('http://portal.krakatausteel.com/eos/api/structdisp', false, stream_context_create($this->arrContextOptions));
        $jessval   =json_decode($retval);
        $unitkerja = Unitkerja::get();
        return view('administrator.project.addproject', compact('unitkerja','jessval'));
    }
    public function carikeyperson(Request $request,$nikkeyperson){
        
        $retval    = [];
        $retval = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$nikkeyperson, false, stream_context_create($this->arrContextOptions));
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
        $this->validate($request,[
            'nama' => 'required',
            'unit' => 'required',
            'namakeyperson' => 'required',
            'namapm' => 'required',
            'namakontrak' => 'required',
            'nomorkontrak' => 'required'
         ]);
         $user = Auth::user();

         $nama              = $request->nama;
         $unit              = $request->unit;
         $keyperson         = $request->keyperson;
         $namakeyperson     = $request->namakeyperson;
         $jabkeyperson      = $request->jabkeyperson;
         $pm                = $request->pm;
         $namapm            = $request->namapm;
         $jabpm             = $request->jabpm;
         $namakontrak       = $request->namakontrak;
         $nomorkontrak      = $request->nomorkontrak;
         $startenddate         = $request->startenddate;
         $pecah                = explode("-",$startenddate);
         $arrstdate            = explode("/",$pecah[0]);
         $arrendate            = explode("/",$pecah[1]);
         $startdate            = trim($arrstdate[2]).'-'.trim($arrstdate[0]).'-'.trim($arrstdate[1]);
         $enddate              = trim($arrendate[2]).'-'.trim($arrendate[0]).'-'.trim($arrendate[1]);
         $tahun                = $request->tahun;

         $project = new Project();
         $project->nama                     = $nama;
         $project->unit_id                  = $unit;
         $project->keyperson                = $keyperson;
         $project->namakeyperson            = $namakeyperson;
         $project->jabkeyperson             = $jabkeyperson;
         $project->pm                       = $pm;
         $project->namapm                   = $namapm;
         $project->jabpm                    = $jabpm;
         $project->namakontrak              = $namakontrak;
         $project->nomorkontrak             = $nomorkontrak;
         $project->creator                  = $user->nik;
         $project->start_date               = $startdate;
         $project->end_date                 = $enddate;
         $project->tahun                    = $tahun;
         $project->aktif                    = 1;
         $project->statusproject_id         = 1;
         $project->save();
         if($project){
            return redirect()
            ->route('project.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan Project!'
            ]);
        }else{
            return redirect()
            ->route('project.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan Project!'
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
        $project = Project::where('id',$id)->first();
        //dd($project);
        $explsd =  explode("-",$project->start_date);
        $expled =  explode("-",$project->end_date);
        $startdate            = trim($explsd[1]).'/'.trim($explsd[2]).'/'.trim($explsd[0]);
        
        $enddate              = trim($expled[1]).'/'.trim($expled[2]).'/'.trim($expled[0]);
        
        $staredndate = $startdate.' - '.$enddate;
        
        $retval    = [];
        $retval = file_get_contents('http://portal.krakatausteel.com/eos/api/structdisp', false, stream_context_create($this->arrContextOptions));
        $jessval   =json_decode($retval);
        $unitkerja = Unitkerja::get();
        return view('administrator.project.editproject', compact('unitkerja','jessval','project','staredndate'));
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
        $this->validate($request,[
            'nama' => 'required',
            'unit' => 'required',
            'namakeyperson' => 'required',
            'namapm' => 'required',
            'namakontrak' => 'required',
            'nomorkontrak' => 'required'
         ]);
         $user = Auth::user();
         $id                = $request->idproject;
         $nama              = $request->nama;
         $unit              = $request->unit;
         $keyperson         = $request->keyperson;
         $namakeyperson     = $request->namakeyperson;
         $jabkeyperson      = $request->jabkeyperson;
         $pm                = $request->pm;
         $namapm            = $request->namapm;
         $jabpm             = $request->jabpm;
         $namakontrak       = $request->namakontrak;
         $nomorkontrak      = $request->nomorkontrak;
         $startenddate         = $request->startenddate;
         $pecah                = explode("-",$startenddate);
         $arrstdate            = explode("/",$pecah[0]);
         $arrendate            = explode("/",$pecah[1]);
         $startdate            = trim($arrstdate[2]).'-'.trim($arrstdate[0]).'-'.trim($arrstdate[1]);
         $enddate              = trim($arrendate[2]).'-'.trim($arrendate[0]).'-'.trim($arrendate[1]);
         $tahun                = $request->tahun;

         $data =['nama'=>$nama,'unit_id'=>$unit,'keyperson'=>$keyperson,'namakeyperson'=>$namakeyperson,'jabkeyperson'=>$jabkeyperson
         ,'pm'=>$namapm,'namapm'=>$namapm,'jabpm'=>$jabpm,'namakontrak'=>$namakontrak,'nomorkontrak'=>$nomorkontrak,'start_date'=>$startdate,'end_date'=>$enddate
         ,'modifier'=>$user->nik];
         $project = Project::where('id',$id)->update($data);
         if($project){
            return redirect()
            ->route('project.index')
            ->with('flash_notification', [
                'level' => 'info',
                'message' => 'Berhasil menyimpan Project!'
            ]);
        }else{
            return redirect()
            ->route('project.index')
            ->with('flash_notification', [
                'level' => 'warning',
                'message' => 'Gagal menyimpan Project!'
            ]);
        }


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
