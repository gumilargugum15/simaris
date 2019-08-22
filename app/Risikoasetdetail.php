<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risikoasetdetail extends Model
{
    protected $table = 'risikoasetdetail';
    public function risikobisnis(){
        return $this->belongsTo('App\Risikoaset', 'risikoaset_id');
    }
    public function peluang(){
        return $this->belongsTo('App\Peluang', 'peluang_id');
    }
    public function dampak(){
        return $this->belongsTo('App\Dampak', 'dampak_id');
    }
    public function kelompokaset(){
        return $this->belongsTo('App\Kelompokaset', 'kelompokaset_id');
    }
    
    public function sensitivitaskriteria(){
        return $this->belongsTo('App\Sensitivitaskriteria', 'sensitivitaskriteria_id');
    }
}
