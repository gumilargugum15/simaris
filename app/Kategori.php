<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    public function dampak(){
        return $this->belongsToMany('App\Dampak', 'kriteria', 'kategori_id', 'dampak_id')->using('App\Kriteria');
    }
}
