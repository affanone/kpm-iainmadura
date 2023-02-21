<?php

namespace App\Models;

class Posko extends Uuid
{
    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function dpl()
    {
        return $this->belongsTo(Dpl::class);
    }
}
