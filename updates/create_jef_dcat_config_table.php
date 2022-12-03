<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatJefDcatConfigTable extends Migration
{
    // 这里可以指定你的数据库连接
    public function getConnection()
    {
        return config('database.connection') ?: config('database.default');
    }

    public function up()
    {
        if (!Schema::hasTable('admin_jef_dcat_config')) {
            Schema::create('admin_jef_dcat_config', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('name',30)->unique();
                $table->string('group',30);
                $table->string('title',50);
                $table->string('tip',50)->nullable();
                $table->string('type',15);
                $table->longText('content');
            });
        }

        if (!Schema::hasTable('admin_jef_dcat_config_group')) {
            Schema::create('admin_jef_dcat_config_group', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('key',30)->unique();
                $table->string('value',30);
            });
        }

        $config = DB::table('admin_jef_dcat_config')->count();
        if(!$config){
            $config_data = [];
            $config_data[] = [
                'name' => 'name',
                'group' => 'basic',
                'title' => '站点名称',
                'tip' => '请填写站点名称',
                'type' => 'string',
                'content' => '',
            ];
            $config_data[] = [
                'name' => 'beian',
                'group' => 'basic',
                'title' => '备案号',
                'tip' => '闽ICP备15000000号-1',
                'type' => 'string',
                'content' => '',
            ];
            $config_data[] = [
                'name' => 'forbiddenip',
                'group' => 'basic',
                'title' => 'IP黑名单',
                'tip' => '一行一条记录',
                'type' => 'textarea',
                'content' => '1.1.1.1',
            ];

            DB::table('admin_jef_dcat_config')->insert($config_data);

            $config_group = DB::table('admin_jef_dcat_config_group')->count();
            if(!$config_group){
                $config_group_data = [];
                $config_group_data[] = [
                    'key' => 'basic',
                    'value' => '基础配置',
                ];
                DB::table('admin_jef_dcat_config_group')->insert($config_group_data);
            }

        }
    }

    public function down()
    {
        Schema::dropIfExists('admin_jef_dcat_config');
        Schema::dropIfExists('admin_jef_dcat_config_group');
    }
}
