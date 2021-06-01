<?php

namespace App\Modules\Services;

use App\Modules\Models\Products;

class ProductsService
{

    public function getList()
    {

        return [
            [
                'id' => 1,
                'title' => 'first product',
                'skuList' => [
                    [
                        'id' => 123,
                        'title' => 'first sku',
                        'redirectTo' => 'www.baidu.com',
                        'status' => 1,
                        'statusText' => '上线中',
                        'price' => 39.99,
                        'unit' => '$',
                        'thumbnail' => 'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                    ],
                    [
                        'id' => 123,
                        'title' => 'first sku',
                        'redirectTo' => 'www.baidu.com',
                        'status' => 1,
                        'statusText' => '上线中',
                        'price' => 39.99,
                        'unit' => '$',
                        'thumbnail' => 'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                    ],
                ]
            ],

            [
                'id' => 1,
                'title' => 'first product',
                'skuList' => [
                    [
                        'id' => 123,
                        'title' => 'first sku',
                        'redirectTo' => 'www.baidu.com',
                        'status' => 1,
                        'statusText' => '上线中',
                        'price' => 39.99,
                        'unit' => '$',
                        'thumbnail' => 'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                    ],
                    [
                        'id' => 123,
                        'title' => 'first sku',
                        'redirectTo' => 'www.baidu.com',
                        'status' => 1,
                        'statusText' => '上线中',
                        'price' => 39.99,
                        'unit' => '$',
                        'thumbnail' => 'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                    ],
                ]
            ],
        ];
        
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