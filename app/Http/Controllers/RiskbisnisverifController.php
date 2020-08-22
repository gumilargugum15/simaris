<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Risikobisnis;
use App\Unitkerja;
use App\Statusrisiko;
use App\Risikobisnisdetail;
use App\Validasibisnis;
use App\Sumberrisiko;
use App\Kpi;
use App\Peluang;
use App\Dampak;
use App\Kategori;
use App\Kriteria;
use App\Perioderisikobisnis;
use App\Klasifikasi;
use App\Matrikrisiko;
use App\Komentar;
use App\Komentar_detail;
use App\Kelompokrisiko;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RiskbisnisverifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ public $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=> false,
            "verify_peer_name"=> false,
        ),
      );

    // public function index(Request $request)
    // {
    //     $namarisiko ="Risiko Bisnis";
    //     $user = Auth::user();
    //     $nikuser = $user->nik;
    //     $unitkerja = Unitkerja::get();
    //     // dd($unitkerja);
    //     $kelompokrisiko = Kelompokrisiko::get();
    //     $periodeall = Perioderisikobisnis::get();
    //     $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
    //     $hsl='';
    //     if(isset($request->periode ) && isset($request->unitkerja)){
      
    //         $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
    //         if($risikobisnis!=null){
    //         $statusrisiko = $risikobisnis->statusrisiko_id;
            
    //             $hsl='';
    //             $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
    //             ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
    //             ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
    //             ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->paginate(10);
    //             $detailrisk->withPath('resikobisnisverifikatur?periode='.$request->periode.'&_token=fW4QxaWL7FS0nrPa0bXOXPsi2EgeHMrR1vFpplZb&unitkerja='.$request->unitkerja.'');
    //             $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
    //             <thead>
    //                 <tr>
    //                 <th>No</th>
    //                 <th>KPI</th>
    //                 <th>Pilih</th>
    //                 <th>Risiko</th>
    //                 <th>Peluang</th>
    //                 <th>Kelompok</th>
    //                 <th width="10%">Kaidah</th>
    //                 <th>Dampak</th>
    //                 <th>Warna</th>
    //                 <th>Sumber risiko</th>
    //                 <th>Indikator</th>
    //                 <th>Nilai ambang</th>
    //                 <th>Aksi</th>
    //                 </tr>
    //             </thead>
    //             <tbody>';
    //             $no =0;
               
    //             foreach($detailrisk as $key =>$data ){
    //                 $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
    //                 ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'matrikrisiko.tingkat')
    //                 ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
    //                 ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
    //                 ->join("matrikrisiko",function($join){
    //                     $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
    //                          ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
    //                     })
    //                 ->join("kriteria",function($join){
    //                 $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
    //                     ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
    //                     ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");
    //                 })
    //                 ->get();
    //                 $kpi = Kpi::where('id',$data->kpi_id)->first();
    //                 $jmldetailkpi = count($detailkpi);
    //                 $no++;
    //                 $hsl.='<tr>';
    //                 if($jmldetailkpi > 1){
    //                     $hsl.='<td rowspan="'.$jmldetailkpi.'">'.($detailrisk->firstItem() + $key).'</td>';
    //                     if($kpi->level=='2'){
    //                         $hsl.='<td rowspan="'.$jmldetailkpi.'"><p class="text-red">'.$data->namakpi.'</p></td>';
    //                     }elseif($kpi->level=='1'){
    //                         $hsl.='<td rowspan="'.$jmldetailkpi.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
    //                     }else{
    //                         $hsl.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
    //                     }
                        
    //                 }else{
    //                     $hsl.='<td>'.($detailrisk->firstItem() + $key).'</td>';
    //                     if($kpi->level=='2'){
    //                         $hsl.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
    //                     }elseif($kpi->level=='1'){
    //                         $hsl.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
    //                     }else{
    //                         $hsl.='<td>'.$data->namakpi.'</td>';
    //                     }
                        
    //                 }
                    
    //                 foreach($detailkpi as $keys=>$values){
    //                     $notif = komentar_detail::where('nik',$nikuser)->where('baca',0)->where('risikobisnisdetail_id',$values->id)->get();
    //                     $jmlnotif = count($notif);
    //                     if($jmlnotif > 0){
    //                         $hasil = '<span class="label label-warning">'.$jmlnotif.'</span>';
    //                     }else{
    //                         $hasil = '';
    //                     }
    //                     if($keys==0){
    //                         $hsl.='<td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$values->id.'"></td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
    //                         if($values->kaidah==1){
    //                         $hsl.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
    //                         }else{
    //                         $hsl.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
    //                         }
    //                         $hsl.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
    //                         <td><a class="btn btn-primary" href="#" data-toggle="modal"
    //                         data-target="#modal-sumberresikobisnis"
    //                         onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
    //                             title="List sumber risiko"></i></a></td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
    //                         <td>';
    //                         if($statusrisiko <=2){
    //                             $hsl.='<a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>';
    //                         }
    //                         $hsl.='</td>';
    //                         $hsl.='</tr>';
    //                     }else{
    //                         $hsl.='<tr><td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$values->id.'"></td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
    //                         if($values->kaidah==1){
    //                         $hsl.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
    //                         }else{
    //                         $hsl.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
    //                         }
    //                         $hsl.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
    //                         <td><a class="btn btn-primary" href="#" data-toggle="modal"
    //                         data-target="#modal-sumberresikobisnis"
    //                         onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
    //                             title="List sumber risiko"></i></a></td>
    //                         <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
    //                         <td>';
    //                         if($statusrisiko <=2){
    //                             $hsl.='<a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>';
    //                         }
    //                         $hsl.='</td>';
    //                         $hsl.='</tr>';
    //                     }
    //                 }
                    
    //             }
               
    //             $hsl.='</tbody></table>';
    //             $hsl.=$detailrisk->links();
    //         }else{
    //             $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
    //         <thead>
    //             <tr>
    //             <th>No</th>
    //             <th>KPI</th>
    //             <th>Pilih</th>
    //             <th>Risiko</th>
    //             <th>Peluang</th>
    //             <th>Kelompok</th>
    //             <th width="10%">Kaidah</th>
    //             <th>Dampak</th>
    //             <th>Warna</th>
    //             <th>Sumber risiko</th>
    //             <th>Indikator</th>
    //             <th>Nilai ambang</th>
    //             <th>Aksi</th>
    //             </tr>
    //         </thead>
    //         <tbody><tr><td colspan="13" align="center"><b>Tidak Ada Data</b></td></tr></tbody></table>';
    //         }
    //         $status = 0;
    //         $cekkpinull = Kpi::byId($request->periode)->byStatus($status)->byUnit($request->unitkerja)->get();
    //         $jmlkpinull = count($cekkpinull);
            
    //         $cekkpiall = Kpi::byId($request->periode)->byUnit($request->unitkerja)->get();
    //         $jmlkpiall = count($cekkpiall);

    //         $statusinput = 1;
    //         $cekkpisudahinput = Kpi::byId($request->periode)->byStatus($statusinput)->byUnit($request->unitkerja)->get();
    //         $jmlkpisudahinput = count($cekkpisudahinput);

            
            
            
    //     }else{
    //         $hsl.='<table id="tblresikobisnis" class="table table-bordered table-striped">
    //         <thead>
    //             <tr>
    //             <th>No</th>
    //             <th>KPI</th>
    //             <th>Pilih</th>
    //             <th>Risiko</th>
    //             <th>Peluang</th>
    //             <th>Kelompok</th>
    //             <th width="10%">Kaidah</th>
    //             <th>Dampak</th>
    //             <th>Warna</th>
    //             <th>Sumber risiko</th>
    //             <th>Indikator</th>
    //             <th>Nilai ambang</th>
    //             <th>Aksi</th>
    //             </tr>
    //         </thead>
    //         <tbody></tbody></table>';
    //     }
    
        // return view('resiko.risikobisnisverifi.index', compact('risikobisnis','periodeall','namarisiko','unitkerja','nikuser','periodeaktif','jmlkpinull','jmlkpiall',
        // 'jmlkpisudahinput','kelompokrisiko','hsl'));
    // }
    public function index(Request $request)
    {
        $jmlkpiall = 0;
        $jmlkpisudahinput = 0;
        $jmlkpinull = 0;
        $namarisiko ="Risiko Bisnis";
        $user = Auth::user();
        $role = Role::findByName('verifikatur');
        $users = $role->users;
        $nikuser = $user->nik;
        $kelompokrisiko = Kelompokrisiko::get();
        $unitid = $user->unit_id;
        $unitkerja = Unitkerja::get();
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $unituser = unitkerja::where('objectabbr',$request->unitkerja)->first();
       
        $risikobisnis = Risikobisnis::byId($periodeaktif->id)->byUnit($request->unitkerja)->first();
        $tabel='';
        if(isset($request->periode ) && isset($request->unitkerja)){
            
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
            if($risikobisnis==null){
                $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>KPI</th>
                    <th>Pilih</th>
                    <th>Risiko</th>
                    <th>Peluang</th>
                    <th>Kelompok</th>
                    <th width="10%">Kaidah</th>
                    <th>Dampak</th>
                    <th>Warna</th>
                    <th>Sumber risiko</th>
                    <th>Indikator</th>
                    <th>Nilai ambang</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="12" align="center"><b>Tidak Ada Data</b></td></tr></tbody></table>';
            }else{
                $statusrisiko = $risikobisnis->statusrisiko_id;
            if($risikobisnis){
            $tabel='';
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->paginate(10);
            $detailrisk->withPath('resikobisnis?periode='.$request->periode.'&_token=cZYtqdssnfDLjJZxC8D5wfbsmCFksv1H1oNHIkPx');
            $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Pilih</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Kelompok</th>
                <th width="10%">Kaidah</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'matrikrisiko.tingkat')
                ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                ->join("matrikrisiko",function($join){
                    $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                         ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                    })
                ->leftjoin("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
                    ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");;
                })
                ->get();
                $kpi = Kpi::where('id',$data->kpi_id)->first();
                $jmldetailkpi = count($detailkpi);
                
                $tabel.='<tr>';
                if($jmldetailkpi > 1){
                    $tabel.='<td rowspan="'.$jmldetailkpi.'">'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $tabel.='<td>'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td>'.$data->namakpi.'</td>';
                    }
                    
                }
                foreach($detailkpi as $keys=>$values){
                    $notif = komentar_detail::where('nik',$nikuser)->where('baca',0)->where('risikobisnisdetail_id',$values->id)->get();
                    $jmlnotif = count($notif);
                    if($jmlnotif > 0){
                        $hasil = '<span class="label label-warning">'.$jmlnotif.'</span>';
                    }else{
                        $hasil = '';
                    }
                    if($keys==0){
                        $tabel.='
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$values->id.'"></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>';
                        if($risikobisnis->statusrisiko_id <=1){
                            $tabel.='<td>
                        <a href="'.url('edit',['id'=>$values->id]).'" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>
                        </td>';
                        }else{
                            $tabel.='<td></td>';
                        }
                        $tabel.='</tr>';
                    }else{
                        $tabel.='<tr>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$values->id.'"></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>';
                        if($risikobisnis->statusrisiko_id <=1){
                            $tabel.='<td>
                        <a href="'.url('edit',['id'=>$values->id]).'" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>
                        </td>';
                        }else{
                            $tabel.='<td></td>';
                        }
                        $tabel.='</tr>';
                    }
                }

            }
            $tabel.='</tbody></table>';
            $tabel.=$detailrisk->links();
            }else{
                $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>KPI</th>
                    <th>Pilih</th>
                    <th>Risiko</th>
                    <th>Peluang</th>
                    <th>Kelompok</th>
                    <th width="10%">Kaidah</th>
                    <th>Dampak</th>
                    <th>Warna</th>
                    <th>Sumber risiko</th>
                    <th>Indikator</th>
                    <th>Nilai ambang</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="12" align="center"><b>Tidak Ada Data</b></td></tr></tbody></table>';
            }
            $status = 0;
            $cekkpinull = Kpi::byId($request->periode)->byStatus($status)->byUnit($unitid)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($request->periode)->byUnit($unitid)->get();
            $jmlkpiall = count($cekkpiall);

            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($request->periode)->byStatus($statusinput)->byUnit($unitid)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);
            }
            

            
        }else{
           
            $risikobisnis = Risikobisnis::byId($periodeaktif->id)->byUnit($unitid)->first();
            if($risikobisnis==null){
                $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Pilih</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Kelompok</th>
                <th width="10%">Kaidah</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            $tabel.='</tbody></table>';
            }else{
                $status = 0;
            $cekkpinull = Kpi::byId($periodeaktif->id)->byStatus($status)->byUnit($unitid)->get();
            $jmlkpinull = count($cekkpinull);
            
            $cekkpiall = Kpi::byId($periodeaktif->id)->byUnit($unitid)->get();
            $jmlkpiall = count($cekkpiall);
    
            $statusinput = 1;
            $cekkpisudahinput = Kpi::byId($periodeaktif->id)->byStatus($statusinput)->byUnit($unitid)->get();
            $jmlkpisudahinput = count($cekkpisudahinput);
            $tabel='';
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->paginate(10);
            $detailrisk->withPath('resikobisnis?periode='.$request->periode.'&_token=cZYtqdssnfDLjJZxC8D5wfbsmCFksv1H1oNHIkPx');
            $tabel.='<table id="tblresikobisnis" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>KPI</th>
                <th>Pilih</th>
                <th>Risiko</th>
                <th>Peluang</th>
                <th>Kelompok</th>
                <th width="10%">Kaidah</th>
                <th>Dampak</th>
                <th>Warna</th>
                <th>Sumber risiko</th>
                <th>Indikator</th>
                <th>Nilai ambang</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'matrikrisiko.tingkat')
                ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                ->join("matrikrisiko",function($join){
                    $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                         ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                    })
                ->leftjoin("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
                    ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");;
                })
                ->get();
                $kpi = Kpi::where('id',$data->kpi_id)->first();
                $jmldetailkpi = count($detailkpi);
                
                $tabel.='<tr>';
                if($jmldetailkpi > 1){
                    $tabel.='<td rowspan="'.$jmldetailkpi.'">'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td rowspan="'.$jmldetailkpi.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td rowspan="'.$jmldetailkpi.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $tabel.='<td>'.($detailrisk->firstItem() + $key).'</td>';
                    if($kpi->level=='2'){
                        $tabel.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $tabel.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $tabel.='<td>'.$data->namakpi.'</td>';
                    }
                    
                }
                foreach($detailkpi as $keys=>$values){
                    $notif = komentar_detail::where('nik',$nikuser)->where('baca',0)->where('risikobisnisdetail_id',$values->id)->get();
                    $jmlnotif = count($notif);
                    if($jmlnotif > 0){
                        $hasil = '<span class="label label-warning">'.$jmlnotif.'</span>';
                    }else{
                        $hasil = '';
                    }
                    if($keys==0){
                        $tabel.='
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$values->id.'"></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>';
                        if($risikobisnis->statusrisiko_id <=1){
                            $tabel.='<td>
                        <a href="'.url('edit',['id'=>$values->id]).'" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>
                        </td>';
                        }else{
                            $tabel.='<td></td>';
                        }
                        $tabel.='</tr>';
                    }else{
                        $tabel.='<tr>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>
                        <td><input type="checkbox" name="kaidah[]" class="form-controll" value="'.$values->id.'"></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namakelompok).'</td>';
                        if($values->kaidah==1){
                        $tabel.='<td><a class="btn btn-primary"><i class="fa fa-thumbs-up" title="Sesuai kaidah"></i></a></td>';
                        }else{
                        $tabel.='<td><a class="btn btn-warning"><i class="fa fa-thumbs-down" title="Tidak sesuai kaidah"></i></a></td>';
                        }
                        $tabel.='<td>'.$this->cek_kri($values->jenisrisiko,$values->dampak).'</td><td><button type="button" class="btn btn-'.$values->warna.' btn-sm">'.$values->tingkat.'</button></td>
                        <td><a class="btn btn-primary" href="#" data-toggle="modal"
                        data-target="#modal-sumberresikobisnis"
                        onclick="sumberrisiko(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-reorder (alias)"
                            title="List sumber risiko"></i></a></td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td><td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>';
                        if($risikobisnis->statusrisiko_id <=1){
                            $tabel.='<td>
                        <a href="'.url('edit',['id'=>$values->id]).'" class="btn btn-small" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-small" href="#" data-toggle="modal" data-target="#modal-komentar" onclick="readkomen(\''.$values->id. '\',\'' .$values->risiko. '\')"><i class="fa fa-commenting-o" title="Komentar"></i>'.$hasil.'</a>
                        </td>';
                        }else{
                            $tabel.='<td></td>';
                        }
                        $tabel.='</tr>';
                    }
                }

            }
            $tabel.='</tbody></table>';
            $tabel.=$detailrisk->links();
            }
            

        }
       
        $hsl = $tabel;
        
      
        return view('resiko.risikobisnisverifi.index', compact('risikobisnis','periodeall','namarisiko','unitkerja','nikuser','periodeaktif','jmlkpinull','jmlkpiall',
        'jmlkpisudahinput','kelompokrisiko','hsl'));
    }
    function cek_kri($jenis,$param){
        $hsl='';
        if($jenis=='1'||$jenis=='4'||$jenis=='5'||$jenis=='7'){
            $hsl.='<p class="text-red">'.$param.'</p>';
        }else{
            $hsl.=''.$param.'';
        }
        return $hsl;
    }
    function validasibisnis(Request $request,$id){
        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '3']);    
        if($risikobisnis){
            $user = Auth::user();
            $retval    = [];
            //$retval    = file_get_contents('http://eos.krakatausteel.com/api/structdisp/'.$user->nik);
            $retval = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$user->nik, false, stream_context_create($this->arrContextOptions));
        
            $jessval   =json_decode($retval);
            $personnel_no     = $jessval->personnel_no;
            $name             = $jessval->name;
            $position_name    = $jessval->position_name;
            
            $dtval = new Validasibisnis();
            $dtval->risikobisnis_id     =  $id;
            $dtval->nik     =  $personnel_no;
            $dtval->nama    =  $name;
            $dtval->jabatan =  $position_name;
            $dtval->aktorvalidasi_id = 2;
            $dtval->statusvalidasi_id =3;
            $dtval->tglvalidasi =date("Y-m-d H:i:s");
            $dtval->save();

            $hsl='success';
            return $hsl;
        }
        return Redirect::back()->withErrors(['msg', 'Error']);
    }
    function batalvalidasibisnis(Request $request,$id){
        //dapatkan informasi user
        $user = Auth::user();
        $datariskbisnis = Risikobisnis::where('id',$id)->first();
        
        if($datariskbisnis->statusrisiko_id > 3){
            $hsl='gagal';
            return $hsl;
        }else{
            $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '2']);
            if($risikobisnis){
                $hapus = Validasibisnis::where('nik',$user->nik)->where('risikobisnis_id',$id)->delete();
                $hsl='success';
                return $hsl;
            }
        }
        
        return Redirect::back()->withErrors(['msg', 'Error']);
    }
    public function sesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['kaidah'=>1,'tglkaidah'=>date("Y-m-d H:i:s")]);
        }

    }
    public function tidaksesuaikaidah(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['kaidah'=>0,'tglkaidah'=>date("Y-m-d H:i:s")]);
        }

    }
    public function highlight(Request $request){
        $highlight         = $request->kaidah;
        foreach($highlight as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['highlight'=>1,'tglhighlight'=>date("Y-m-d H:i:s")]);
        }

    }
    public function batalhighlight(Request $request){
        $highlight         = $request->kaidah;
        foreach($highlight as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['highlight'=>0,'tglhighlight'=>date("Y-m-d H:i:s")]);
        }

    }
    public function readkomen(Request $request,$id){
        $user = Auth::user();
        $dilihat = Komentar_detail::where('nik',$user->nik)->where('risikobisnisdetail_id',$id)->update(['baca'=>1,'tglbaca'=>date("Y-m-d H:i:s")]);
        $komen = Komentar::where('risikobisnisdetail_id',$id)->orderBy('id', 'DESC')->get();
        return $komen;

    }
    public function kirimkomentar(Request $request){
        $user = Auth::user();
        $roles = Auth::user()->roles;
        $message    = $request->message;
        $id         = $request->idrisiko;
        $detid      = $request->detailrisikoid;
        //getriskdetail

        $riskdetail = Risikobisnisdetail::where('id',$detid)->first();
        
        $dtval = new Komentar();
        $dtval->risikobisnisdetail_id  =  $detid;
        $dtval->risikobisnis_id        =  $id;
        $dtval->nik      =  $user->nik;
        $dtval->nama     =  $user->name;
        $dtval->komentar =  $message;
        $dtval->creator  =  $user->nik;
        $dtval->save();

        $risikobisnis = Risikobisnis::where('id',$id)->update(['statusrisiko_id' => '1']);
            if($risikobisnis){
                $hapus = Validasibisnis::where('nik',$user->nik)->where('risikobisnis_id',$id)->delete();
                $komendet = new Komentar_detail();
                $komendet->komentar_id   = $dtval->id;
                $komendet->risikobisnisdetail_id  = $detid;
                $komendet->nik   = $riskdetail->creator;
                $komendet->nama  ='';
                $komendet->baca  = 0;
                $komendet->save();
            }
        
    }
    public function kpi(Request $request){
        $user = Auth::user();
        $unitid = $user->unit_id;
        $judul = "KPI";
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $kpi =Kpi::tahunAktif($periodeaktif->tahun)
        ->join('unitkerja', 'kpi.unit_id', '=', 'unitkerja.objectabbr')
        ->select('kpi.*', 'unitkerja.nama as namaunit')
        // ->byUnit($unitid)
        ->get();
        return view('resiko.risikobisnisverifi.kpiindex', compact('judul', 'kpi'));
    }
    public function cl(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'CL']);
        }

    }
    public function kri(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'KRI']);
        }

    }
    public function kri_rkap(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'KRI RKAP']);
        }

    }
    public function batalkri(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'']);
        }

    }
    public function rkap(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'RKAP']);
        }

    }
    public function batalrkap(Request $request){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>'']);
        }

    }
    public function kelompokrisiko(Request $request,$id){
        $kaidah         = $request->kaidah;
        foreach($kaidah as $key=>$value){
            $riskdetail = Risikobisnisdetail::where('id',$value)->update(['jenisrisiko'=>$id]);
        }
    }
    public function krirkap(Request $request){
        $namarisiko ="Risiko Bisnis KRI/RKAP";
        $user = Auth::user();
        $nikuser = $user->nik;
        $unitkerja = Unitkerja::get();
        $periodeall = Perioderisikobisnis::get();
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        if(isset($request->periode ) && isset($request->unitkerja)){
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
           }
        
        return view('resiko.risikobisnisverifi.risikobisniskrirkap', compact('risikobisnis','periodeall','namarisiko','unitkerja','nikuser','periodeaktif'));
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
