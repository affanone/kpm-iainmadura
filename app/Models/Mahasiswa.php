<?php

namespace App\Models;

class Mahasiswa extends Uuid
{
    protected $hidden = ["fakultas"];
    public function getProdiAttribute($value)
    {
        $ex = explode("|", $value);
        $n = new \stdClass();
        $n->id = $ex[0];
        $n->sort = $ex[2];
        $n->long = $ex[1];
        $f = new \stdClass();

        $fak = explode("|", $this->attributes["fakultas"]);
        $n->fakultas = new \stdClass();
        $n->fakultas->id = $fak[0];
        $n->fakultas->nama = $fak[1];
        return $n;
    }

    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class);
    }
}
