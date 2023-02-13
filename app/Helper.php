<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    public static function upload(
        $file,
        $destination,
        $detail = false,
        $filename = null
    ) {
        $url = null;
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $original_name = $file->getClientOriginalName();
            $name = $filename
                ? $filename
                : Str::uuid()->toString() . "." . $extension;
            $full_destination = storage_path("app/" . $destination);
            if ($file->move($full_destination, $name)) {
                $url = $destination . "/" . $name;
            }
        }
        if (!$detail) {
            return $url;
        } else {
            $obj = new \stdClass();
            if (!$url) {
                $obj->url = null;
                $obj->size = 0;
                $obj->extension = null;
                $obj->name = null;
                $obj->md5 = null;
            } else {
                $obj->url = $url;
                $obj->size = Storage::size($url);
                $obj->extension = $extension;
                $obj->name = $original_name;
                $obj->md5 = md5_file(storage_path("app/" . $url));
            }
            return $obj;
        }
    }

    public static function delete_file($source)
    {
        try {
            if (Storage::exists($source)) {
                Storage::delete($source);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function copy_file($source, $destination)
    {
        $path = null;
        try {
            if (Storage::exists($source)) {
                Storage::copy($source, $destination);
                $path = $destination;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $path;
    }

    public static function getStringFromTxtUpload($field)
    {
        try {
            if (!$_FILES[$field]) {
                return null;
            }

            return file_get_contents($_FILES[$field]["tmp_name"]);
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }
}
