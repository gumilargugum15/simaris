<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risikoprojectdetail extends Model
{
    protected $table = 'risikoprojectdetail';
    public function risikoproject(){
        return $this->belongsTo('App\Risikoproject', 'risikoproject_id');
    }
    public function peluangproject(){
        return $this->belongsTo('App\Peluangproject', 'peluang_id');
    }
    public function dampak(){
        return $this->belongsTo('App\Dampak', 'dampak_id');
    }
    public function sumberrisikoproject(){
        return $this->hasMany('App\Sumberrisikoproject','risikoprojectdetail_id');
    }
    public function project(){
        return $this->belongsTo('App\Project', 'project_id');
    }
    public function tahapproject(){
        return $this->belongsTo('App\Tahapproject', 'tahapproject_id');
    }
}
