<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    protected $table = 'unitkerja';
    public function risikobisnis(){
        return $this->hasMany('App\Risikobisnis','unit_id');
    }
    public function user(){
        return $this->belongsTo('App\User', 'unit_id');
    }
    
    
}
