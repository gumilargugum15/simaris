<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sumberrisiko extends Model
{
    protected $table = 'sumberrisiko';
    public function risikobisnisdetail(){
        return $this->belongsTo('App\Risikobisnisdetail', 'risikobisnisdetail_id');
    }

    // public function getFileAttribute($value) {
    //     return Storage::disk('local')->url($value);
    // }
    
}
