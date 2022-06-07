<?php
namespace app\index\model\wanlshop;

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
        return ['1' => '未払い', '2' => '未出荷', '3' => 'は商品を受け取りを待って', '4' => 'はを評論するのを待って', '6' => 'はすでにを完成して', '7' => 'はすでにをキャンセルして', '8' => 'は注文書に卸売りをして'];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }

	public function getStatesList()
	{
	    return ['0' => __('States 0'), '1' => __('States 1'), '2' => __('States 2')];
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
	
	protected function setOrderNoAttr($value)
	{
		// 高并发有几率重复，暂时不需要
	    return substr(time(),-8).substr(substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).$value,-8);
	}
	
    public function user()
    {
        return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
	
	public function pay()
	{
	    return $this->belongsTo('app\index\model\wanlshop\Pay', 'id', 'order_id', [], 'LEFT')->setEagerlyType(0);
	}
	
	public function ordergoods()
	{
	    return $this->hasMany('app\index\model\wanlshop\OrderGoods', 'order_id', 'id', [], 'LEFT');
	}

	

	public function coupon()

	{

		return $this->belongsTo('app\index\model\wanlshop\CouponReceive', 'coupon_id', 'id', [], 'LEFT')->setEagerlyType(0);

	}

}
