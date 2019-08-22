<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peluang extends Model
{
    protected $table = 'peluang';
    public function risikobisnisdetail(){
        return $this->hasMany('App\Risikobisnisdetail','peluang_id');
    }
    public function risikoasetdetail(){
        return $this->hasMany('App\Risikoasetdetail','peluang_id');
    }
}
