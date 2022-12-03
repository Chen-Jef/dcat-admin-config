<?php

namespace Dcat\Admin\Jef\DcatConfig\Http\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\Jef\DcatConfig\Models\MyConfig;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class GroupTab extends Form implements LazyRenderable
{
    use LazyWidget;

    public function handle(array $input)
    {
        $data = [];
        foreach($input as $key => $value){
            $data[] = [
                'name' => $key,
                'content' => $value
            ];
        }
        $res = MyConfig::updateBatch($data);
        if($res !== false){
            return $this->response()->success(DcatConfigServiceProvider::trans('my-config.response.success'))->refresh();
        }else{
            return $this->response()->error(DcatConfigServiceProvider::trans('my-config.response.error'));
        }
    }

    public function form()
    {
        $group_configs = MyConfig::getGroupConfigs($this->payload['group']);
        $group_configs->each(function ($item){
                switch($item->type){
                    case 'json':
                        $content = $item->content ? json_decode($item->content, true) : [];
                        $this->table($item->name,$item->title,function (NestedForm $table) use($content){
                            if($content){
                                $list = array_keys($content[0]);
                                foreach ($list as $val){
                                    $table->text($val);
                                }
                            }else{
                                $table->text('key');
                                $table->text('value');
                            }
                        })->help($item->tip)->default($content)->saving(function ($paths) {
                            $paths = Helper::array($paths);
                            return json_encode($paths,JSON_UNESCAPED_UNICODE);
                        });
                        break;
                    case 'string':
                        $this->text($item->name,$item->title)->help($item->tip)->default($item->content);
                        break;
                    default:
                        $type = $item->type;
                        $this->$type($item->name,$item->title)->help($item->tip)->default($item->content);
                }
            });
    }

}


