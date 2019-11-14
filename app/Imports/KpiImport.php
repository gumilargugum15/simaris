<?php

namespace App\Imports;

use App\Kpi;
use App\Perioderisikobisnis;
use Maatwebsite\Excel\Concerns\ToModel;

class KpiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        //  dd($row);
        $periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $period = $periodeaktif->id;
        // dd($period);
        $row[5]=0;
        $row[6]=$period;
        return new Kpi([
            'kode'    =>$row[0],
            'nama'    =>$row[1], 
            'unit_id' =>$row[2], 
            'tahun'   =>$row[3],
            'kwartal' =>$row[4],
            'status'  =>$row[5],
            'perioderisikobisnis_id'=>$row[6],
        ]);
    }
}
