<?php

namespace App\Components\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    /**
     * 自定义时间戳格式
     * @var string
     */
    protected $dateFormat = 'U';


    /**
     * 返回人能看懂的时间格式
     * @param $field
     * @return false|string
     */
    public function formatDate($field)
    {
        dd($this->title);
        dd($$this->field);
        return date('Y-m-d H:i:s', $this->$field);
    }

}