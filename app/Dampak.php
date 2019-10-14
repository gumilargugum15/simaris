<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dampak extends Model
{
    protected $table = 'dampak';

    public function kategori(){
        return $this->belongsToMany('App\Kategori', 'kriteria', 'dampak_id', 'kategori_id')->using('App\Kriteria');
    }
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','dampak_id');
    }
    public function risikoasetdetail(){
        return $this->hasMany('App\Risikoasetdetail','dampak_id');
    }
    public function risikoprojectdetail(){
        return $this->hasMany('App\Risikoprojectdetail','dampak_id');
    }

}
