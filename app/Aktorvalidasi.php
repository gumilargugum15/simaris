<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktorvalidasi extends Model
{
    protected $table = 'aktorvalidasi';
    public function validasibisnis(){
        return $this->hasMany('App\Validasibisnis','aktorvalidasi_id');
    }
}
