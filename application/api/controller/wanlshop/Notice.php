<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use think\Db;
/**
 * WanlShop 消息接口
 */
class Notice extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    
    public function _initialize()
    {
        parent::_initialize();
    }
	
	
	/**
	 * 獲取消息列表
	 *
	 * @ApiSummary  (WanlShop 消息接口獲取消息列表)
	 * @ApiMethod   (GET)
	 * 2020年5月12日23:25:40
	 *
	 * @param string $type 消息類型
	 */
	public function getNoticeList($type)
	{
		$list = model('app\api\model\wanlshop\Notice')
			->where(['user_id' => $this->auth->id, 'type' => $type])
			->where('createtime','> time',date('Y-m-d',time()-2592000))
			->order('createtime desc')
			->paginate()
			->each(function($order, $key){
				switch ($order['modules'])
				{
					// 訂單模塊
					case 'order':
						$order['url'] = '/pages/user/order/details?id='.$order['modules_id'];
					break;  
					// 退款模塊
					case 'refund':
						$order['url'] = '/pages/user/refund/details?id='.$order['modules_id'];
					break;
					// 直播模塊
					case 'live':
						$order['url'] = '/pages/wanlshop/no_network?id='.$order['modules_id'];
					break;
					// 商品模塊
					case 'goods':
						$order['url'] = '/pages/product/goods?id='.$order['modules_id'];
					break;
					// 後續版本繼續更新更多提示內容，和商家推送
				}
				return $order;
			});
		$list?($this->success('ok',$list)):($this->error(__('ビジーネットワーク')));
	}
    
}
