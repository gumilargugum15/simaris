<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perioderisikoaset extends Model
{
    protected $table = 'perioderisikoaset';
    protected $fillable =['nama','start_date','end_date','aktif','creator','creator'];

    public function scopePeriodeAktif($query)
    {
        return $query->where('aktif', 1);
    }
}
