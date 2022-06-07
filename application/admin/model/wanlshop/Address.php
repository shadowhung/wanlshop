<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Address extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_address';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'default_text',
        'status_text'
    ];
    

    
    public function getDefaultList()
    {
        return ['1' => __('Default 1'), '0' => __('Default 0')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getDefaultTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['default']) ? $data['default'] : '');
        $list = $this->getDefaultList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
