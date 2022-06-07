<?php

namespace app\api1\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Order extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_wholeorder';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
	

	// 追加属性

	protected $append = [

		'createtime_text',

	    'paymenttime_text',

	    'delivertime_text',

		'taketime_text',

	    'dealtime_text'

	];

	

	protected function setOrderNoAttr($value)

	{

	    return substr(time(),-8).substr(substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).$value,-8);

	}

	
	protected function getStateAttr($value){

		return intval($value);

	}

	

	

	public function getCreatetimeTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['createtime']) ? $data['createtime'] : '');

	    return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;

	}

	

	public function getPaymenttimeTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['paymenttime']) ? $data['paymenttime'] : '');

	    return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;

	}

	

	

	public function getDelivertimeTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['delivertime']) ? $data['delivertime'] : '');

	    return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;

	}

	

	public function getTaketimeTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['taketime']) ? $data['taketime'] : '');

	    return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;

	}

	

	

	public function getDealtimeTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['dealtime']) ? $data['dealtime'] : '');

	    return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;

	}



	

	

	
    protected function setPaymenttimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setDelivertimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setDealtimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }
	
	

    public function user()
    {
        return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
	
	public function pay()
	{
	    return $this->belongsTo('app\api1\model\wanlshop\Pay', 'id', 'order_id', [], 'LEFT')->setEagerlyType(0);
	}
	

	// 店铺

	public function shop()

	{

	    return $this->belongsTo('app\api1\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);

	}

	

	// 快递列表

	public function kuaidi()

	{

	    return $this->belongsTo('app\api1\model\wanlshop\Kuaidi', 'express_name', 'code', [], 'LEFT')->setEagerlyType(0);

	}

	

	


	
	
	
	
}
