<?php 
/**
 * Created by root
 * Date: 2021-06-04 13:36:57
 */

namespace App\Modules\Repos;
use App\Components\Repository\BaseRepository;
use App\Modules\Models\ProductSkus;
use App\Modules\Models\ThirdPartyProductSkus;

/**
 * Class ThirdPartyProductSkus
 * @author  root
 * @package  App\Modules\Repos
 *
 */
class ThirdPartyProductSkusRepository extends BaseRepository
{

    public function getByProductId($productId, $module)
    {
        return $this->model()->where('product_id', $productId)->where('module_type', $module)->get();
    }


    public function getBySkuGroup($productId, $module)
    {
        return $this->getByProductId($productId, $module)->groupBy('self_sku_id');
    }

    public function getDataForModule($skuId, $productId, $module)
    {
        $data = [];


        $groups = $this->getBySkuGroup($productId, ThirdPartyProductSkus::getModuleBySkuModule($module));
        foreach ($groups as $group) {

            /** @var ThirdPartyProductSkus $thirdPartySku */
            foreach ($group as $thirdPartySku) {
                $item = [
                    'id' => $thirdPartySku->id,
                    'skuId' => $thirdPartySku->self_sku_id,
                ];
                switch ($module) {
                    case ProductSkus::MODULE_OF_TITLE:
                        $item['title'] = $thirdPartySku->title;
                        $redirectTo = 'titleRedirectTo';

                        break;

                    case ProductSkus::MODULE_OF_FIVE_POINT:
                        $item['detail'] = $thirdPartySku->five_point;
                        $redirectTo = 'fivePointRedirectTo';

                        break;
                    case ProductSkus::MODULE_OF_MAIN_PICTURE:
                        $item['detail'] = $thirdPartySku->images;
                        $redirectTo = 'imagesRedirectTo';
                        break;

                    case ProductSkus::MODULE_OF_SEARCH_TERM:
                        break;

                    case ProductSkus::MODULE_OF_DESCRIPTION:
                        break;


                }

                $item['redirectTo'] = $thirdPartySku->getExtendItem($redirectTo);
                $data[$thirdPartySku->self_sku_id][] = $item;

            }
        }

        if (($selfSkuData = array_get($data, $skuId))) {
            unset($data[$skuId]);
            $data[-1] = $selfSkuData;
        }
        ksort($data);

        $data = array_values($data);

        $sortData = [];
        foreach ($data as $arr) {
            foreach ($arr as $perItem) {
                $sortData[] = $perItem;

            }
        }

        return $sortData;

    }

}

