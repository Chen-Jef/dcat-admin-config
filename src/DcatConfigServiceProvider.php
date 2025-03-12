<?php

namespace Dcat\Admin\Jef\DcatConfig;

use Dcat\Admin\Extend\ServiceProvider;

class DcatConfigServiceProvider extends ServiceProvider
{
    // 定义菜单
    protected $menu = [
        [
            'title' => '自定义配置',
            'uri'   => 'jef/dcat-config',
            'icon'  => '', // 图标可以留空
        ]
    ];
}
