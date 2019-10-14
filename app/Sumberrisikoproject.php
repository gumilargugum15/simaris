<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sumberrisikoproject extends Model
{
    protected $table = 'sumberrisikoproject';
    public function risikoprojectdetail(){
        return $this->belongsTo('App\Risikoprojectdetail', 'risikoprojectdetail_id');
    }
}
