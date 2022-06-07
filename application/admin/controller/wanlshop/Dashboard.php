<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Config;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
		$user = model('app\common\model\User');
		$order = model('app\admin\model\wanlshop\Order');
		$goods = model('app\admin\model\wanlshop\Goods');
		$sku = model('app\api\model\wanlshop\GoodsSku');
		$shop = model('app\admin\model\wanlshop\Shop');
		$shopauth = model('app\admin\model\wanlshop\Auth');
		$comment = model('app\admin\model\wanlshop\Comment');
		$refund = model('app\admin\model\wanlshop\Refund');
		$withdraw = model('app\api\model\wanlshop\Withdraw');
		$moneylog = model('app\common\model\MoneyLog');
		// 处理POST
		if ($this->request->isPost()) {
		    $date = $this->request->post('date', '');
		    $type = $this->request->post('type', '');
		    if ($type == 'sale') {
		        list($orderSaleCategory, $orderSaleAmount, $orderSaleNums) = $this->getSaleStatisticsData($date);
		        $statistics = ['orderSaleCategory' => $orderSaleCategory, 'orderSaleAmount' => $orderSaleAmount, 'orderSaleNums' => $orderSaleNums];
		    }
		    $this->success('', '', $statistics);
		}
		// 店铺
		$this->view->assign("totalShop", $shop->where('verify','3')->count());
		// 用户
		$this->view->assign("totalUser", $user->count());
		$this->view->assign("totalDayUser", $user->whereTime('jointime', 'today')->count());
		// 商品
		$this->view->assign("totalGoods", $goods->count());
		$this->view->assign("totalGoodsViews", $goods->sum('views'));
		// 订单
		$this->view->assign("totalOrder", $order->count());
		$this->view->assign("paidOrder", $order->where('state','1')->count());
		$this->view->assign("deliveredOrder", $order->where('state','2')->count());
		$this->view->assign("receivedOrder", $order->where('state','3')->count());
		// SKU
		$this->view->assign("totalSku", $sku->where('stock','gt',0)->count());
		// 评论
		$this->view->assign("totalComment", $comment->count());
		// 退款->field('id,shopname,state')
		$this->view->assign("totalRefund", $refund->where('state','gt','4,5')->count());
		// 提现
		$this->view->assign("initiateWithdraw", $withdraw->count());
		// 资金统计
		$MoneyPaySum = $MoneyLogDayPay = $MoneyLogDayRecharge = 0;
		foreach ($moneylog->where('type','in',['pay','recharge'])->select() as $vo) {
			$money = abs(floatval($vo['money']));
			// 统计总额
			if($vo['type'] == 'pay'){
				$MoneyPaySum += $money;
			}
			// 统计今日
			if(date("Ymd", $vo['createtime']) == date("Ymd")){
				if($vo['type'] == 'pay'){
					$MoneyLogDayPay += $money;
				}else if($vo['type'] == 'recharge'){
					$MoneyLogDayRecharge += $money;
				}
			}
		}
		$this->view->assign("MoneyPaySum", $MoneyPaySum);
		$this->view->assign("MoneyLogDayPay", $MoneyLogDayPay);
		$this->view->assign("MoneyLogDayRecharge", $MoneyLogDayRecharge);
		// 热销TOP10
		$this->view->assign("goodsTopList", $goods->order('sales desc')->limit(10)->select());
		
		//订单数和订单额统计
		list($orderSaleCategory, $orderSaleAmount, $orderSaleNums) = $this->getSaleStatisticsData();
		$this->assignconfig('orderSaleCategory', $orderSaleCategory);
		$this->assignconfig('orderSaleAmount', $orderSaleAmount);
		$this->assignconfig('orderSaleNums', $orderSaleNums);
		
		// 待审核店铺
		$this->assignconfig("shopAuthList", $shopauth->where('verify','2')->field('id,shopname,state,verify')->select());
		
		// 介入退款
		$servicesRefundList = $refund->where('state','3')->field('id,order_pay_id,price,state')->select();
		foreach ($servicesRefundList as $vo) {
			$vo['pay'] = model('app\admin\model\wanlshop\Pay')
				->where('id', $vo['order_pay_id'])
				->field('order_no')
				->find();
		}
		$this->assignconfig('servicesRefundList', $servicesRefundList);
        return $this->view->fetch();
    }
	
	/**
	 * 获取订单销量销售额统计数据
	 * @param string $date
	 * @return array
	 */
	protected function getSaleStatisticsData($date = '')
	{
	    $starttime = \fast\Date::unixtime();
	    $endtime = \fast\Date::unixtime('day', 0, 'end');
	    $format = '%H:00';
		// 1.0.3修复 自动获取表前缀
		$prefix = Config::get('database.prefix');
		$list = model('app\admin\model\wanlshop\Order')
			->alias([$prefix.'wanlshop_order'=>'order', $prefix.'wanlshop_pay'=>'pay'])
			->join($prefix.'wanlshop_pay','pay.order_id = order.id')
			->where('order.createtime', 'between time', [$starttime, $endtime])
			->field('order.createtime, order.status,COUNT(*) AS nums,SUM(pay.price) AS amount,MIN(order.createtime) AS min_paytime,MAX(order.createtime) AS max_paytime,DATE_FORMAT(FROM_UNIXTIME(order.createtime), "' . $format . '") AS paydata')
			->group('paydata')
			->select();
	    $column = [];
	    for ($time = $starttime; $time <= $endtime;) {
	        $column[] = date("H:00", $time);
	        $time += 3600;
	    }
	    $orderSaleNums = $orderSaleAmount = array_fill_keys($column, 0);
	    foreach ($list as $vo) {
	        $orderSaleNums[$vo['paydata']] = $vo['nums'];
	        $orderSaleAmount[$vo['paydata']] = round($vo['amount'], 2);
	    }
	    $orderSaleCategory = array_keys($orderSaleAmount);
	    $orderSaleAmount = array_values($orderSaleAmount);
	    $orderSaleNums = array_values($orderSaleNums);
	    return [$orderSaleCategory, $orderSaleAmount, $orderSaleNums];
	}
}
