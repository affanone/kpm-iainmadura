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

    public function getFakultasAttribute($value)
    {

        $fak = explode("|", $this->attributes["fakultas"]);
        $n = new \stdClass();
        $n->id = $fak[0];
        $n->nama = $fak[1];
        return $n;
    }
}
