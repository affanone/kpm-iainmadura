<?php

namespace App\Models;

class Kpm extends Uuid
{
    function getConfigAttribute($value)
    {
        return json_decode($value);
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function subkpm()
    {
        return $this->hasMany(Subkpm::class);
    }
}
