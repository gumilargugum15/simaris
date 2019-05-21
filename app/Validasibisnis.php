<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validasibisnis extends Model
{
    protected $table = 'validasibisnis';
    public function risikobisnis(){
        return $this->belongsTo('App\Risikobisnis', 'risikobisnis_id');
    }
    public function aktorvalidasi(){
        return $this->belongsTo('App\Aktorvalidasi', 'aktorvalidasi_id');
    }
    public function statusvalidasi(){
        return $this->belongsTo('App\Statusvalidasi', 'statusvalidasi_id');
    }
}
