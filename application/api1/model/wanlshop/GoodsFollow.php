<?php

namespace app\api1\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class GoodsFollow extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_goods_follow';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
	

	// 商品

	public function goods()

	{

	    return $this->belongsTo('app\api1\model\wanlshop\Goods', 'goods_id', 'id', [], 'LEFT')->setEagerlyType(0);

	}
}
