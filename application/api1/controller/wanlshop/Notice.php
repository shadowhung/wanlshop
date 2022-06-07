<?php
namespace app\api1\controller\wanlshop;

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
	 * 获取消息列表
	 *
	 * @ApiSummary  (WanlShop 消息接口获取消息列表)
	 * @ApiMethod   (GET)
	 * 2020年5月12日23:25:40
	 *
	 * @param string $type 消息类型
	 */
	public function getNoticeList($type)
	{
		$list = model('app\api1\model\wanlshop\Notice')
			->where(['user_id' => $this->auth->id, 'type' => $type])
			->where('createtime','> time',date('Y-m-d',time()-2592000))
			->order('createtime desc')
			->paginate()
			->each(function($order, $key){
				switch ($order['modules'])
				{
					// 订单模块
					case 'order':
						$order['url'] = '/pages/user/order/details?id='.$order['modules_id'];
					break;  
					// 退款模块
					case 'refund':
						$order['url'] = '/pages/user/refund/details?id='.$order['modules_id'];
					break;
					// 直播模块
					case 'live':
						$order['url'] = '/pages/wanlshop/no_network?id='.$order['modules_id'];
					break;
					// 商品模块
					case 'goods':
						$order['url'] = '/pages/product/goods?id='.$order['modules_id'];
					break;
					// 后续版本继续更新更多提示内容，和商家推送
				}
				return $order;
			});
		$list?($this->success('ok',$list)):($this->error(__('网络繁忙')));
	}
    
}
