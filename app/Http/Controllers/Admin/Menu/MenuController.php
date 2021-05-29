<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Modules\Services\Menu\MenuService;

class MenuController extends Controller
{
    public function all()
    {
        return [];
        //获取全部的路由配置
        $menu = app(MenuService::class)->all();


        //返回数据
        return $this->ok($menu);
    }
}
