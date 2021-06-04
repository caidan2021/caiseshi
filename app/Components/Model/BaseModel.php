<?php

namespace App\Components\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        return date('Y-m-d H:i:s', $this->$field);
    }

    public function setExtendItem($key, $value)
    {
        if (Schema::hasColumn($this->table, 'extends')) {
            $this->extends = array_replace($this->extends ?? [], [$key => $value]);
            return $this;
        } else {
            return false;
        }
    }

    public function getExtendItem($key)
    {
        if (Schema::hasColumn($this->table, 'extends')) {
            return array_get($this->extends ?? [], $key, null);
        } else {
            return false;
        }

    }

}