<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensitivitaskritikalitas extends Model
{
    protected $table = 'sensitivitaskritikalitas';
    public function risikoasetdetail(){
        return $this->hasMany('App\Risikoasetdetail','sensitivitaskritikalitas_id');
    }
}
