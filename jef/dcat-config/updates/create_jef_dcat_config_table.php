<?php

use Dcat\Admin\Jef\DcatConfig\DcatConfigServiceProvider;
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
                $table->string('tip',50);
                $table->string('type',15);
                $table->longText('content');
            });

            $init_data = [];
            $init_data[] = [
                'name' => 'name',
                'group' => 'basic',
                'title' => DcatConfigServiceProvider::trans('my-config.default_database.basic_title'),
                'tip' => DcatConfigServiceProvider::trans('my-config.default_database.basic_tip'),
                'type' => 'string',
                'content' => '',
            ];
            $init_data[] = [
                'name' => 'beian',
                'group' => 'basic',
                'title' => DcatConfigServiceProvider::trans('my-config.default_database.beian_title'),
                'tip' => DcatConfigServiceProvider::trans('my-config.default_database.beian_tip'),
                'type' => 'string',
                'content' => '',
            ];
            $init_data[] = [
                'name' => 'forbiddenip',
                'group' => 'basic',
                'title' => DcatConfigServiceProvider::trans('my-config.default_database.forbiddenip_title'),
                'tip' => DcatConfigServiceProvider::trans('my-config.default_database.forbiddenip_tip'),
                'type' => 'textarea',
                'content' => '1.1.1.1',
            ];
            $init_data[] = [
                'name' => 'configgroup',
                'group' => 'dictionary',
                'title' => DcatConfigServiceProvider::trans('my-config.default_database.configgroup_title'),
                'tip' => DcatConfigServiceProvider::trans('my-config.default_database.configgroup_tip'),
                'type' => 'table',
                'content' => '[{"key":"basic","value":"'.DcatConfigServiceProvider::trans('my-config.default_database.configgroup_basic').'"},{"key":"dictionary","value":"'.DcatConfigServiceProvider::trans('my-config.default_database.configgroup_dictionary').'"}]',
            ];
            DB::table('admin_jef_dcat_config')->insert($init_data);
        }
    }

    public function down()
    {
        Schema::dropIfExists('admin_jef_dcat_config');
    }
}
