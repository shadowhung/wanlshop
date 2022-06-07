<?php
namespace app\index\model\wanlshop;

use think\Model;

/**
 * 配置模型
 */
class ShopConfig extends Model
{

    // 表名,不含前缀
    protected $name = 'wanlshop_shop_config';
    // 自动写入时间戳字段

    protected $autoWriteTimestamp = 'int';

    

    // 定义时间戳字段名

    protected $createTime = 'createtime';

    protected $updateTime = 'updatetime';

	

	

	public function getTypeList()

	{

	    return [

			'freight' => __('店舗の構成'), 

			//'kuaidi' => __('快遞100雲列印配寘'),

			//'facesheet' => __('面單參數'),

			'mailing' => __('送信者情報'),

			'return' => __('返品情報')

		];

	}
}
