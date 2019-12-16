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
        ->select('risikobisnisdetail.*', 'kpi.nama as namakpi', 'kpi.level as levelkpi', 'klasifikasi.nama as namaklas', 'peluang.kriteria as peluang', 'peluang.level as levelpeluang', 'kriteria.nama as dampak', 'kriteria.level as leveldampak', 'matrikrisiko.tingkat')
        ->join('kpi', 'kpi.id', '=', 'risikobisnisdetail.kpi_id')
        ->join('klasifikasi', 'klasifikasi.id', '=', 'risikobisnisdetail.klasifikasi_id')
        ->join('peluang', 'peluang.id', '=', 'risikobisnisdetail.peluang_id')
        ->join("kriteria",function($join){
            $join->on("kriteria.dampak_id","=","risikobisnisdetail.dampak_id")
                ->on("kriteria.kategori_id","=","risikobisnisdetail.kategori_id");
            })
        ->join("matrikrisiko",function($join){
            $join->on("matrikrisiko.dampak_id","=","risikobisnisdetail.dampak_id")
                ->on("matrikrisiko.peluang_id","=","risikobisnisdetail.peluang_id");
            })
        ->orderBy('kpi.level','desc')->get();
        $detailrisk          = $detailrisk->map(function($item, $key){
            $sumber          = Sumberrisiko::where('risikobisnisdetail_id',$item->id)->get();
            $jmlsumber       = count($sumber);
            $item->sumber    = $sumber;
            $item->jmlsumber = $jmlsumber;
            return $item;
        });
        // dd($detailrisk);
        return view('exports.risikobisnis', ['unit'=>$unit,'periode'=>$periode,'detailrisk'=>$detailrisk]);
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