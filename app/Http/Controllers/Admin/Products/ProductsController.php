<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product;
use App\Modules\Services\ProductsService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function list(Request $request)
    {
        return $this->ok(app(ProductsService::class)->getList());
        
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'id' => 'nullable|integet',
            'title' => 'required|string',
        ]);

        app(ProductsService::class)->saveProduct($request->all());

        return $this->ok();
    }


}