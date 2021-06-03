<?php

namespace App\Modules\Services;

use App\Modules\Models\ProductSkus;
use App\Modules\Models\ThirdPartyProductSkus;
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
        if ($id) {
            $sku = app(ProductSkusRepository::class)->findById($id);
            if (!$sku) return false;
        } else {
            $product = app(ProductsRepository::class)->findById($productId);
            if (!$product) return false;
            $sku = new ProductSkus();
        }

        $sku->product_id = $productId;
        $sku->title = array_get($params, 'title', '');
//        $sku->title = array_get($params, 'unit_price', 0);
//        $sku->title = array_get($params, 'unit', 0);
//        $sku->title = array_get($params, 'stock', 0);
//        $sku->title = array_get($params, 'shippingType', 0);
//        $sku->title = array_get($params, 'title', '');
//        $sku->extends = array_get($params, 'extends', null);
//        dd($sku);

        return $sku->save();

    }

    public function saveByModules($id, $modules)
    {
        if (!($sku = ProductSkus::find($id))) return false;

        foreach ($modules as $module => $data) {

            $mine = array_get($data, 'mine', []);
            $thirdParty = array_get($data, 'thirdParty', []);

            switch ($module) {
                case ProductSkus::MODULE_OF_TITLE:
                    $sku->title = array_get($mine, 'title', '');
                    $sku->setExtendItem('titleRedirect', array_get($mine, 'redirectTo', ''));
                    foreach ($thirdParty as $item) {

                        //如果没有找到id，那么就新增
                        if (!($id = array_get($item, 'id', null))) {
                            $thirdPartyModel = new ThirdPartyProductSkus();
                        } else {
                            //如果id找不到对应的数据，那么新建
                            //如果能找到对应的数据，那么更新
                            $thirdPartyModel = ThirdPartyProductSkus::findOrNew($id);

                            //如果有删除标识，就删除当前id的数据

                        }


                    }
                    break;
                case ProductSkus::MODULE_OF_FIVE_POINT:
                    break;
                case ProductSkus::MODULE_OF_MAIN_PICTURE:
                    break;
                case ProductSkus::MODULE_OF_SEARCH_TERM:
                    break;
                case ProductSkus::MODULE_OF_DESCRIPTION:
                    return false;
            }
        }

        $sku->save();
        return true;

    }

    public function fmtModuleForResponse($id, $module)
    {
        if (!($sku = ProductSkus::find($id))) return false;
        switch($module) {

            case ProductSkus::MODULE_OF_TITLE:
                return [
                    'mine' => [
                        'title' => $sku->title,
                        'redirectTo' => $sku->getExtendItem('titleRedirect'),
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