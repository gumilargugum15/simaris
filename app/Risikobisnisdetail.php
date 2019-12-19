<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risikobisnisdetail extends Model
{
    protected $table = 'risikobisnisdetail';
    public function risikobisnis(){
        return $this->belongsTo('App\Risikobisnis', 'risikobisnis_id');
    }
    public function kpi(){
        return $this->belongsTo('App\Kpi', 'kpi_id');
    }
    public function klasifikasi(){
        return $this->belongsTo('App\Kpi', 'klasifikasi_id');
    }
    public function peluang(){
        return $this->belongsTo('App\Peluang', 'peluang_id');
    }
    public function dampak(){
        return $this->belongsTo('App\Dampak', 'dampak_id');
    }
    public function sumberrisiko(){
        return $this->hasMany('App\Sumberrisiko','risikobisnisdetail_id');
    }
    public function kelompokrisiko(){
        return $this->belongsTo('App\Kelompokrisiko', 'jenisrisiko');
    }
}
