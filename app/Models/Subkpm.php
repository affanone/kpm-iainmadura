<?php

namespace App\Models;

class Subkpm extends Uuid
{
    public function getConfigAttribute($value)
    {
        return json_decode($value);
    }

    public function kpm()
    {
        return $this->belongsTo(Kpm::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
