<?php
namespace app\admin\model\wanlshop;

use think\Model;

class OrderAddress extends Model
{
    // 表名
    protected $name = 'wanlshop_order_address';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

}
