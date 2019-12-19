<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelompokrisiko extends Model
{
    protected $table = 'kelompokrisiko';
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','jenisrisiko');
    }
    
}
