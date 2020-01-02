<?php
namespace App\Exports;
 
use App\Risikobisnis;
use App\Kpi;
use App\Unitkerja;
use App\Perioderisikobisnis;
use App\Risikobisnisdetail;
use App\Sumberrisiko;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View; 
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

// class RisikobisnisExport implements FromCollection
class RisikobisnisExport implements FromView,  ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    // public function collection()
    public function view(): View
    {
        $unit = unitkerja::where('objectabbr','53200')->first();
        $periode = Perioderisikobisnis::where('id','1')->first();
        $risikobisnis = Risikobisnis::byId('1')->byUnit('53200')->first();
        
        $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)
            ->select('risikobisnisdetail.kpi_id','kpi.nama as namakpi')
            ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->get();
        
        $hsl='';
        $hsl.='<table>
                    <thead>
                    <tr>
                    <th colspan="2">TUJUAN</th><th  colspan="6">IDENFITIKASI RISIKO</th><th colspan="5">PENILAIAN RISIKO</th><th colspan="3">PENETAPAN RESPON RISIKO</th><th colspan="2">TINDAK LANJUT</th>
                </tr>
                <tr align="center">
                    <th>NO</th><th>KPI</th><th>KLASIFIKASI</th><th>NAMA RISIKO</th><th>SUMBER RISIKO</th><th>AKIBAT</th><th>INDIKATOR</th><th>NILAI AMBANG</th>
                    <th>PELUANG</th><th>LEVEL</th><th>DAMPAK</th><th>LEVEL</th><th>TINGKAT RISIKO</th>
                    <th>MITIGASI</th><th>BIAYA</th><th>TARGET</th>
                    <th>PIC</th><th>STATUS</th>
                </tr>
                </thead>
                <tbody>';
                $no = 1;
            foreach($detailrisk as $key =>$data ){
                $detailkpi = Risikobisnisdetail::where('kpi_id',$data->kpi_id)
                ->select('risikobisnisdetail.*', 'peluang.kriteria as peluang','kelompokrisiko.nama as namakelompok', 'kriteria.nama as dampak', 'matrikrisiko.tingkat', 'klasifikasi.nama as namaklas')
                ->leftjoin('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
                ->leftjoin('kelompokrisiko', 'kelompokrisiko.id', '=', 'risikobisnisdetail.jenisrisiko')
                ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
                ->join("matrikrisiko",function($join){
                    $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                         ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
                    })
                ->leftjoin("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
                })
                ->get();
                $kpi = Kpi::where('id',$data->kpi_id)->first();
                $sumber = Sumberrisiko::where('kpi_id',$data->kpi_id)->get();
                $jmldetailsumber = count($sumber);
                $jmldetailkpi = count($detailkpi);
                
                $hsl.='<tr>';
                if($jmldetailkpi > 1){
                    $hsl.='<td rowspan="'.$jmldetailsumber.'">'.$no.'-'.$jmldetailsumber.'</td>';
                    if($kpi->level=='2'){
                        $hsl.='<td rowspan="'.$jmldetailsumber.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $hsl.='<td rowspan="'.$jmldetailsumber.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $hsl.='<td rowspan="'.$jmldetailsumber.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $hsl.='<td>'.$no.'-'.$jmldetailsumber.'</td>';
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
                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'-'.$jmlsumberrisk.'</td>
                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                        foreach($sumberrisk as $keysumber=>$valuesumber){
                            if($keysumber==0){
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }else{
                                $hsl.='<tr>';
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }
                        }
                        // $hsl.='</tr>';
                        }else{
                            $hsl.='
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'-'.$jmlsumberrisk.'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                        foreach($sumberrisk as $keysumber=>$valuesumber){
                            if($keysumber==0){
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }else{
                                $hsl.='<tr>';
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }
                        }
                        // $hsl.='</tr>';
                        }
                        
                    }else{
                        if($jmlsumberrisk >1){
                            $hsl.='<tr>
                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'-'.$jmlsumberrisk.'</td>
                        <td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                        foreach($sumberrisk as $keysumber=>$valuesumber){
                            if($keysumber==0){
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }else{
                                $hsl.='<tr>';
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }
                        }
                        // $hsl.='</tr>';
                        }else{
                            $hsl.='<tr>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'-'.$jmlsumberrisk.'</td>
                        <td>'.$this->cek_kri($values->jenisrisiko,$values->risiko).'</td>';
                        foreach($sumberrisk as $keysumber=>$valuesumber){
                            if($keysumber==0){
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }else{
                                $hsl.='<tr>';
                                $hsl.='<td>sumber</td>';
                                $hsl.='</tr>';
                            }
                        }
                        // $hsl.='</tr>';
                        }
                        
                    }
                }
                
            //    $hsl.='</tr>';

                $no++;
            }
        $hsl.='</tbody></table>';
        return view('exports.risikobisnis', ['unit'=>$unit,'periode'=>$periode,'detailrisk'=>$detailrisk,'tabel'=>$hsl]);
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
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $styleArray = [
                //     'borders' => [
                //         'outline' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                //             'color' => ['argb' => '00000000'],
                //         ],
                //     ],
                // ];
                // $cellRange = 'A1:R16'; // All headers
                // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:R2')->getAlignment()->applyFromArray([
                    'horizontal' =>'center',
                    ]);
                $event->sheet->getStyle('A1:R13')->getAlignment()->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}