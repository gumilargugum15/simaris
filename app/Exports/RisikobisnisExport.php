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
use Maatwebsite\Excel\Concerns\WithDrawings;

// class RisikobisnisExport implements FromCollection
class RisikobisnisExport implements FromView,  ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function forPeriod($periode){
            $this->periode = $periode;
            return $this;
    }
    public function forUnit($unit){
        $this->unit = $unit;
        return $this;
    }
    public function forTingkat($tingkat){
        $this->tingkat = $tingkat;
        return $this;
    }
    public function forYou(){
        $this->jml = 0;
        return $this;
    }
    // public function collection()
    public function view(): View
    {
        $unit = unitkerja::where('objectabbr',$this->unit)->first();
        $periode = Perioderisikobisnis::where('id',$this->periode)->first();
        $risikobisnis = Risikobisnis::byId($this->periode)->byUnit($this->unit)->first();
        

        if($this->tingkat=='All'){
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
            ->where('matrikrisiko.tingkat',$this->tingkat)
            ->groupBy('risikobisnisdetail.kpi_id','kpi.nama')->orderBy('kpi.level','desc')->get();
        }
        // dd($detailrisk);
        
        $hsl='';
        
        $hsl.='<table>';
        $hsl.='<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>';
        $hsl.='<tr>';
        $hsl.='<td></td><td colspan="6">Unit kerja : '.$unit->nama.'</td><td colspan="4" rowspan="2">RISIKO UNIT KERJA</td><td colspan="4">Tujuan pokok dan fungsi : </td>';
        $hsl.='</tr>';
        $hsl.='<tr>';
        $hsl.='<td></td><td colspan="6">Periode : '.$periode->nama.'</td><td colspan="4"> (1.) Mengorganisasikan, mengkoordinasikan dan mengadministrasikan serta mengendalikan masalah-masalah yang timbul dari transaksi penerimaan dan pengeluaran dana perusahaan meliputi ; transaksi pembukaan dan pembayaran L/C impor, menerbitkan laporan-laporan pokok operasi pendanaan				
        </td>';
        $hsl.='</tr>';
        $hsl.='<tr>
                    <th></th><th colspan="2">TUJUAN</th><th  colspan="6">IDENFITIKASI RISIKO</th><th colspan="5">PENILAIAN RISIKO</th><th>PENETAPAN RESPON RISIKO</th><th>TINDAK LANJUT</th>
                </tr>
                <tr align="center">
                <th></th><th>NO</th><th width="5">KPI</th><th>KLASIFIKASI</th><th>NAMA RISIKO</th><th>SUMBER RISIKO</th><th>AKIBAT</th><th>INDIKATOR</th><th>NILAI AMBANG</th>
                    <th>PELUANG</th><th>LEVEL</th><th>DAMPAK</th><th>LEVEL</th><th>TINGKAT RISIKO</th>
                    <th>MITIGASI</th>
                    <th>PIC</th>
                </tr>
                ';
                $no = 1;
            foreach($detailrisk as $key =>$data ){
                
                if($this->tingkat=='All'){
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
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
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
                ->where('matrikrisiko.tingkat',$this->tingkat)
                ->leftjoin("kriteria",function($join){
                $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                    ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
                })
                ->get();
                }
                
                // dd($detailkpi);
                $kpi = Kpi::where('id',$data->kpi_id)->first();
                if($this->tingkat=='All'){
                    $sumber = Sumberrisiko::where('kpi_id',$data->kpi_id)
                ->get();
                }else{
                    $sumber = Sumberrisiko::where('kpi_id',$data->kpi_id)
                ->join("matrikrisiko",function($join){
                    $join->on("matrikrisiko.dampak_id","=","sumberrisiko.dampak_id")
                         ->on("matrikrisiko.peluang_id","=","sumberrisiko.peluang_id");
                    })
                ->where('matrikrisiko.tingkat',$this->tingkat)
                ->get();
                }
                
                $jmldetailsumber = count($sumber);
                
                $jmldetailkpi = count($detailkpi);
                if($this->tingkat=='All'){
                    $jml = $jmldetailkpi;
                }else{
                    $jml = $jmldetailsumber;
                    //$jmldetailsumber= $jmldetailsumber;
                }
                // dd($sumber);
                $hsl.='<tr>';
                if($jml > 1){
                    $hsl.='<td></td><td rowspan="'.$jmldetailsumber.'">'.$no.'</td>';
                    if($kpi->level=='2'){
                        $hsl.='<td rowspan="'.$jmldetailsumber.'"><p class="text-red">'.$data->namakpi.'</p></td>';
                    }elseif($kpi->level=='1'){
                        $hsl.='<td rowspan="'.$jmldetailsumber.'"><p class="text-yellow">'.$data->namakpi.'</p></td>';
                    }else{
                        $hsl.='<td rowspan="'.$jmldetailsumber.'">'.$data->namakpi.'</td>';
                    }
                    
                }else{
                    $hsl.='<td></td><td>'.$no.'</td>';
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
                                $hsl.=' <td></td><td>'.$valuesumber->namasumber.'</td>
                                        <td>'.$valuesumber->mitigasi.'</td>
                                        <td>'.$valuesumber->pic.'</td>';
                                $hsl.='</tr>';
                            }
                        }
                        // $hsl.='</tr>';
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
                                $hsl.='<td></td><td>'.$valuesumber->namasumber.'</td>
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
                        // $hsl.='</tr>';
                        }
                        
                    }else{
                        if($jmlsumberrisk >1){
                            $hsl.='<tr>
                        <td></td><td rowspan="'.$jmlsumberrisk.'">'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'</td>
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
                                $hsl.='<td></td><td>'.$valuesumber->namasumber.'</td>
                                <td>'.$valuesumber->namasumber.'</td>
                                <td>'.$valuesumber->pic.'</td>';
                                $hsl.='</tr>';
                            }
                        }
                        // $hsl.='</tr>';
                        }else{
                            $hsl.='<tr>
                        <td></td><td>'.$this->cek_kri($values->jenisrisiko,$values->namaklas).'</td>
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
                                $hsl.='<td></td><td>'.$valuesumber->namasumber.'</td>
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
                        // $hsl.='</tr>';
                        }
                        
                    }
                }
                
            //    $hsl.='</tr>';

                $no++;
            }
        $hsl.='</table>';
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

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('logo.png'));
                $drawing->setCoordinates('B2');
                $drawing->setHeight(70);
                // $drawing->setWidth(40);
                $drawing->setWorksheet($event->sheet->getDelegate());

                $sheet = $event->sheet;
                $event->sheet->getStyle('B6:P27')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);
                // $sheet->getParent()->getDefaultStyle()->getAlignment()->setWrapText(true);
                $sheet->getStyle('A10:O18')->applyFromArray(
                    array(
                        'font' => array(
                            'name' => 'Calibri',
                            'size' => 10,

                        ),
                        'alignment' => [
                                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                                    ],
                    )
                );
                $sheet->getStyle('B6:P7')->applyFromArray([
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  10,
                        'bold'      =>  true
                    ),
                ]);
                $sheet->getStyle('B8:P8')->applyFromArray([
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  15,
                        'bold'      =>  true
                    ),
                ]);
                $sheet->getStyle('B9:P9')->applyFromArray([
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  13,
                        'bold'      =>  true
                    ),
                ]);
                $sheet->getStyle('B8:P9')->applyFromArray([
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                
                
            },
        ];
    }
}