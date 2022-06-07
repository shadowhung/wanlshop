<?php
namespace app\api\model\wanlshop;

use think\Model;

class Admin extends Model
{
    // 表名
    protected $name = 'admin';
	
	// 只读字段
	protected $readonly = ['id','nickname','avatar'];
}
