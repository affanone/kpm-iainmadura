<?php

namespace App\Models;

class Nilai extends Uuid
{
    public function getNilaiAttribute($value)
    {
        $nilai = $value;

        // Memisahkan nilai desimal
        $nilai_array = explode('.', $nilai);
        $desimal = isset($nilai_array[1]) ? $nilai_array[1] : null;

        // Jika desimal tidak bernilai 0, biarkan koma
        if ($desimal !== null && $desimal != 0) {
            return $nilai;
        } else {
            // Bulatkan nilai
            return round($nilai);
        }
    }
}
