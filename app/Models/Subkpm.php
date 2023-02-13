<?php

namespace App\Models;

class Subkpm extends Uuid
{
    function getConfigUploadAttribute($value)
    {
        return json_decode($value);
    }
}
