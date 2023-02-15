<?php

namespace App\Models;

class Subkpm extends Uuid
{
    function getConfigAttribute($value)
    {
        return json_decode($value);
    }

    public function kpm()
    {
        return $this->belongsTo(Kpm::class);
    }
}
