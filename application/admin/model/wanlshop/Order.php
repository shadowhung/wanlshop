<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Order extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'state_text',
        'paymenttime_text',
        'delivertime_text',
        'dealtime_text',
        'status_text'
    ];
    

    
    public function getStateList()
    {
        return ['1' => __('State 1'), '2' => __('State 2'), '3' => __('State 3'), '4' => __('State 4'), '6' => __('State 6'), '7' => __('State 7')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
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


    public function getDealtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['dealtime']) ? $data['dealtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
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
        return $this->belongsTo('app\admin\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function shop()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
	
	public function pay()
	{
	    return $this->belongsTo('app\admin\model\wanlshop\Pay', 'id', 'order_id', [], 'LEFT')->setEagerlyType(0);
	}
	
	public function ordergoods()
	{
	    return $this->hasMany('app\admin\model\wanlshop\OrderGoods', 'order_id', 'id', [], 'LEFT');
	}
	
	public function coupon()
	{
	    return $this->belongsTo('app\admin\model\wanlshop\CouponReceive', 'coupon_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
	
}
