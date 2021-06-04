<?php 
/**
 * Created by root
 * Date: 2021-06-04 13:34:27
 */

namespace App\Modules\Models;
use App\Components\Model\BaseModel;


/**
 * Class ProductSkus
 * @author  root
 * @package  App\Modules\Models
 *  
 * @property int id 
 * @property int product_id 商品id
 * @property string title title
 * @property int unit_price 价格
 * @property int unit 单位
 * @property int stock 库存
 * @property int shipping_type 发货方式
 * @property string images 图片
 * @property string five_point 五点
 * @property string search_term
 * @property string description 详情
 * @property array extends 扩展
 * @property int created_at 创建时间
 * @property int updated_at 更新时间
 * @property int deleted_at 删除时间
 *
 */
class ProductSkus extends BaseModel
{
    //    use SoftDeletes;
    protected $table = 'product_skus';

    protected $casts = [
        'extends' => 'array',
        'five_point' => 'array',
        'images' => 'array',
        'search_term' => 'array',
        'description' => 'array',
    ]; 
    //
    const MODULE_OF_TITLE = 'title';
    const MODULE_OF_FIVE_POINT = 'fivePoint';
    const MODULE_OF_SEARCH_TERM = 'searchTerm';
    const MODULE_OF_MAIN_PICTURE = 'mainPicture';
    const MODULE_OF_DESCRIPTION = 'description';


    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

}

