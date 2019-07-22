<?php

namespace App\Imports;

use App\Kpi;
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
        // dd($row);
        return new Kpi([
            'kode'    =>$row[0],
            'nama'    =>$row[1], 
            'unit_id' =>$row[2], 
            'tahun'   =>$row[3],
            'kwartal' =>$row[4],
        ]);
    }
}
