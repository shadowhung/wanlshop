<?php
namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class OrderGoods extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_order_goods';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'status_text',

		'refund_status_text'
    ];
    
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
	

	public function getRefundStatusList()

	{

	    return [0 => '', 1 => __('払い戻し'), 2 => __('返品待ち'), 3 => __('払い戻しが完了しました'), 4 => __('払い戻しは終了しました'), 5 => __('払い戻しは拒否されました')];

	}

	
	public function getRefundStatusTextAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['refund_status']) ? $data['refund_status'] : '');

	    $list = $this->getRefundStatusList();

	    return isset($list[$value]) ? $list[$value] : '';

	}


}
