<?php

namespace app\admin\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Notice extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_notice';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'type_text',
        'modules_text',
        'status_text'
    ];
    

    
    public function getTypeList()
    {
        return ['order' => __('Order'), 'notice' => __('Notice')];
    }

    public function getModulesList()
    {
        return ['deliver' => __('Modules deliver'), 'sign' => __('Modules sign'), 'agree' => __('Modules agree'), 'refuse' => __('Modules refuse'), 'live' => __('Modules live'), 'new' => __('Modules new')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getModulesTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['modules']) ? $data['modules'] : '');
        $list = $this->getModulesList();
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


    public function shop()
    {
        return $this->belongsTo('app\admin\model\wanlshop\Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
