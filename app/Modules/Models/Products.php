<?php 
/**
 * Created by root
 * Date: 2021-06-04 13:32:40
 */

namespace App\Modules\Models;
use App\Components\Model\BaseModel;


/**
 * Class Products
 * @author  root
 * @package  App\Modules\Models
 *  
 * @property int id 
 * @property string title 
 * @property int created_at 创建时间
 * @property int updated_at 更新时间
 * @property int deleted_at 删除时间
 *
 */
class Products extends BaseModel
{
    protected $table = "products";

}

