<?php
namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Wholesale extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_wholesale';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'flag_text',
        'stock_text',
        'specs_text',
        'distribution_text',
        'activity_text',
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

    public function getStockList()
    {
        return ['porder' => __('Stock porder'), 'payment' => __('Stock payment')];
    }

    public function getSpecsList()
    {
        return ['single' => __('Specs single'), 'multi' => __('Specs multi')];
    }

    public function getDistributionList()
    {
        return ['true' => __('Distribution true'), 'false' => __('Distribution false')];
    }

    public function getActivityList()
    {
        return ['true' => __('Activity true'), 'false' => __('Activity false')];
    }

    public function getStatusList()
    {
        return ['normal' => __('販売中の商品'), 'hidden' => __('倉庫内の商品')];
    }


    public function getFlagTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['flag']) ? $data['flag'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getFlagList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getStockTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['stock']) ? $data['stock'] : '');
        $list = $this->getStockList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSpecsTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['specs']) ? $data['specs'] : '');
        $list = $this->getSpecsList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getDistributionTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['distribution']) ? $data['distribution'] : '');
        $list = $this->getDistributionList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getActivityTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['activity']) ? $data['activity'] : '');
        $list = $this->getActivityList();
        return isset($list[$value]) ? $list[$value] : '';
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
	
	
	public function shopsort()
	{
	    return $this->belongsTo('app\index\model\wanlshop\ShopSort', 'shop_category_id', 'id', [], 'LEFT')->setEagerlyType(0);
	}
	
	
}
