<?php
namespace app\api\model\wanlshop;

use think\Model;

class Address extends Model
{
    // 表名
    protected $name = 'wanlshop_address';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
}
