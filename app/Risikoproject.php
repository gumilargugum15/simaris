<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risikoproject extends Model
{
    protected $table = 'risikoproject';
    public function unitkerja()
    {
        return $this->belongsTo('App\Unitkerja', 'unit_id');
    }

    public function statusrisiko()
    {
        return $this->belongsTo('App\Statusrisiko', 'statusrisiko_id');
    }

    public function risikoprojectdetail()
    {
        return $this->hasMany('App\Risikoprojectdetail', 'risikoproject_id');
    }

    public function validasiproject()
    {
        return $this->hasMany('App\Validasiproject', 'risikoproject_id');
    }

    public function scopeByPeriod($query, $p)
    {
        return $query->where('periode', $p);
    }

    public function scopeByYear($query, $y)
    {
        return $query->where('tahun', $y);
    }

    public function scopeByUnit($query, $u)
    {
        return $query->where('unit_id', $u);
    }
    public function scopeByStatusrisk($query, $s)
    {
        return $query->where('statusrisiko_id','>', $s);
    }
}
