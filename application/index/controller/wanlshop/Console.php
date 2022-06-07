<?php

namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;

/**
 * 主頁
 * @internal
 */
class Console extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    
    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {

		$shop_id = $this->shop->id;

		$seventtime = \fast\Date::unixtime('day', -6);

		

		

		

		$paylist = $createlist = [];

		for ($i = 0; $i < 7; $i++)

		{

			$time = $seventtime + ($i * 86400);

		    $day = date("Y-m-d", $time);

			$start = $time;

			$end = $time + 86400;

			// 訂單數

		    $createlist[$day] = model('app\index\model\wanlshop\Order')

				->where('createtime','between', [$start,$end])

				->where(['shop_id' => $shop_id])

				->count();

			// 成交數

		    $paylist[$day] = model('app\index\model\wanlshop\Order')

				->where('createtime','between', [$start,$end])

				->where('createtime','in', '4,6')

				->where(['shop_id' => $shop_id])

				->count();

		}

		

		//七日增長

		$week = model('app\index\model\wanlshop\Order')->whereTime('createtime', 'week')->where('shop_id', $shop_id)->count();

		$lastweek = model('app\index\model\wanlshop\Order')->whereTime('createtime', 'last week')->where('shop_id', $shop_id)->count();

		if($week != 0 && $lastweek != 0 ){

			$sevendnu = bcdiv(bcmul(100, bcsub($week, $lastweek, 2), 2), $lastweek, 2);

		}else{

			$sevendnu = 0;

		}

        $this->view->assign([
            'totaluser'        => model('app\index\model\wanlshop\Goods')->where('shop_id', $shop_id)->count(), //商品總數
            'totalviews'       => model('app\index\model\wanlshop\Goods')->where('shop_id', $shop_id)->sum('views'), //總訪問數
            'totalorder'       => model('app\index\model\wanlshop\Order')->where('shop_id', $shop_id)->count(), // 總訂單數
            'totalorderamount' => model('app\index\model\wanlshop\Pay')->where('pay_state', 1)->where('shop_id', $shop_id)->sum('price'), //總金額
            'todayuserlogin'   => model('app\api\model\wanlshop\Cart')->where('shop_id', $shop_id)->count(), // 加購物車
            'todayusersignup'  => model('app\index\model\wanlshop\ShopFollow')->where('shop_id', $shop_id)->count(), // 店鋪收藏
            'todayorder'       => model('app\index\model\wanlshop\Order')->whereTime('createtime', 'today')->where('shop_id', $shop_id)->count(), // 今日訂單數量
            'unsettleorder'    => model('app\index\model\wanlshop\Order')->where(['shop_id' => $shop_id, 'state' => 2])->count(), // 未處理數量
            'sevendnu'         => $sevendnu.'%', 
            'sevendau'         => model('app\index\model\wanlshop\Pay')->whereTime('createtime', 'today')->where('shop_id', $shop_id)->sum('price'), //今日銷售額
            'paylist'          => $paylist,

            'createlist'       => $createlist
        ]);
        return $this->view->fetch();
    }
}




