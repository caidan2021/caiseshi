<?php

namespace App\Modules\Services;

use App\Modules\Models\ProductSkus;
use App\Modules\Models\ThirdPartyProductSkus;
use App\Modules\Repos\ProductSkusRepository;
use App\Modules\Repos\ProductsRepository;
use App\Modules\Repos\ThirdPartyProductSkusRepository;

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

    /**
     * 按照模块保存sku和外部sku的数据
     * @param $skuId
     * @param $modules
     * @return bool
     */
    public function saveByModules($skuId, $modules)
    {
        if (!($sku = ProductSkus::find($skuId))) return false;

        $productId = $sku->product_id;

        try {

            \DB::beginTransaction();
            foreach ($modules as $module => $data) {

                $mine = array_get($data, 'mine', []);
                $thirdParty = array_get($data, 'thirdParty', []);

                switch ($module) {
                    case ProductSkus::MODULE_OF_TITLE:
                        $sku->title = array_get($mine, 'title', '');
                        $sku->setExtendItem('titleRedirectTo', array_get($mine, 'redirectTo', ''));

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
                            $thirdPartyModel->module_type = ThirdPartyProductSkus::MODULE_TYPE_OF_TITLE;
                            $thirdPartyModel->product_id = $productId;
                            $thirdPartyModel->self_sku_id = $skuId;
                            $thirdPartyModel->title = array_get($item, 'title', '');
                            $thirdPartyModel->setExtendItem('titleRedirectTo', array_get($item, 'redirectTo', ''));
                            $thirdPartyModel->save();
                        }
                        break;

                    case ProductSkus::MODULE_OF_FIVE_POINT:
                        $sku->five_point = array_get($mine, 'detail', []);
                        $sku->setExtendItem('fivePointRedirectTo', array_get($mine, 'redirectTo', ''));

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
                            $thirdPartyModel->module_type = ThirdPartyProductSkus::MODULE_TYPE_OF_FIVE_POINT;
                            $thirdPartyModel->product_id = $productId;
                            $thirdPartyModel->self_sku_id = $skuId;
                            $thirdPartyModel->five_point = array_get($item, 'detail', []);
                            $thirdPartyModel->setExtendItem('fivePointRedirectTo', array_get($item, 'redirectTo', ''));
                            $thirdPartyModel->save();
                        }
                        break;

                    case ProductSkus::MODULE_OF_MAIN_PICTURE:

                        $sku->images = array_get($mine, 'detail', []);
                        $sku->setExtendItem('imagesRedirectTo', array_get($mine, 'redirectTo', ''));

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
                            $thirdPartyModel->module_type = ThirdPartyProductSkus::MODULE_TYPE_OF_MAIN_PICTURE;
                            $thirdPartyModel->product_id = $productId;
                            $thirdPartyModel->self_sku_id = $skuId;
                            $thirdPartyModel->images = array_get($item, 'detail', []);
                            $thirdPartyModel->setExtendItem('imagesRedirectTo', array_get($item, 'redirectTo', ''));
                            $thirdPartyModel->save();
                        }
                        break;

                    case ProductSkus::MODULE_OF_SEARCH_TERM:
                        $sku->search_term = array_get($mine, 'detail', []);
                        $sku->setExtendItem('searchTermRedirectTo', array_get($mine, 'redirectTo', ''));
                        break;

                    case ProductSkus::MODULE_OF_DESCRIPTION:
                        return false;
                }
            }

            $sku->save();
            \DB::commit();

            return true;


        } catch (\Exception $exception) {

            \DB::rollBack();
            return false;
        }

    }

    /**
     * 按照模块获取fmt的数据
     * @param $id
     * @param $module
     * @return array|array[]|bool
     */
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
                    'thirdParty' => app(ThirdPartyProductSkusRepository::class)->getDataForModule($id, $sku->product_id, $module),
                ];
                break;

            case ProductSkus::MODULE_OF_FIVE_POINT:
                return [
                    'mine' => [
                        'redirect' => 'www.baidu.com',
                        'detail' => $sku->five_point,
                    ],
                    'thirdParty' => app(ThirdPartyProductSkusRepository::class)->getDataForModule($id, $sku->product_id, $module),
                ];
                break;

            case ProductSkus::MODULE_OF_MAIN_PICTURE:
                return [
                    'mine' => [
                        'redirectTo' => $sku->getExtendItem('imagesRedirectTo'),
                        'detail' =>  $sku->images,
                    ],
                    'thirdParty' => app(ThirdPartyProductSkusRepository::class)->getDataForModule($id, $sku->product_id, $module),
                ];
                break;

            case ProductSkus::MODULE_OF_SEARCH_TERM:
                return [
                    'mine' => [
                        'redirectTo' => $sku->getExtendItem('searchTermRedirectTo'),
                        'detail' => $sku->search_term,
                    ]
                ];

                break;

            case ProductSkus::MODULE_OF_DESCRIPTION:
                return [
                    'mine' => [
                        'redirect' => 'www.baidu.com',
                        'detail' => [
                            'text' => '',
                            'picture' => [
                                'http://106.52.60.167:6001/resource/images/2021/06/03/1622726753.png',
                            ]
                        ],
                    ],
                    'thirdParty' => [],
                ];
                break;

        }
        
    }

}