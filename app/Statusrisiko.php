<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statusrisiko extends Model
{
    protected $table = 'statusrisiko';
    protected $fillable = ['nama'];
    public function risikobisnis(){
        return $this->hasMany('App\Risikobisnis','statusrisiko_id');
    }
}
