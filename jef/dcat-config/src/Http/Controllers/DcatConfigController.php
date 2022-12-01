<?php

namespace Dcat\Admin\Jef\DcatConfig\Http\Controllers;

use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Jef\DcatConfig\Http\Forms\AddMyConfig;
use Dcat\Admin\Jef\DcatConfig\Http\Forms\GroupTab;
use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Support\Facades\DB;
use Dcat\Admin\Widgets\Lazy;

class DcatConfigController extends AdminController
{
    protected $group;
    protected $title;
    protected $description;

    public function __construct()
    {
        $this->title = DcatConfigServiceProvider::trans('my-config.iframe.title');
        $this->description = DcatConfigServiceProvider::trans('my-config.iframe.description');
    }

    public function index(Content $content)
    {
        $btn = DcatConfigServiceProvider::trans('my-config.iframe.btn');
        return  $content
        ->title($this->title)
        ->description($this->description)
            ->prepend(
                Modal::make()
                ->xl()
                ->title($btn)
                ->body(AddMyConfig::make())
                ->button('<a class="btn-group filter-button-group dropdown" style="padding-bottom: 10px;" ><button class="btn btn-primary filter-btn-c4esDoqT btn-outline"><span class="d-none d-sm-inline">&nbsp;&nbsp;'.$btn.'</span><span class="filter-count"></span></button></a>')
            )
        ->body(function (Row $row) {
            $tab = new Tab();
            $config_group = $this->getConfigGroup();
            $count = count($config_group);
            for ($i = 0; $i < $count; $i++){
                $tab->add($config_group[$i]['value'],Lazy::make(GroupTab::make()->payload(['group'=>$config_group[$i]['key']])),!$i);
            }
            $row->column(12, $tab->withCard());
        });
    }

    public function getConfigGroup()
    {
        $value = DB::table('admin_jef_dcat_config')->where('name','configgroup')->value('content');
        return json_decode($value,true);
    }

}
