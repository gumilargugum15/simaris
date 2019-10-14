<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tahapproject extends Model
{
    protected $table = 'tahapproject';
    public function risikoprojectdetail(){
        return $this->hasMany('App\Risikoprojectdetail','tahapproject_id');
    }
}
