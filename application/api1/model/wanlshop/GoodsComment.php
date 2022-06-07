<?php

namespace app\api1\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class GoodsComment extends Model
{

    use SoftDelete;

    // 表名
    protected $name = 'wanlshop_goods_comment';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
	

	// 追加属性

	protected $append = [

	    'state_text'

	];

	

	public function getStateList()

	{

	    return [0 => __('好评'), 1 => __('中评'), 2 => __('差评')];

	}

	

	public function getStateTextAttr($value, $data)

	{

		

	    $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');

	    $list = $this->getStateList();

	    return isset($list[$value]) ? $list[$value] : '';

	}

	

	public function getImagesAttr($value)

	{	

		return $value ? explode(',', $value) : [];

	}

	

	protected function setImagesAttr($value)

	{

	    return is_array($value) ? implode(',', $value) : $value;

	}


    public function user()
    {
        return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function goods()
    {
        return $this->belongsTo('app\api1\model\wanlshop\Goods', 'goods_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

	

	public function orderGoods()

	{

	    return $this->belongsTo('app\api1\model\wanlshop\OrderGoods', 'order_goods_id', 'id', [], 'LEFT')->setEagerlyType(0);

	}
}
