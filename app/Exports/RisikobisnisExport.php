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
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


// class RisikobisnisExport implements FromCollection
class RisikobisnisExport implements FromView,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Risikobisnis::all();
    // }
    use Exportable;
    public function forPeriod($periode){
        $this->periode = $periode;
        return $this;
    }
    public function forUnit($unit){
        $this->unit = $unit;
        return $this;
    }
    public function view(): View
    {
           
            $unit = unitkerja::where('objectabbr',$this->unit)->first();

            $expperiod = explode("-",$this->periode);

            $risikobisnis = Risikobisnis::byPeriod($expperiod[0])
            ->byYear($expperiod[1])
            ->byUnit($this->unit)
            ->first();
            // dd($risikobisnis);
            $riskdetail = Risikobisnisdetail:: select('kpi.nama','kpi_id') 
            ->where('risikobisnis_id',$risikobisnis->id) ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id') 
            // ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id') 
            ->groupBy('kpi.nama','kpi_id') 
            ->orderBy('kpi_id') ->get();
            
            
            $riskdetail->map(function ($item, $key) {
            $g = Kpi::find($item->kpi_id);
            
            $item->risikobisnisdetail = $g->risikobisnisdetail;
            $item->risikobisnisdetail->map(function($items,$keyes){
            $h =Klasifikasi::find($items->klasifikasi_id);
            $i =Peluang::find($items->peluang_id);
            $where =array('dampak_id'=>$items->dampak_id,'kategori_id'=>$items->kategori_id);
            $j =Kriteria::where($where)->get();
            $k =Dampak::find($items->dampak_id);
            $where2 =array('dampak_id'=>$items->dampak_id,'peluang_id'=>$items->peluang_id);
            $l =Matrikrisiko::where($where2)->get();
            $where3 =array('risikobisnisdetail_id'=>$items->id);
            $m =Sumberrisiko::where($where3)->get();
            $items->klas     = $h;
            $items->peluang  = $i;
            $items->kriteria = $j;
            $items->dampak   = $k;
            $items->matrik   = $l;
            $items->sumber   = $m;
            });
            
            return $item;
            });
            
        return view('exports.risikobisnis', [
           'unit'=>$unit,'periode'=>$this->periode,'riskdetail'=>$riskdetail
        ]);
    }
    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $styleArray = [
                    'borders' => [
                        'allborders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '#000000'],
                        ],
                    ],
                ];
               
                $lastrow= $event->sheet->getDelegate()->getHighestRow();
                $cellRange = 'A1:R'.$lastrow; // All headers

                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
       
    }
}




















































































































































































































































































































































