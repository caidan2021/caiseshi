<?php


namespace App\Modules\Services\Menu;


class MenuService
{

    public static function all()
    {
        $menu = config('admin_menu');
        return $menu;

    }

}