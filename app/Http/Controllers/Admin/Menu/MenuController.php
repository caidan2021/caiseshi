<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function all()
    {
        //获取全部的路由配置
        $menu = config('admin_menu');
        //按照当前用户的权限,返回特定的路由组

        //返回数据

        return $this->ok($menu);
    }
}
