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
        $unitkerja = Unitkerja::get();
        $periodeall = Perioderisikobisnis::get();
        $hsl='';
        if(isset($request->periode ) && isset($request->unitkerja)){
            // dd($request->periode.'-'.$request->unitkerja);
            $unit = unitkerja::where('objectabbr',$request->unitkerja)->first();

            $expperiod = explode("-",$request->periode);

            $risikobisnis = Risikobisnis::byPeriod($expperiod[0])
            ->byYear($expperiod[1])
            ->byUnit($request->unitkerja)
            ->first();
            $riskdetid = array();
            $detailrisk = Risikobisnisdetail::where('risikobisnis_id',$risikobisnis->id)->orderBy('kpi_id')->get();
            foreach($detailrisk as $key => $value){
                array_push($riskdetid,$value->id);
            }
            // dd($riskdetid);
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
            // dd($riskdetail);
            // dd($riskdetail[0]->risikobisnisdetail[0]->kriteria[0]->nama);
            // dd(count($riskdetail[0]->risikobisnisdetail));
            $hsl.='<table id="lapriskbisnis" class="table table-bordered table-striped">';
            $hsl.='<tr>';
            $hsl.='<th width="30%">Unit kerja : '.$unit->nama.'</th>';
            $hsl.='<th align="center" rowspan="2" valign="center"><b>Risiko Unit Kerja</b></th>';
            // $hsl.='<td width="50%">Tujuan pokok & fungsi :</td>';
            $hsl.='</tr>';
            $hsl.='<tr>';
            $hsl.='<th>Periode : '.$request->periode.'</th>';
            // $hsl.='<td>(1.) Mengorganisasikan, mengkoordinasikan, merekomendasikan dan melaksanakan program dan kegiatan perencanaan strategis perusahaan; penyusunan/evaluasi study kelayakan proyek strategis (non rutin), evaluasi study kelayakan proyek non strategis (rutin), penyusunan usulan prioritas proyek untuk dimasukan ke dalam RKAP, mengevaluasi kelayakan proyrk investasi anak perush. dan perush. patungan; penyusunan RJPP baik induk maupun Konsolidasi, dan atau perusahaan patungan (PP) termasuk penyusunan formula tarif bagi KS Group, dlm rangka mengintegrasikan rencana jangka panjang korporasi (KS Group) dan meningkatkan sinergi bisnis pada fungsi pada fungsi operasioanal di PT KS dan Group</td>';
            $hsl.='</tr>';

            $hsl.='</table>';
            $hsl.='<table class="table table-bordered table-striped">';
            $hsl.='<tr class="lapriskbisnis">';
            $hsl.='<th width="30%" colspan="2">TUJUAN</th><th width="30%" colspan="6">DENFITIKASI RISIKO</th><th width="30%" colspan="5">PENILAIAN RISIKO</th><th width="30%" colspan="3">PENETAPAN RESPON RISIKO</th><th width="30%" colspan="2">TINDAK LANJUT</th>';
            $hsl.='</tr>';
            $hsl.='<tr class="lapriskbisnis">';
            $hsl.='<th>NO</th><th>KPI</th><th>KLASIFIKASI</th><th>NAMA RISIKO</th><th>SUMBER RISIKO</th><th>AKIBAT</th><th>INDIKATOR</th><th>NILAI AMBANG</th>';
            $hsl.='<th>PELUANG</th><th>LEVEL</th><th>DAMPAK</th><th>LEVEL</th><th>TINGKAT RISIKO</th>';
            $hsl.='<th>MITIGASI</th><th>BIAYA</th><th>TARGET</th>';
            $hsl.='<th>PIC</th><th>STATUS</th>';
            $hsl.='</tr>';
            $no =1;
            $nox = 1;
            foreach($riskdetail as $key=>$value ){
                
                $count = count($value->risikobisnisdetail);
                foreach($value->risikobisnisdetail as $index=>$jmlsumber){
                    $sumber = $jmlsumber->sumber;
                }
            
                $hsl.='<tr>';
                $hsl.='<td rowspan="'.$count.'">'.$no.'</td><td rowspan="'.$count.'">'.$value->nama.'</td>';
                foreach($value->risikobisnisdetail as $keys=>$values){
                    
                    if($keys==0){
                        
                        $hsl.='<td>'.$values->klas->nama.'</td><td>'.$values->risiko.'</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                        $hsl.='<li>'.$valuesumber->namasumber.'</li>';
                        }
                        $hsl.='</td><td>'.$values->akibat.'</td><td>'.$values->indikator.'</td><td>'.$values->nilaiambang.'</td><td>'.$values->peluang->kriteria.'</td><td>'.$values->peluang->level.'</td><td>'.$values->kriteria[0]->nama.'</td><td>'.$values->dampak->level.'</td><td>'.$values->matrik[0]->tingkat.'</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                        $hsl.='<li>'.$valuesumber->mitigasi.'</li>';
                        }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->biaya.'</li>';
                            }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->start_date.' s/d '.$valuesumber->end_date.'</li>';
                            }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->pic.'</li>';
                            }
                            $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->statussumber.'</li>';
                            }
                        $hsl.='</td>';
                    }else{
                        // $hsl.='<tr><td>'.$values->klas->nama.'</td><td>'.$values->risiko.' - '.count($values->sumber).'</td><td>'.$values->sumber[0]->namasumber.'</td><td>'.$values->akibat.'</td><td>'.$values->indikator.'</td><td>'.$values->nilaiambang.'</td><td>'.$values->peluang->kriteria.'</td><td>'.$values->peluang->level.'</td><td>>'.$values->kriteria[0]->nama.'</td><td>'.$values->dampak->level.'</td><td>'.$values->matrik[0]->tingkat.'</td></tr>';
                        $hsl.='<tr><td>'.$values->klas->nama.'</td><td>'.$values->risiko.'</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->namasumber.'</li>';
                        }
                        $hsl.='</td><td>'.$values->akibat.'</td><td>'.$values->indikator.'</td><td>'.$values->nilaiambang.'</td><td>'.$values->peluang->kriteria.'</td><td>'.$values->peluang->level.'</td><td>'.$values->kriteria[0]->nama.'</td><td>'.$values->dampak->level.'</td><td>'.$values->matrik[0]->tingkat.'</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->mitigasi.'</li>';
                        }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->biaya.'</li>';
                        }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->start_date.' s/d '.$valuesumber->end_date.'</li>';
                        }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->pic.'</li>';
                        }
                        $hsl.='</td><td>';
                        foreach($values->sumber as $keysumber=>$valuesumber){
                            $hsl.='<li>'.$valuesumber->statussumber.'</li>';
                        }
                        $hsl.='</td></tr>';
                    }
                }
                    
               
                $hsl.='</tr>';
               
            $no++;
            
            }
            $hsl.='</table>';

        }
        return view('laporan.laprisikobisnis', compact('risikobisnis','periodeall','unitkerja','hsl'));
    }
    public function export(Request $request) 
    {
        
        // ob_end_clean();
        // ob_start(); 
        $period = 'Kwartal I-2019';//$request->periode;
        $unit   = '36000';//$request->unitkerja;

        // return Excel::download(new RisikobisnisExport, 'risikobisnis.xlsx');
        return (new RisikobisnisExport)
            ->forPeriod($period)
            ->forUnit($unit)
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
