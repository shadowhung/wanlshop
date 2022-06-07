<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Shop extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_shop';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [

		'isself', //追加是否为自营店
        'state_text',
        'status_text'
    ];
    
	

	public function getIsselfAttr($value, $data)

	{

	    return $data['isself'];

	}

	

	
    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getStateList()
    {
        return ['0' => __('State 0'), '1' => __('State 1'), '2' => __('State 2')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
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
	
	public function auth1()

	{

	    return $this->belongsTo('app\admin\model\wanlshop\Auth', 'user_id', 'user_id', [], 'LEFT')->setEagerlyType(0);

	}

}
