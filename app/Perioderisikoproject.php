<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perioderisikoproject extends Model
{
    protected $table = 'perioderisikoproject';
    public function scopePeriodeAktif($query)
    {
        return $query->where('aktif', 1);
    }
}
