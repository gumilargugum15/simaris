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

    public function __construct()
    {
        $this->periodeaktif = Perioderisikobisnis::periodeAktif()->first();
        $this->period = $this->periodeaktif->id;
        $this->status = 0;
        $this->deleted = 0;
    }
    
    public function model(array $row)
    {
        
        return new Kpi([
            'kode'    =>$row[0],
            'nama'    =>$row[1], 
            'unit_id' =>$row[2], 
            'tahun'   =>$row[3],
            'kwartal' =>$row[4],
            'status'  =>$this->status,
            'perioderisikobisnis_id'=>$this->period,
            'level'=>$this->deleted,
            'deleted'=>$this->deleted
        ]);
    }
}
