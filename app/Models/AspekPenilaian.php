<?php

namespace App\Models;

class AspekPenilaian extends Uuid
{
    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
}
