<?php

namespace App\Models;


class AdminFakultas extends Uuid
{
    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
