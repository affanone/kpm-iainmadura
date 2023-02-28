<?php

namespace App\Models;

class Pendaftaran extends Uuid
{
    public function subkpm()
    {
        return $this->belongsTo(Subkpm::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
