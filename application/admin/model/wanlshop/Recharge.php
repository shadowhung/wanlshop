<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Recharge extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_recharge';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'status_text'
    ];
    
	// 将Device字段转换字符串写入

	public function getDeviceAttr($value)

	{

		$status = json_decode($value, true);

	    return $status;

	}

	public function setDeviceAttr($value)

	{

		$status = json_encode($value);

	    return $status;

	}

	

	

	

	// 将图片数组转字符串输入

	public function getImagesAttr($value)

	{

		return explode(',', $value);

	}

	

	public function setImagesAttr($value)

	{

	    return is_array($value) ? implode(',', $value) : $value;

	}

	

	

	

	public function getStatusList()

	{

	    return ['created' => __('Status created'), 'successed' => __('Status successed'), 'rejected' => __('Status rejected')];

	}

	

	

	public function getStatusTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');

	    $list = $this->getStatusList();

	    return isset($list[$value]) ? $list[$value] : '';

	}
}
