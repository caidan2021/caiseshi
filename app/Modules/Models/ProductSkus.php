<?php

namespace App\Modules\Models;

use App\Components\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductSkus
 * @package App\Modules\Models
 * @property int $id 主键
 */
class ProductSkus extends BaseModel
{
//    use SoftDeletes;
    protected $table = 'product_skus';

    protected $cats = [
        'extends' => 'json',
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

    public function setExtendItem($key, $value)
    {
        $this->extends = json_encode(array_replace(json_decode($this->extends, true) ?? [], [
            $key => $value,
        ]));
        return $this;
        
    }

    public function getExtendItem($key)
    {
        return array_get(json_decode($this->extends, true) ?? [], $key, null);

    }
}
