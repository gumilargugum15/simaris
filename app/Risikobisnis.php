<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Risikobisnis extends Pivot
{
    protected $table = 'risikobisnis';
    protected $fillable = ['periode', 'tahun', 'unit_id', 'statusrisiko_id', 'creator', 'modifier'];

    public function unitkerja()
    {
        return $this->belongsTo('App\Unitkerja', 'unit_id');
    }

    public function statusrisiko()
    {
        return $this->belongsTo('App\Statusrisiko', 'statusrisiko_id');
    }

    public function risikobisnisdetail()
    {
        return $this->hasMany('App\Risikobisnisdetail', 'risikobisnis_id');
    }

    public function validasibisnis()
    {
        return $this->hasMany('App\Validasibisnis', 'risikobisnis_id');
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
