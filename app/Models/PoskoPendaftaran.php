<?php

namespace App\Models;

class PoskoPendaftaran extends Uuid
{
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
