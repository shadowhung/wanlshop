<?php

namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Auth extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_auth';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'state_text',
        'verify_text',
        'status_text'
    ];
    

    
    public function getStateList()
    {
        return ['0' => __('State 0'), '1' => __('State 1'), '2' => __('State 2')];
    }

    public function getVerifyList()
    {
        return ['0' => __('Verify 0'), '1' => __('Verify 1'), '2' => __('Verify 2'), '3' => __('Verify 3'), '4' => __('Verify 4')];
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


    public function getVerifyTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['verify']) ? $data['verify'] : '');
        $list = $this->getVerifyList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
