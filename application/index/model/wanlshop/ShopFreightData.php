<?php
namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class ShopFreightData extends Model
{

    use SoftDelete;

    // 表名
    protected $name = 'wanlshop_shop_freight_data';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
    
	public function getProvinceAttr($value, $data)
	{
	    return explode(',', $value);
	}

	public function getCityAttr($value, $data)
	{
	    return explode(',', $value);
	}
}
