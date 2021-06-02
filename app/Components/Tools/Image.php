<?php

namespace App\Components\Tools;

class Image
{

    public static function generateImageKey($ext)
    {
        return time(true) . '.' . $ext;
    }

    public static function generateImageStoragePath()
    {
        return env('IMAGE_RESOURCE_STORAGE_PATH') . date('Y/m/d/');
    }


}