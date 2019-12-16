<?php

namespace App\Exports;

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
use Maatwebsite\Excel\Concerns\FromCollection;
// use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


  class RisikobisnisExport implements FromCollection
// class RisikobisnisExport implements FromView
{
    
    // public function collection()
    // {
    //     return Risikobisnis::all();
    // }
    use Exportable;
    // public function forPeriod($periode){
    //     $this->periode = $periode;
    //     return $this;
    // }
    // public function forUnit($unit){
    //     $this->unit = $unit;
    //     return $this;
    // }
    // public function forTingkat($tingkat){
    //     $this->tingkat = $tingkat;
    //     return $this;
    // }
    public function collection()
    //  public function view(): View
    {
        return Kpi::all();
       

            // $periode = Perioderisikobisnis::where('id',$this->periode)->first();
            // $unit = unitkerja::where('objectabbr',$this->unit)->first();
            // $risikobisnis = Risikobisnis::byId($this->periode)->byUnit($this->unit)->first();
            
            // if($risikobisnis){
            //     if($this->tingkat=='All'){
            //         $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            //         ->select('risikobisnisdetail.*', 'kpi.nama as namakpi', 'klasifikasi.nama as namaklas', 'peluang.kriteria as peluang', 'peluang.level as levelpeluang', 'kriteria.nama as dampak', 'kriteria.level as leveldampak', 'matrikrisiko.tingkat')
            //         ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            //         ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
            //         ->join('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
            //         ->join("kriteria",function($join){
            //             $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
            //                 ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
            //             })
            //         ->join("matrikrisiko",function($join){
            //             $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
            //                 ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
            //             })
            //         ->orderBy('kpi_id','asc')->get();
            //     }else{
            //         $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            //         ->select('risikobisnisdetail.*', 'kpi.nama as namakpi', 'klasifikasi.nama as namaklas', 'peluang.kriteria as peluang', 'peluang.level as levelpeluang', 'kriteria.nama as dampak', 'kriteria.level as leveldampak', 'matrikrisiko.tingkat')
            //         ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            //         ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
            //         ->join('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
            //         ->join("kriteria",function($join){
            //             $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
            //                 ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
            //             })
            //         ->join("matrikrisiko",function($join){
            //             $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
            //                 ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
            //             })
            //         ->where('matrikrisiko.tingkat',$this->tingkat)
            //         ->orderBy('kpi_id','asc')->get();
            //     }
            // $hsl='';
            // $hsl.='<table id="lapriskbisnis" class="table table-bordered table-striped">';
            // $hsl.='<tr>';
            // $hsl.='<th width="30%">Unit kerja : '.$unit->nama.'</th>';
            // $hsl.='<th align="center" rowspan="2" valign="center"><b>Risiko Unit Kerja</b></th>';
            // $hsl.='<th width="20%">Tingkat Risiko:</th>';
            // // $hsl.='<td width="50%">Tujuan pokok & fungsi :</td>';
            // $hsl.='</tr>';
            // $hsl.='<tr>';
            // $hsl.='<th>Periode : '.$periode->nama.' Tahun '.$periode->tahun.'</th>';
            // $hsl.='<th>'.$this->tingkat.'</th>';
            // // $hsl.='<td>(1.) Mengorganisasikan, mengkoordinasikan, merekomendasikan dan melaksanakan program dan kegiatan perencanaan strategis perusahaan; penyusunan/evaluasi study kelayakan proyek strategis (non rutin), evaluasi study kelayakan proyek non strategis (rutin), penyusunan usulan prioritas proyek untuk dimasukan ke dalam RKAP, mengevaluasi kelayakan proyrk investasi anak perush. dan perush. patungan; penyusunan RJPP baik induk maupun Konsolidasi, dan atau perusahaan patungan (PP) termasuk penyusunan formula tarif bagi KS Group, dlm rangka mengintegrasikan rencana jangka panjang korporasi (KS Group) dan meningkatkan sinergi bisnis pada fungsi pada fungsi operasioanal di PT KS dan Group</td>';
            // $hsl.='</tr>';

            // $hsl.='</table>';
            // $hsl.='<table class="table table-bordered table-striped">';
            // $hsl.='<tr class="lapriskbisnis">';
            // $hsl.='<th width="30%" colspan="2">TUJUAN</th><th width="30%" colspan="6">DENFITIKASI RISIKO</th><th width="30%" colspan="5">PENILAIAN RISIKO</th><th width="30%" colspan="3">PENETAPAN RESPON RISIKO</th><th width="30%" colspan="2">TINDAK LANJUT</th>';
            // $hsl.='</tr>';
            // $hsl.='<tr class="lapriskbisnis">';
            // $hsl.='<th>NO</th><th>KPI</th><th>KLASIFIKASI</th><th>NAMA RISIKO</th><th>SUMBER RISIKO</th><th>AKIBAT</th><th>INDIKATOR</th><th>NILAI AMBANG</th>';
            // $hsl.='<th>PELUANG</th><th>LEVEL</th><th>DAMPAK</th><th>LEVEL</th><th>TINGKAT RISIKO</th>';
            // $hsl.='<th>MITIGASI</th><th>BIAYA</th><th>TARGET</th>';
            // $hsl.='<th>PIC</th><th>STATUS</th>';
            // $hsl.='</tr>';
            // $no =1;
            // foreach($detailrisk as $data ){
            //     $sumber = Sumberrisiko::where('risikobisnisdetail_id',$data->id)->get();
            //     $jmlsumber = count($sumber);
            //     if($jmlsumber > 1){
            //     $hsl.='<tr>';
            //     $hsl.='<td rowspan="'.$jmlsumber.'">'.$no.'</td><td rowspan="'.$jmlsumber.'">'.$data->namakpi.'</td><td rowspan="'.$jmlsumber.'">'.$data->namaklas.'</td><td rowspan="'.$jmlsumber.'">'.$data->risiko.'</td>';
            //     foreach($sumber as $key =>$dsumber){
            //         if($key==0){
            //             $hsl.='<td>'.$dsumber->namasumber.'</td><td rowspan="'.$jmlsumber.'">'.$data->akibat.'</td><td rowspan="'.$jmlsumber.'">'.$data->indikator.'</td><td rowspan="'.$jmlsumber.'">'.$data->nilaiambang.'</td><td rowspan="'.$jmlsumber.'">'.$data->peluang.'</td><td rowspan="'.$jmlsumber.'">'.$data->levelpeluang.'</td><td rowspan="'.$jmlsumber.'">'.$data->dampak.'</td><td rowspan="'.$jmlsumber.'">'.$data->leveldampak.'</td><td rowspan="'.$jmlsumber.'">'.$data->tingkat.'</td><td>'.$dsumber->mitigasi.'</td><td>'.$dsumber->biaya.'</td><td>'.$dsumber->start_date.' s/d '.$dsumber->start_date.'</td><td>'.$dsumber->pic.'</td><td>'.$dsumber->statussumber.'</td>';
            //         }else{
            //             $hsl.='<tr><td>'.$dsumber->namasumber.'</td><td>'.$dsumber->mitigasi.'</td><td>'.$dsumber->biaya.'</td><td>'.$dsumber->start_date.' s/d '.$dsumber->start_date.'</td><td>'.$dsumber->pic.'</td><td>'.$dsumber->statussumber.'</td></tr>';
            //         }
                    
            //     }
            //     $hsl.='</tr>';
                
            //     }else{
            //     $hsl.='<tr>';
            //     $hsl.='<td>'.$no.'</td><td>'.$data->namakpi.'</td><td>'.$data->namaklas.'</td><td>'.$data->risiko.'</td>';
            //     foreach($sumber as $dsumber){
            //         $hsl.='<td>'.$dsumber->namasumber.'</td><td>'.$data->akibat.'</td><td>'.$data->indikator.'</td><td>'.$data->nilaiambang.'</td><td>'.$data->peluang.'</td><td>'.$data->levelpeluang.'</td><td>'.$data->dampak.'</td><td>'.$data->leveldampak.'</td><td>'.$data->tingkat.'</td><td>'.$dsumber->mitigasi.'</td><td>'.$dsumber->biaya.'</td><td>'.$dsumber->start_date.' s/d '.$dsumber->start_date.'</td><td>'.$dsumber->pic.'</td><td>'.$dsumber->statussumber.'</td>';
            //     }
            //     }
            //     $hsl.='</tr>';
                
            // $no++;
            
            // }
            // $hsl.='</table>';
            // }
        // return view('exports.risikobisnis', [
        //     'risiko' => Kpi::all()
        // ]);
    }
    
}




















































































































































































































































































































































