<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    public function risikoprojectdetail(){
        return $this->hasMany('App\Risikoprojectdetail','project_id');
    }
    public function risikoproject(){
        return $this->hasMany('App\Risikoproject','project_id');
    }
}
