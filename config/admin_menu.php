<?php

return [
    [
        'name'     => '商品管理',
        'sub_menu' => [
            [
                'name' => 'Listing',
                'route' => 'admin/listing/list',
                'sub_menu' => [
                    [
                        'name'  => '列表',
                        'route' => 'admin/listing/list',
                        'method' => 'get',
                    ],
                ],
            ],
        ]
    ],
    [
        'name'     => '资源管理',
        'sub_menu' => [
            [
                'name'  => '文案管理',
                'route' => 'admin/get_menu',
                'method' => 'get',
            ],
            [
                'name' => '图片管理',
                'route' => 'admin/get_menu',
                'method' => 'get',
            ],
        ]
    ],
];
