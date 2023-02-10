<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;

class Log
{
    public static function set($description, $name = "default")
    {
        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                "ip" => $_SERVER["REMOTE_ADDR"],
                "method" => $_SERVER["REQUEST_METHOD"],
            ])
            ->tap(function (Activity $activity) use ($name) {
                $activity->log_name = $name;
            })
            ->log($description);
    }
}
