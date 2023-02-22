<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;

class Log
{
    // $name (view|insert|update|delete)
    // model1 = before
    // model2 = after
    public static function set($description, $name = "insert", Model $model1 = null, Model $model2 = null)
    {
        $conf = [
            "ip" => $_SERVER["REMOTE_ADDR"],
            "method" => $_SERVER["REQUEST_METHOD"],
        ];
        if ($model1) {
            if ($name == 'insert') {
                $modelNamespace = get_class($model1);
                $modelId = $model1->id;
                $conf['data'] = $model1;
            } else if ($name == 'delete') {
                $conf['data'] = $model1;
            } else if ($name == 'update') {
                $conf['data'] = [
                    'before' => $model1,
                    'after' => $model12 ?? null,
                ];
            } else {
                $conf['data'] = null;
            }
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
