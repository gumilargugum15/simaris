<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $table = 'kpi';
    protected $fillable =['kode','nama','unit_id','tahun','creator','modifier','kwartal'];
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','kpi_id');
    }
    public function unitkerja()
    {
        return $this->belongsTo('App\Unitkerja', 'unit_id');
    }
    
    public function scopeTahunAktif($query){
        $tahunaktif=date("Y");
        return $query->where('tahun',$tahunaktif);
    }
    public function scopeByUnit($query, $u)
    {
        return $query->where('unit_id', $u);
    }
}
