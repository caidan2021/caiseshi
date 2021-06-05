<?php

namespace App\Modules\Services;

use App\Modules\Models\Products;
use App\Modules\Models\ProductSkus;
use App\Modules\Repos\ProductSkusRepository;

class ProductsService
{

    public function getList()
    {

        $data = [];

        $products = Products::all();
        foreach ($products as $product) {

            $skus = app(ProductSkusRepository::class)->getByProductId($product->id);

            /** @var ProductSkus $sku */
            $skuList = [];
            foreach ($skus as $sku) {
                $skuList[] = [
                    'id' => $sku->id,
                    'title' => $sku->title,
                    'redirectTo' => $sku->getExtendItem('titleRedirectTo'),
                    'status' => 1,
                    'statusText' => '上线中',
                    'price' => $sku->unit_price,
                    'unit' => $sku->unit,
                    'thumbnail' => $sku->getFirstMainImage(),

                ];

            }

            $data[] = [
                'id' => $product->id,
                'title' => $product->title,
                'skuList' => $skuList
            ];

        }

        return $data;

    }


    public function saveProduct($params)
    {
        $id = array_get($params, 'id');
        $title = array_get($params, 'title');

        $product = Products::findOrNew($id);
        $product->title = $title;
        $product->save();
        return true;
        
    }

}