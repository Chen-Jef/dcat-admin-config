<?php

namespace Dcat\Admin\Jef\DcatConfig\Http\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\Jef\DcatConfig\Models\MyConfig;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;

class GroupAddTab extends Form implements LazyRenderable
{
    use LazyWidget;

    protected $config_group = [];

    public function __construct($data = [], $key = null)
    {
        $this->config_group = MyConfig::getConfigGroup();
        parent::__construct($data, $key);
    }

    public function handle(array $input)
    {
        $old_data = $add_group = $update_group_value = $update_group_key = $del_group = [];

        $ids = array_column($input['jef-config-group'], 'key');

        foreach ($this->config_group as $value){
            $old_data[$value['id']] = $value;
            if(!in_array($value['key'], $ids)){
                $del_group[] = $value['key'];
            }
        }

        foreach ($input['jef-config-group'] as $item){
            if(is_null($item['id'])){
                //新增
                $add_group[] = [
                    'key' => $item['key'],
                    'value' => $item['value'],
                ];
            }else{
                //更新
                if($old_data[$item['id']]['key'] == $item['key']){
                    if($old_data[$item['id']]['value'] != $item['value']){
                        $update_group_value[] = $item;
                    }
                }else{
                    $update_group_key[] = [
                        'old' => $old_data[$item['id']]['key'],
                        'new' => $item['key']
                    ];
                }
            }
        }

        try {
            DB::beginTransaction();

            if($add_group){
                DB::table('admin_jef_dcat_config_group')->insert($add_group);
            }

            if($update_group_value){
                MyConfig::updateBatch($update_group_value);
            }

            if($update_group_key){
                foreach ($update_group_key as $vo){
                    DB::table('admin_jef_dcat_config_group')->where('key',$vo['old'])->update(['key'=>$vo['new']]);
                    DB::table('admin_jef_dcat_config')->where('group',$vo['old'])->update(['group'=>$vo['new']]);
                }
            }

            if($del_group){
                DB::table('admin_jef_dcat_config_group')->whereIn('key',$del_group)->delete();
                DB::table('admin_jef_dcat_config')->whereIn('group',$del_group)->delete();
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->response()->error(DcatConfigServiceProvider::trans('my-config.response.error'));
        }
        return $this->response()->success(DcatConfigServiceProvider::trans('my-config.response.success'))->refresh();
    }

    public function form()
    {
        $this->table('jef-config-group','配置分组',function (NestedForm $table){
            $table->hidden('id');
            $table->text('key');
            $table->text('value');
        })->default($this->config_group)->saving(function ($paths) {
            return Helper::array($paths);
        });
    }

}


