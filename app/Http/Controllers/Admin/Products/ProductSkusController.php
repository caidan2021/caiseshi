<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Modules\Services\ProductSkuService;
use App\Modules\Services\ProductsService;
use Illuminate\Http\Request;

class ProductSkusController extends Controller
{


    public function edit(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer',
            'modules' => 'string',
        ]);

        $data = app(ProductSkuService::class)->editByModules(
            $request->get('id'),
            $request->get('modules')
        );

        return $this->ok($data);
        
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer',
//            'productId' => 'required',
        ]);

        $rt = app(ProductSkuService::class)->save(
            $request->get('id'),
            $request->get('productId'),
            $request->except(['id', 'productId'])
        );

        if (!$rt) return $this->failed('保存失败');

        return $this->ok();
    }

    public function saveByModules(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $rt = app(ProductSkuService::class)->saveByModules(
            $request->get('id'),
            $request->except('id')
        );

        if (!$rt) return $this->failed('保存失败');
        return $this->ok();
    }

    public function getListForProduct(Request $request)
    {
        $this->validate($request, [
            'productId' => 'required|integer',
        ]);

        $skuList = app(ProductSkuService::class)->getByProductId($request->get('productId'));
        
    }

    public function getList(Request $request)
    {
        
    }

    public function do(Request $request)
    {
        
    }
}