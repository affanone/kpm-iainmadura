<?php

namespace App\Models;

class TahunAkademik extends Uuid
{
    public function kpm()
    {
        return $this->hasMany(Kpm::class);
    }
}
