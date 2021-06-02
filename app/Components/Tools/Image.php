<?php

namespace App\Components\Tools;

class Image
{

    public static function getImageExtension($uploadInfo)
    {
        dump($uploadInfo);
        $ext = pathinfo($uploadInfo['name'], PATHINFO_EXTENSION);

        if (!empty($ext)) return strtolower($ext);

        //默认去jpg
        return 'jpg';
        
    }

    public static function generateImageKey($ext)
    {
        return '/data/storage/images/' . date('Y/m/d/') . time(true) . '.' . $ext;
    }


}