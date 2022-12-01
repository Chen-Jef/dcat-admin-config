<?php

namespace Dcat\Admin\Jef\DcatConfig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MyConfig extends Model
{
    protected $table = 'admin_jef_dcat_config';

    protected $fillable = ['name', 'group', 'title', 'tip', 'type', 'content'];

    public static array $formType = [
        'string' => '字符串',
        'number' => '数字',
        'mobile' => '手机号',
        'url' => '链接',
        'email' => 'Email', //
        'color'  => '颜色',
        'date'   => '日期',
        'time'   => '时间',
        'datetime' => '日期时间',
        'image'    => '单图',
        'multipleImage'   => '多图',
        'file'    => '单文件',
        'multipleFile'   => '多文件',
        'textarea' => '长文本', //
        'editor' => '富文本', //
        'json'     => 'JSON',
    ];

    //同时更新多个记录
    protected function updateBatch($multipleData = array())
    {
        $tableName = DB::getConfig('prefix').$this->table;
        if( $tableName && !empty($multipleData) ) {

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE ".$tableName." SET ";
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";

                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = '".$data[$referenceColumn]."' THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }

    }
}
