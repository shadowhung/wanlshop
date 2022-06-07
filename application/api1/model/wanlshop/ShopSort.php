<?php

namespace app\api1\model\wanlshop;

use think\Model;


class ShopSort extends Model
{

    // 表名
    protected $name = 'wanlshop_shop_sort';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;


}