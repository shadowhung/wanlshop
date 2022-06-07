<?php

namespace app\api\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class ShopFollow extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_shop_follow';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

	// 店铺
	public function shop()
	{
	    return $this->belongsTo('app\api\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
}
