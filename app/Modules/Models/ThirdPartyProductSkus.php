<?php

namespace App\Modules\Models;

use App\Components\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdPartyProductSkus extends BaseModel
{
    //
//    use SoftDeletes;

    protected $table = 'third_party_product_skus';
}
