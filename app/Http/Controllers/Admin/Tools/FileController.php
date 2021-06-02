<?php

namespace App\Http\Controllers\Admin\tools;

use App\Http\Controllers\Controller;
use App\Modules\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function uploadImage(Request $request)
    {
        $file = $request->file('files');

        return $this->ok(app(FileService::class)->uploadImage($file));
        
    }

}