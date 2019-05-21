<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $table = 'kpi';
    protected $fillable =['kode','nama','unit_id','tahun','creator','modifier'];
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','kpi_id');
    }
    
    public function scopeTahunAktif($query){
        $tahunaktif=date("Y");
        return $query->where('tahun',$tahunaktif);
    }
}
