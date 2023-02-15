<?php

namespace App\Models;

class Kpm extends Uuid
{
    function getConfigAttribute($value)
    {
        return json_decode($value);
    }

    public function subkpm()
    {
        return $this->hasMany(Subkpm::class);
    }
}
