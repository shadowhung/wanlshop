<?php

namespace app\api\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Find extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_find';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'type_text',
		'createtime_date'
    ];
	
	public function getCreatetimeDateAttr($value, $data)
	{
	    $value = $value ? $value : (isset($data['createtime']) ? $data['createtime'] : '');
	    return is_numeric($value) ? date("d", $value) : $value;
	}
	
	
	// 将图片数组转字符串输入
	public function getImagesAttr($value)
	{
		return $value ? explode(',', $value) : [];
	}
    
    public function getTypeList()
    {
        return ['new' => __('Type new'), 'live' => __('Type live'), 'want' => __('Type want'), 'activity' => __('Type activity'), 'show' => __('Type show')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }

	// 店铺
	public function shop()
	{
	    return $this->belongsTo('app\api\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
	
	// 直播
	public function live()
	{
	    return $this->belongsTo('app\api\model\wanlshop\Live', 'live_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
	

    
}
