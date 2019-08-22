<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensitivitaskriteria extends Model
{
    protected $table = 'sensitivitaskriteria';
    public function risikoasetdetail(){
        return $this->hasMany('App\Risikoasetdetail','sensitivitaskriteria_id');
    }
}
