<?php

namespace app\api\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Chat extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_chat';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

	
	public function getMessageAttr($value)
	{
		$status = json_decode($value, true);
	    return $status;
	}
	
	public function getFormAttr($value)
	{
		$status = json_decode($value, true);
	    return $status;
	}
}
