<?php

namespace App\Modules\Models;

use App\Components\Model\BaseModel;

/**
 * Class ProductSkus
 * @package App\Modules\Models
 * @property int $id 主键
 */
class ProductSkus extends BaseModel
{
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
}
