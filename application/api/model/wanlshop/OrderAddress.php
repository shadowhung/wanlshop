<?php
namespace app\api\model\wanlshop;

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
	
	// 店铺
	public function shop()
	{
	    return $this->belongsTo('app\api\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
}
