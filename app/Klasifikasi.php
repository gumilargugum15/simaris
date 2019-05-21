<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    protected $table = 'klasifikasi';
    protected $fillable = ['nama'];
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','klasifikasi_id');
    }
}
