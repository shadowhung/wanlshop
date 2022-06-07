<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Freight extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_shop_freight';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'delivery_text',
        'isdelivery_text',
        'valuation_text',
        'status_text'
    ];
    

    
    public function getDeliveryList()
    {
        return ['0' => __('Delivery 0'), '1' => __('Delivery 1'), '2' => __('Delivery 2'), '3' => __('Delivery 3'), '4' => __('Delivery 4'), '5' => __('Delivery 5'), '6' => __('Delivery 6'), '7' => __('Delivery 7'), '8' => __('Delivery 8'), '9' => __('Delivery 9'), '10' => __('Delivery 10'), '11' => __('Delivery 11'), '12' => __('Delivery 12'), '13' => __('Delivery 13'), '14' => __('Delivery 14'), '15' => __('Delivery 15'), '16' => __('Delivery 16'), '17' => __('Delivery 17'), '18' => __('Delivery 18')];
    }

    public function getIsdeliveryList()
    {
        return ['0' => __('Isdelivery 0'), '1' => __('Isdelivery 1')];
    }

    public function getValuationList()
    {
        return ['0' => __('Valuation 0'), '1' => __('Valuation 1'), '2' => __('Valuation 2')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getDeliveryTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['delivery']) ? $data['delivery'] : '');
        $list = $this->getDeliveryList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsdeliveryTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isdelivery']) ? $data['isdelivery'] : '');
        $list = $this->getIsdeliveryList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getValuationTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['valuation']) ? $data['valuation'] : '');
        $list = $this->getValuationList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


	public function shop()
	{
	    return $this->belongsTo('app\admin\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}

}
