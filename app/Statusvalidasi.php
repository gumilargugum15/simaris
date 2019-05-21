<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statusvalidasi extends Model
{
    protected $table = 'statusvalidasi';
    public function validasibisnis(){
        return $this->hasMany('App\Validasibisnis','statusvalidasi_id');
    }
}
