<?php

namespace App\Modules\Services;

use App\Components\Tools\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    public function multiUploadFiles($filesData)
    {

    }

    public function uploadImage(?UploadedFile $file)
    {
        if ($file->isFile() && $file->isValid()) {

            $ext = $file->getClientOriginalExtension();
            $targetPath = Image::generateImageStoragePath();
            $fileName = Image::generateImageKey($ext);

            $file->move($targetPath, $fileName);

            $uploaded = [
                'url' => env('RESOURCE_GET_URL') . $targetPath . $fileName,
            ];
        }

        return $uploaded ?? null;
        
    }

}