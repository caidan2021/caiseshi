<?php 
/**
 * Created by root
 * Date: 2021-06-04 13:36:57
 */

namespace App\Modules\Models;
use App\Components\Model\BaseModel;


/**
 * Class ThirdPartyProductSkus
 * @author  root
 * @package  App\Modules\Models
 *  
 * @property int id
 * @property int module_type 记录的类型
 * @property int product_id 商品id
 * @property int self_sku_id 商品id
 * @property string title title
 * @property int unit_price 价格
 * @property int unit 单位
 * @property int stock 库存
 * @property int shipping_type 发货方式
 * @property string images 图片
 * @property string five_point 五点
 * @property string search_term
 * @property string description 详情
 * @property string extends 扩展
 * @property int created_at 创建时间
 * @property int updated_at 更新时间
 * @property int deleted_at 删除时间
 *
 */
class ThirdPartyProductSkus extends BaseModel
{
    protected $table = "third_party_product_skus";

    const MODULE_TYPE_OF_TITLE = 0;
    const MODULE_TYPE_OF_FIVE_POINT = 1;
    const MODULE_TYPE_OF_SEARCH_TERM = 2;
    const MODULE_TYPE_OF_MAIN_PICTURE = 3;
    const MODULE_TYPE_OF_DESCRIPTION = 4;

    protected $casts = [
        'extends' => 'array',
        'five_point' => 'array',
        'images' => 'array',
        'search_term' => 'array',
        'description' => 'array',
    ];

    public static function getModuleBySkuModule($skuModule)
    {
        $list = [
            ProductSkus::MODULE_OF_TITLE => self::MODULE_TYPE_OF_TITLE,
            ProductSkus::MODULE_OF_FIVE_POINT => self::MODULE_TYPE_OF_FIVE_POINT,
            ProductSkus::MODULE_OF_SEARCH_TERM => self::MODULE_TYPE_OF_SEARCH_TERM,
            ProductSkus::MODULE_OF_MAIN_PICTURE =>  self::MODULE_TYPE_OF_MAIN_PICTURE,
            ProductSkus::MODULE_OF_DESCRIPTION => self::MODULE_TYPE_OF_DESCRIPTION,
        ];

        return array_get($list, $skuModule);

    }

}

