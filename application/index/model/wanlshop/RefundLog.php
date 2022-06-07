<?php

namespace app\index\model\wanlshop;

use think\Model;

class RefundLog extends Model
{

    // 表名
    protected $name = 'wanlshop_refund_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
	
	// 追加属性
	protected $append = [
		'createtime_text',
	];
	
	public function getCreatetimeTextAttr($value, $data)
	{
	    $value = $value ? $value : (isset($data['createtime']) ? $data['createtime'] : '');
	    return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
	}

	public function user()
	{
	    return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}

}
