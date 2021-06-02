<?php

namespace App\Http\Controllers\Admin\tools;

use App\Http\Controllers\Controller;
use App\Modules\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function uploadImage(Request $request)
    {
        // $files = $_FILES['files'];
        $files = $request->file();

        return $this->ok(app(FileService::class)->uploadImage($files));
        
    }

}