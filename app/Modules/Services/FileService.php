<?php

namespace App\Modules\Services;

use App\Components\Tools\Image;
use Illuminate\Support\Facades\Storage;

class FileService
{

    public function multiUploadFiles($filesData)
    {

    }

    public function uploadImage($imageData)
    {
        dd(Storage::url('test.jpg'));
        return Storage::download('test.jpg');
        dd(Storage::download('test.jpg'));
        dd(Storage::put('test.jpg',$imageData));
        $fileName = array_get($imageData, 'name', null);
        $fileSize = array_get($imageData, 'size', null);
        if (!$fileName) {
            return false;
        }
    
        //限制图片大小
        $max = 10;
        if (!$fileSize || $fileSize > $max * 1024 * 1024) return false;

        $ext = Image::getImageExtension($imageData);
        $targetPath = Image::generateImageKey($ext);
        dd(Storage::put($targetPath));

        $uploaded = [
                'url' => $fileName,
        ];

        return $uploaded;
        
    }

}