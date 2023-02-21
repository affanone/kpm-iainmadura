<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;

class Log
{
    // $name (view|insert|update|delete)
    public static function set($description, $name = "view", Model $model = null)
    {
        $conf = [
            "ip" => $_SERVER["REMOTE_ADDR"],
            "method" => $_SERVER["REQUEST_METHOD"],
        ];
        if ($model) {
            $modelNamespace = get_class($model);
            $modelId = $model->id;
            $conf['data'] = [
                'model' => $modelNamespace,
                'id' => $modelId,
            ];
        }
        activity()
            ->causedBy(Auth::user())
            ->withProperties($conf)
            ->tap(function (Activity $activity) use ($name) {
                $activity->log_name = $name;
            })
            ->log($description);
    }
}
