<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Attribute extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_category_attribute';
    
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
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function category()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Category', 'category_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
