<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DokumenPendaftaran extends Uuid
{
    protected $hidden = ["pendaftaran_id", "created_at", "updated_at", "path"];

    protected $appends = ["path", "date_create", "date_update"];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value
                ? url("attachment/" . str_replace(".", "/", $value))
                : null
        );
    }

    public function getPathAttribute()
    {
        return $this->url ? \Helper::url2path($this->url) : null;
    }

    public function getDateCreateAttribute()
    {
        return date_format($this->created_at, "Y-m-d H:i:s");
    }

    public function getDateUpdateAttribute()
    {
        return date_format($this->updated_at, "Y-m-d H:i:s");
    }

    public function getDescAttribute($value)
    {
        return json_decode($value);
    }
}
