<?php

namespace app\api\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class GoodsSpu extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_goods_spu';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
	
	// getItemAttr
	public function getItemAttr($value)
	{	
		$arr = $value ? explode(',', $value) : [];
		$value = [];
		foreach($arr as $vo){
		  $value[] = ['name' => $vo];
		}
		return $value;
	}
}
