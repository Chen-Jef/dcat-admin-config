<?php

namespace Dcat\Admin\Jef\DcatConfig\Http\Forms;

use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\Jef\DcatConfig\Models\MyConfig;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DelMyConfig extends Form implements LazyRenderable
{
    use LazyWidget;

    // 处理请求
    public function handle(array $input)
    {
        $groups = DB::table('admin_jef_dcat_config')->whereIn('name',$input['name'])->distinct()->pluck('group');
        $do = DB::table('admin_jef_dcat_config')->whereIn('name',$input['name'])->delete();

        if($do){
//            foreach ($groups as $item){
//                MyConfig::updateGroupConfigsByGroup($item);
//            }
            return $this->response()->success(DcatConfigServiceProvider::trans('my-config.response.success'))->refresh();
        }else{
            return $this->response()->error(DcatConfigServiceProvider::trans('my-config.response.error'))->refresh();
        }
    }

    public function form()
    {
        $all_config = DB::table('admin_jef_dcat_config')
            ->select(['name','title'])
            ->where('name','<>','configgroup')
            ->pluck('title','name');

        $this->multipleSelect('name',DcatConfigServiceProvider::trans('my-config.iframe.title'))
            ->options($all_config)
            ->required();
    }
}
