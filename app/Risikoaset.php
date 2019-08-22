<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risikoaset extends Model
{
    protected $table = 'risikoaset';
    protected $fillable = ['periode', 'tahun', 'unit_id', 'statusrisiko_id', 'creator', 'modifier'];
    public function unitkerja()
    {
        return $this->belongsTo('App\Unitkerja', 'unit_id');
    }

    public function statusrisiko()
    {
        return $this->belongsTo('App\Statusrisiko', 'statusrisiko_id');
    }

    public function risikoasetdetail()
    {
        return $this->hasMany('App\Risikoasetdetail', 'risikoaset_id');
    }

    public function validasiaset()
    {
        return $this->hasMany('App\Validasiaset', 'risikoaset_id');
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
