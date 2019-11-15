<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $table = 'kpi';
    protected $fillable =['kode','nama','unit_id','tahun','creator','modifier','kwartal','status','perioderisikobisnis_id'];
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','kpi_id');
    }
    public function unitkerja()
    {
        return $this->belongsTo('App\Unitkerja', 'unit_id');
    }
    
    public function scopeTahunAktif($query,$t){
       // $tahunaktif=date("Y");
        return $query->where('tahun',$t);
    }
    public function scopeByUnit($query, $u)
    {
        return $query->where('unit_id', $u);
    }
    public function scopeByKwartal($query, $u)
    {
        return $query->where('kwartal', $u);
    }
    public function scopeByStatus($query, $u)
    {
        return $query->where('status', $u);
    }
    public function scopeById($query, $u)
    {
        return $query->where('perioderisikobisnis_id', $u);
    }
}
