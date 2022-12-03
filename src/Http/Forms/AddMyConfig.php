<?php

namespace Dcat\Admin\Jef\DcatConfig\Http\Forms;

use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\Jef\DcatConfig\Models\MyConfig;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AddMyConfig extends Form implements LazyRenderable
{
    use LazyWidget;

    // 处理请求
    public function handle(array $input)
    {
        // 逻辑操作
        $new_config['name'] = $input['name'];
        $new_config['group'] = $input['group'];
        $new_config['title'] = $input['title'];
        $new_config['tip'] = $input['tip'];
        $new_config['type'] = $input['type'];
        $new_config['content'] = $input['content_'.$input['type']];

        if(DB::table('admin_jef_dcat_config')->where('name',$input['name'])->exists()){
            return $this->response()->error(DcatConfigServiceProvider::trans('my-config.response.config_exist'))->refresh();
        }

        $do = DB::table('admin_jef_dcat_config')->insert($new_config);

        if($do){
            return $this->response()->success(DcatConfigServiceProvider::trans('my-config.response.success'))->refresh();
        }else{
            return $this->response()->error(DcatConfigServiceProvider::trans('my-config.response.error'))->refresh();
        }
    }

    public function form()
    {
        $group_option = MyConfig::getConfigGroup();
        $group_option = array_column($group_option, 'value','key');

        $this->select('group',DcatConfigServiceProvider::trans('my-config.fields.group'))
            ->options($group_option)
            ->required();
        $this->text('name',DcatConfigServiceProvider::trans('my-config.fields.name'))->maxLength(30)->required();
        $this->text('title',DcatConfigServiceProvider::trans('my-config.fields.title'))->maxLength(50)->required();
        $this->text('tip',DcatConfigServiceProvider::trans('my-config.fields.tip'))->maxLength(30);
        $this->select('type',DcatConfigServiceProvider::trans('my-config.fields.type'))
            ->options(MyConfig::$formType)
            ->when('string',function(){
                $this->text('content_string',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('number',function(){
                $this->number('content_number',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('mobile',function(){
                $this->mobile('content_mobile',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('url',function(){
                $this->url('content_url',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('email',function(){
                $this->email('content_email',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('color',function(){
                $this->color('content_color',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('date',function(){
                $this->date('content_date',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('time',function(){
                $this->time('content_time',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('datetime',function(){
                $this->datetime('content_datetime',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('image',function(){
                $this->image('content_image',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('multipleImage',function(){
                $this->multipleImage('content_multipleImage',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('file',function(){
                $this->file('content_file',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('multipleFile',function(){
                $this->multipleFile('content_multipleFile',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('textarea',function(){
                $this->textarea('content_textarea',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('editor',function(){
                $this->editor('content_editor',DcatConfigServiceProvider::trans('my-config.fields.content'));
            })
            ->when('json',function(){
                $this->table('content_json',DcatConfigServiceProvider::trans('my-config.fields.content'),function (NestedForm $table){
                    $table->text('key');
                    $table->text('value');
                });
            })
            ->required();

    }
}
