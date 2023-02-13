<?php

namespace App\Models;

class Kpm extends Uuid
{
    function getConfigUploadAttribute($value)
    {
        return json_decode($value);
    }
}
