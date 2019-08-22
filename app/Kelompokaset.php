<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelompokaset extends Model
{
    protected $table = 'kelompokaset';
    public function risikoasetdetail(){
        return $this->hasMany('App\Risikoasetdetail','kelompokaset_id');
    }
}
