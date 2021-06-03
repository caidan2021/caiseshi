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
        return env('RESOURCE_STORAGE_PATH') . 'images/' . date('Y/m/d/');
    }


}