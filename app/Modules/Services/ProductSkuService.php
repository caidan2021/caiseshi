<?php

namespace App\Modules\Services;

use App\Modules\Models\ProductSkus;
use App\Modules\Repos\ProductSkusRepository;
use App\Modules\Repos\ProductsRepository;

class ProductSkuService
{

    public function getByProductId($productId)
    {
        $skus = app(ProductSkusRepository::class)->getByProductId($productId);
        dd($skus);
        
    }


    public function editByModules($id, $modules)
    {
        $data = [];
        $modules = is_array($modules) ? $modules : [$modules];
        
        foreach ($modules as $module) {
            $data[$module] = $this->fmtModuleForResponse($id, $module);
        }

        return $data;
    }

    public function save($id, $productId, $params)
    {
        $product = app(ProductsRepository::class)->findById($productId);
        if (!$product) return false;

        $sku = app(ProductSkusRepository::class)->findOrNew($id);
        $sku->product_id = $productId;
        $sku->title = array_get($params, 'title', '');
        $sku->title = array_get($params, 'unit_price', 0);
        $sku->title = array_get($params, 'unit', 0);
        $sku->title = array_get($params, 'stock', 0);
        $sku->title = array_get($params, 'shippingType', 0);
        $sku->title = array_get($params, 'title', '');
        $sku->extends = array_get($params, 'extends', null);

        return $sku->save();

    }

    public function saveByModules($id, $modules, $param)
    {
        dd($id, $modules, $param);

    }

    public function fmtModuleForResponse($id, $module)
    {
        switch($module) {

            case ProductSkus::MODULE_OF_TITLE:
                return [
                    'mine' => [
                        'title' => 'new title',
                        'redirectTo' => 'www.baidu.com',
                    ],
                    'thirdParty' => [
                        [
                            'id' => 123,
                            'title' => 'new title',
                            'redirectTo' => 'www.baidu.com',
                        ],
                        [
                            'id' => 124,
                            'title' => 'new title',
                            'redirectTo' => 'www.baidu.com',
                        ],
                        [
                            'id' => 125,
                            'title' => 'new title',
                            'redirectTo' => 'www.baidu.com',
                        ],
                    ],
                ];
                break;

            case ProductSkus::MODULE_OF_FIVE_POINT:
                return [
                    'mine' => [
                        'redirect' => 'www.baidu.com',
                        'detail' => [
                            'first point',
                            'first point',
                            'first point',
                            'first point',
                            'first point',
                        ]
                    ],
                    'thirdParty' => [
                        [
                            'id' => 12345,
                            'redirect' => 'www.baidu.com',
                            'detail' => [
                                'first point',
                                'first point',
                                'first point',
                                'first point',
                                'first point',
                            ]
                        ],
                        [
                            'id' => 12345,
                            'redirect' => 'www.baidu.com',
                            'detail' => [
                                'first point',
                                'first point',
                                'first point',
                                'first point',
                                'first point',
                            ]
                        ],
                    ],
                ];
                break;

            case ProductSkus::MODULE_OF_SEARCH_TERM:
                return [
                    'mine' => [
                        'redirect' => 'www.baidu.com',
                        'detail' =>  [
                            'search term item 1',
                            'search term item 2',
                            'search term item 3',
                            'search term item 4',
                            'search term item 5',
                        ]
                    ],
                    'thirdParty' => []
                ];
                break;

            case ProductSkus::MODULE_OF_MAIN_PICTURE:
                return [
                    'mine' => [
                        'redirect' => 'www.baidu.com',
                        'detail' => [
                            'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                        ]
                    ],
                    'thirdParty' => [
                        [
                            'id' => 123456,
                            'redirect' => 'www.baidu.com',
                            'detail' => [
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            ]
                        ],
                        [
                            'id' => 123456,
                            'redirect' => 'www.baidu.com',
                            'detail' => [
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            ]
                        ],
                    ],
                ];
                break;

            case ProductSkus::MODULE_OF_DESCRIPTION:
                return [
                    'mine' => [
                        'redirect' => 'www.baidu.com',
                        'detail' => [
                            'text' => '',
                            'picture' => [
                                'http://img01.songzhaopian.cn/resource/2021/05/31/132f0b2c-82da-44a9-b3f7-b3279b407668-s70.jpg',
                            ]
                        ],
                    ],
                    'thirdParty' => [],
                ];
                break;

        }
        
    }

}