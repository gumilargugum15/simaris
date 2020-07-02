<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitkerja;
use App\Risikobisnis;
use App\Risikobisnisdetail;
use App\Perioderisikobisnis;
use App\Sumberrisiko;
use App\Kpi;
use App\Klasifikasi;
use App\Peluang;
use App\Dampak;
use App\Kriteria;
use App\Matrikrisiko;
use App\Exports\RisikobisnisExport;
use Maatwebsite\Excel\Facades\Excel;
class LaprisikobisnisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gcgnama='';
        $keynama='';
        $pimpnama='';

        $unitkerja = Unitkerja::get();
        $periodeall = Perioderisikobisnis::get();
        $tingkat='';
        $hsl='';
        if(isset($request->periode ) && isset($request->unitkerja)&& isset($request->tingkat)){
            $tingkat = $request->tingkat;
            $periode = Perioderisikobisnis::where('id',$request->periode)->first();
            $unit = unitkerja::where('objectabbr',$request->unitkerja)->first();
            $risikobisnis = Risikobisnis::byId($request->periode)->byUnit($request->unitkerja)->first();
            if($risikobisnis){
                if($tingkat=='All'){
                    $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
                    ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
                    ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
                    ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->get();
                }else{
                    
                    $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
                    ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
                    ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
                    ->join("matrikrisiko",function($join){
                        $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                             ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                        })
                    ->where('matrikrisiko.tingkat',$tingkat)
                    ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->get();
                }
                $hsl.='<table>';
                $hsl.='<tr>';
                $hsl.='<td colspan="6">Unit kerja : '.$unit->nama.'</td><td colspan="4" rowspan="2">RISIKO UNIT KERJA</td><td colspan="5">Tujuan pokok dan fungsi : </td>';
                $hsl.='</tr>';
                $hsl.='<tr>';
                $hsl.='<td colspan="6">Periode : '.$periode->nama.'</td><td colspan="5"> (1.) Mengorganisasikan, mengkoordinasikan dan mengadministrasikan serta mengendalikan masalah-masalah yang timbul dari transaksi penerimaan dan pengeluaran dana perusahaan meliputi ; transaksi pembukaan dan pembayaran L/C impor, menerbitkan laporan-laporan pokok operasi pendanaan				
                </td>';
                $hsl.='</tr><tr><th colspan="15"></th></tr>';
                $hsl.='<tr>
                            <th colspan="2">TUJUAN</th><th  colspan="6">IDENFITIKASI RISIKO</th><th colspan="5">PENILAIAN RISIKO</th><th>PENETAPAN RESPON RISIKO</th><th>TINDAK LANJUT</th>
                        </tr>
                        <tr align="center">
                        <th>NO</th><th width="5">KPI</th><th>KLASIFIKASI</th><th>NAMA RISIKO</th><th>SUMBER RISIKO</th><th>AKIBAT</th><th>INDIKATOR</th><th>NILAI AMBANG</th>
                            <th>PELUANG</th><th>LEVEL</th><th>DAMPAK</th><th>LEVEL</th><th>TINGKAT RISIKO</th>
                            <th>MITIGASI</th>
                            <th>PIC</th>
                        </tr>
                        ';
                        $no = 1;
                    foreach($detailrisk as $key =>$data ){
                        
                        if($tingkat=='All'){
                            $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                        ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','peluang.level as levelpeluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'kriteria.level as leveldampak', 'matrikrisiko.tingkat', 'klasifikasi.nama as namaklas')
                        ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                        ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                        ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
                        ->join("matrikrisiko",function($join){
                            $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                                 ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                            })
                        ->leftjoin("kriteria",function($join){
                        $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                            ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
                            ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");
                        })
                        ->get();
                        }else{
                            $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                        ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','peluang.level as levelpeluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'kriteria.level as leveldampak', 'matrikrisiko.tingkat', 'klasifikasi.nama as namaklas')
                        ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                        ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                        ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
                        ->join("matrikrisiko",function($join){
                            $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                                 ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                            })
                        ->where('matrikrisiko.tingkat',$tingkat)
                        ->leftjoin("kriteria",function($join){
                        $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                            ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id")
                            ->on("kriteria.tipe","=","risikobisnisdetail.kriteriatipe");
                        })
                        ->get();
                        }
                        
                        
                        $kpi = Kpi::where('id',$data->kpi_id)->first();
                        if($tingkat=='All'){
                            $sumber = Sumberrisiko::where('kpi_id',$data->kpi_id)
                        ->get();
                        }else{
                            $sumber = Sumberrisiko::where('kpi_id',$data->kpi_id)
                        ->join("matrikrisiko",function($join){
                            $join->on("matrikrisiko.dampak_id","=","sumberrisiko.dampak_id")
                                 ->on("matrikrisiko.peluang_id","=","sumberrisiko.peluang_id");
                            })
                        ->where('matrikrisiko.tingkat',$tingkat)
                        ->get();
                        }
                        
                        $jmldetailsumber = count($sumber);
                        
                        $jmldetailkpi = count($detailkpi);
                        if($tingkat=='All'){
                            $jml = $jmldetailkpi;
                        }else{
                            $jml = $jmldetailsumber;
                            
                        }
                        
                        $hsl.='<tr>';
                        if($jml > 1){
                            $hsl.='<td rowspan="'.$jmldetailsumber.'">'.$no.'</td>';
                            if($kpi->level=='2'){
                                $hsl.='<td rowspan="'.$jmldetailsumber.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                            }elseif($kpi->level=='1'){
                                $hsl.='<td rowspan="'.$jmldetailsumber.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                            }else{
                                $hsl.='<td rowspan="'.$jmldetailsumber.'">'.$data->namakpi.'</td>';
                            }
                            
                        }else{
                            $hsl.='<td>'.$no.'</td>';
                            if($kpi->level=='2'){
                                $hsl.='<td><p class="text-red">'.$data->namakpi.'</p></td>';
                            }elseif($kpi->level=='1'){
                                $hsl.='<td><p class="text-yellow">'.$data->namakpi.'</p></td>';
                            }else{
                                $hsl.='<td>'.$data->namakpi.'</td>';
                            }
                            
                        }
                        foreach($detailkpi as $keys=>$values){
                            $sumberrisk = Sumberrisiko::where('risikobisnisdetail_id',$values->id)->get();
                            $jmlsumberrisk= count($sumberrisk);
                            if($keys==0){
                                if($jmlsumberrisk >1){
                                    $hsl.='
                                <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'</td>
                                <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                                foreach($sumberrisk as $keysumber=>$valuesumber){
                                    if($keysumber==0){
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->akibat).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->levelpeluang).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">dampak</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->leveldampak).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->tingkat).'</td>
                                        <td>'.$valuesumber->mitigasi.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }else{
                                        $hsl.='<tr>';
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                                <td>'.$valuesumber->mitigasi.'</td>
                                                <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }
                                }
                                
                                }else{
                                    $hsl.='
                                <td>'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'</td>
                                <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                                foreach($sumberrisk as $keysumber=>$valuesumber){
                                    if($keysumber==0){
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->akibat).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->levelpeluang).'</td>
                                        <td>dampak</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->leveldampak).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->tingkat).'</td>
                                        <td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }else{
                                        $hsl.='<tr>';
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->akibat).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->levelpeluang).'</td>
                                        <td>dampak</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->leveldampak).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->tingkat).'</td>
                                        <td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }
                                }
                                
                                }
                                
                            }else{
                                if($jmlsumberrisk >1){
                                    $hsl.='<tr>
                                <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'</td>
                                <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                                foreach($sumberrisk as $keysumber=>$valuesumber){
                                    if($keysumber==0){
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->akibat).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->levelpeluang).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">dampak</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->leveldampak).'</td>
                                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->tingkat).'</td>
                                        <td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }else{
                                        $hsl.='<tr>';
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }
                                }
                                
                                }else{
                                    $hsl.='<tr>
                                <td>'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'</td>
                                <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                                foreach($sumberrisk as $keysumber=>$valuesumber){
                                    if($keysumber==0){
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->akibat).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->levelpeluang).'</td>
                                        <td>dampak</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->leveldampak).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->tingkat).'</td>
                                        <td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }else{
                                        $hsl.='<tr>';
                                        $hsl.='<td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->akibat).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->indikator).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->nilaiambang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->peluang).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->levelpeluang).'</td>
                                        <td>dampak</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->leveldampak).'</td>
                                        <td>'.$this->cek_kri($values->jenisrisiko,$values->tingkat).'</td>
                                        <td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                        $hsl.='</tr>';
                                    }
                                }
                               
                                }
                                
                            }
                        }
                        
                    
                        $no++;
                    }
                // $hsl.='<tr><td colspan="9">Catatan :</td><td colspan="2">Manager Legal, Risk Dan Compliance</td><td colspan="2">KEY PERSON</td><td colspan="2">'.$unit->nama.'</td></tr>';
                // $hsl.='<tr><td colspan="9" rowspan="4"></td><td colspan="2" rowspan="3"></td><td colspan="2" rowspan="3"></td><td colspan="2" rowspan="3"></td></tr>';
                // $hsl.='<tr><td></td></tr>';
                // $hsl.='<tr><td></td></tr>';
                // $hsl.='<tr><td colspan="2">'.$gcgnama.'</td><td colspan="2">'.$keynama.'</td><td colspan="2">'.$pimpnama.'</td></tr>';
                $hsl.='</table>';
            }else{
                $hsl.='<div align="center">Data tidak ada</div>';
            }
            
        }
        return view('laporan.laprisikobisnis', compact('risikobisnis','periodeall','unitkerja','hsl','tingkat'));
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
    public function export(Request $request) 
    {
        $period = $request->periode;//'Kwartal I-2019';//
        $unit   = $request->unit;//'36000';//
        $tingkat= $request->tingkat;
        // dd($period."-".$unit."-".$tingkat);
        
        // return Excel::download(new RisikobisnisExport, 'risikobisnis.xlsx');
        return (new RisikobisnisExport)
            ->forPeriod($period)
            ->forUnit($unit)
            ->forTingkat($tingkat)
            ->download('Risikobisnis.xlsx');
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
