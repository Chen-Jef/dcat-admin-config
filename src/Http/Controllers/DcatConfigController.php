<?php

namespace Dcat\Admin\Jef\DcatConfig\Http\Controllers;

use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Jef\DcatConfig\Http\Forms\AddMyConfig;
use Dcat\Admin\Jef\DcatConfig\Http\Forms\DelMyConfig;
use Dcat\Admin\Jef\DcatConfig\Http\Forms\GroupTab;
use Dcat\Admin\Jef\DcatConfig\Http\Forms\GroupAddTab;
use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\Jef\DcatConfig\Models\MyConfig;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\Lazy;

class DcatConfigController extends AdminController
{
    protected $title;
    protected $description;
    protected $tips;

    public function __construct()
    {
        $this->title = DcatConfigServiceProvider::trans('my-config.iframe.title');
        $this->description = DcatConfigServiceProvider::trans('my-config.iframe.description');
        $this->tips = DcatConfigServiceProvider::trans('my-config.iframe.tips');
    }

    public function index(Content $content)
    {
        $btn_add = DcatConfigServiceProvider::trans('my-config.iframe.btn_add');
        $btn_del = DcatConfigServiceProvider::trans('my-config.iframe.btn_del');
        return  $content
        ->title($this->title)
        ->description($this->description)
            ->prepend(
                Modal::make()
                    ->xl()
                    ->title($btn_add)
                    ->body(AddMyConfig::make())
                    ->button('<button class="btn btn-primary btn-outline" style="margin: 10px 10px 10px 0"><span class="d-none d-sm-inline">&nbsp;&nbsp;' . $btn_add . '</span></button>').
                Modal::make()
                    ->xl()
                    ->title($btn_del)
                    ->body(DelMyConfig::make())
                    ->button('<button class="btn btn-primary btn-outline"><span class="d-none d-sm-inline">&nbsp;&nbsp;' . $btn_del . '</span></button>')
            )
            ->prepend('<span style="color: orangered"><i class="feather icon-alert-circle"></i>&nbsp;&nbsp;'.$this->tips.'</span>')
        ->body(function (Row $row) {
            $tab = new Tab();
            $config_group = MyConfig::getConfigGroup();
            $count = count($config_group);
            if($count){
                for ($i = 0; $i < $count; $i++){
                    $tab->add($config_group[$i]['value'],Lazy::make(GroupTab::make()->payload(['group'=>$config_group[$i]['key']])),!$i);
                }
            }
            $tab->add('配置分组',Lazy::make(GroupAddTab::make()->payload(['group'=>'jef-add-config-group'])),!$count);
            $row->column(12, $tab->withCard());
        });
    }

}
