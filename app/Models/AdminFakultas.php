<?php

namespace App\Models;

class AdminFakultas extends Uuid
{
    public function getFakultasAttribute($value)
    {
        $ex = explode("|", $value);
        $n = new \stdClass();
        $n->id = $ex[0];
        $n->nama = $ex[1];

        return $n;
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
