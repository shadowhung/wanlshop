<?php

namespace app\api1\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class FindFollow extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_find_follow';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

	// 发现

	public function find()

	{

	    return $this->belongsTo('app\api1\model\wanlshop\Find', 'find_id', 'id', [], 'LEFT')->setEagerlyType(0);

	}
}
