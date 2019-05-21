<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sumberrisiko extends Model
{
    protected $table = 'sumberrisiko';
    public function risikobisnisdetail(){
        return $this->belongsTo('App\Risikobisnisdetail', 'risikobisnisdetail_id');
    }
    
}
