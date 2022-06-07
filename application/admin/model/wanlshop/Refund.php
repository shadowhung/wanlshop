<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Refund extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_refund';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'expressType_text',
        'type_text',
        'reason_text',
        'state_text',
        'status_text'
    ];
    

    
    public function getExpresstypeList()
    {
        return ['0' => __('Expresstype 0'), '1' => __('Expresstype 1')];
    }

    public function getTypeList()
    {
        return ['0' => __('Type 0'), '1' => __('Type 1')];
    }

    public function getReasonList()
    {
        return ['0' => __('Reason 0'), '1' => __('Reason 1'), '2' => __('Reason 2'), '3' => __('Reason 3'), '4' => __('Reason 4'), '5' => __('Reason 5'), '6' => __('Reason 6')];
    }

    public function getStateList()
    {
        return ['0' => __('State 0'), '1' => __('State 1'), '2' => __('State 2'), '3' => __('State 3'), '4' => __('State 4'), '5' => __('State 5')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getExpresstypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['expressType']) ? $data['expressType'] : '');
        $list = $this->getExpresstypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getReasonTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['reason']) ? $data['reason'] : '');
        $list = $this->getReasonList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

	public function user()
	{
	    return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}

    public function order()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Order', 'order_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function pay()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Pay', 'order_pay_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function shop()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
	
	public function goods()
	{
	    return $this->belongsTo('app\index\model\wanlshop\OrderGoods', 'goods_ids', 'id', [], 'LEFT')->setEagerlyType(0);
	}
}
