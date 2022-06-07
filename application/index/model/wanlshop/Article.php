<?php

namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Article extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_article';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'flag_text',
        'status_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getFlagList()
    {
        return ['hot' => __('Flag hot'), 'index' => __('Flag index'), 'recommend' => __('Flag recommend')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getFlagTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['flag']) ? $data['flag'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getFlagList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setFlagAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }

	public function category()
	{
	    return $this->belongsTo('app\index\model\wanlshop\Category', 'category_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
}
