<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Complaint extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_complaint';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'type_text',
        'reason_text',
        'state_text'
    ];
    
	// 将图片数组转字符串输入
	public function getImagesAttr($value)
	{
		return explode(',', $value);
	}
	
	public function setImagesAttr($value)
	{
	    return is_array($value) ? implode(',', $value) : $value;
	}
    
    public function getTypeList()
    {
        return ['0' => __('Type 0'), '1' => __('Type 1'), '2' => __('Type 2')];
    }

    public function getReasonList()
    {
        return ['0' => __('Reason 0'), '1' => __('Reason 1'), '2' => __('Reason 2'), '3' => __('Reason 3'), '4' => __('Reason 4'), '5' => __('Reason 5'), '6' => __('Reason 6'), '7' => __('Reason 7'), '8' => __('Reason 8'), '9' => __('Reason 9'), '10' => __('Reason 10'), '11' => __('Reason 11'), '12' => __('Reason 12'), '13' => __('Reason 13')];
    }

    public function getStateList()
    {
        return ['normal' => __('State normal'), 'hidden' => __('State hidden')];
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




    public function user()
    {
        return $this->belongsTo('app\admin\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
	
	public function cuser()
	{
	    return $this->belongsTo('app\admin\model\User', 'complaint_user_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}

    public function goods()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Goods', 'complaint_goods_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function shop()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Shop', 'complaint_shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
