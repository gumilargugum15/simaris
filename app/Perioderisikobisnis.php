<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perioderisikobisnis extends Model
{
    protected $table = 'perioderisikobisnis';
    protected $fillable =['nama','start_date','end_date','aktif','creator','creator'];

    public function scopePeriodeAktif($query)
    {
        return $query->where('aktif', 1);
    }
}
