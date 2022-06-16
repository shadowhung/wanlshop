<?php
namespace app\api\controller\wanlshop;

use addons\wanlshop\library\WanlPay\WanlPay;
use app\common\controller\Api;
use think\Db;
use think\Config;
/**
 * WanlShop支付接口
 */
class Pay extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	/**
	 * 獲取支付信息
	 *
	 * @ApiSummary  (WanlShop 獲取支付信息)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 訂單ID
	 */
	public function getPay()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('order_id');
			$id ? $id : ($this->error(__('違法なリクエスト')));
			// 判斷權限
			$orderState = model('app\api\model\wanlshop\Order')
				->where(['id' => $id, 'user_id' => $this->auth->id])
				->find();
			$orderState['state'] != 1 ? ($this->error(__('注文の例外'))):'';
			// 獲取支付信息
			$pay = model('app\api\model\wanlshop\Pay')
				->where('order_id',$id)
				->field('id,order_id,order_no,pay_no,price')
				->find();
			$this->success('ok', $pay);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 支付訂單
	 *
	 * @ApiSummary  (WanlShop 支付訂單)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $order_id 訂單ID
	 * @param string $type 支付類型
	 */
	public function payment()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        $user    = $this->auth->getUser();
	        
	        $captcha = $this->request->post('captcha');
	        
	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
	            $this->error('間違った支払いパスワード');
	        }
	        
	        
		    $order_id = $this->request->post('order_id/a');
			$order_id ? $order_id : ($this->error(__('違法なリクエスト')));
			$type = $this->request->post('type');
			$method = $this->request->post('method');
			$code = $this->request->post('code');
			$user_id = $this->auth->id;
			$type ? $type : ($this->error(__('支払いタイプが選択されていません')));
			// 判斷權限
			$order = model('app\api\model\wanlshop\Order')
                ->where('id', 'in', $order_id)
                ->where('user_id', $user_id)
				->select();
			
			$shopInfo = model('app\api\model\wanlshop\Shop')
			    ->where('id',$order[0]->shop_id)
			    ->find();
			$shopUserInfo = \app\common\model\User::where('id', $shopInfo['user_id'])->find();
			
			
			// 獲取支付信息
    		$pay = model('app\api\model\wanlshop\Pay')
    			->where('order_id', 'in', $order_id)
    			->where('user_id', $user_id)
    			->select();
            // 付款金額
        	$price = 0;
    		foreach($pay as $row){
    			// 總價格
    			$price += $row['price'];
    		}
    		
    		
		
			if(!$order){
			    $this->error(__('支払う注文が見つかりませんでした'));
			}
			foreach($order as $item){
				if($item['state'] != 1){
				    $this->error(__('注文が支払われたか、ネットワークがビジーです'));
				}
			}
			// 調用支付
			$wanlPay = new WanlPay($type, $method, $code);
			$data = $wanlPay->pay($order_id);
			if($data['code'] == 200){
			    /*
			        支付成功，更改用户的冻结金额
			    */
			    //金额设置成冻结金额
        		$shopUserInfo->frozen_money = $price;
        		$shopUserInfo->save();
			    $this->success('ok', $data['data']);
			}else{
			    $this->error($data['msg']);
			}
		}
		$this->error(__('異常なリクエスト'));
	}
	
	public function getpaypass()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        
	        $user    = $this->auth->getUser();
	        $captcha = $this->request->post('captcha');
	        
	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
	            $this->error('間違った支払いパスワード');
	        }
	        
		     $this->success('ok', 1);
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 用戶充值
	 */
	public function recharge()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
			$money = $this->request->post('money');
			$type = $this->request->post('type');
			$method = $this->request->post('method');
			$code = $this->request->post('code');
			$Pay_zg = $this->request->post('Pay_zg');
			$user_id = $this->auth->id;
			$type ? $type : ($this->error(__('支払いタイプが選択されていません')));
			$money ? $money : ($this->error(__('チャージ金額を入力してください')));
			// 調用支付
			$wanlPay = new WanlPay($type, $method, $code, $Pay_zg);
			$data = $wanlPay->recharge($money);
			if($data['code'] == 200){
			    $this->success($data['msg'], $data['data']);
			}else{
			    $this->error($data['msg']);
			}
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 用戶提現賬戶
	 */
	public function getPayAccount()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $row = model('app\api\model\wanlshop\PayAccount')
		        ->where(['user_id' => $this->auth->id])
		        ->order('createtime desc')
		        ->select();
		    $this->success('ok', $row);
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 新增提現賬戶
	 */
	public function addPayAccount()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $post = $this->request->post();
		    $post['user_id'] = $this->auth->id;
            $row = model('app\api\model\wanlshop\PayAccount')->allowField(true)->save($post);
		    if($row){
		        $this->success('ok', $row);
		    }else{
		        $this->error(__('追加に失敗しました'));
		    }
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 刪除提現賬戶
	 */
	public function delPayAccount($ids = '')
	{	
		$row = model('app\api\model\wanlshop\PayAccount')
			->where('id', 'in', $ids)
			->where(['user_id' => $this->auth->id])
			->delete();
		if($row){
		    $this->success('ok', $row);
		}else{
		    $this->error(__('削除に失敗しました'));
		}
	}
	
	/**
	 * 初始化提現
	 */
	public function initialWithdraw()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
			$config = get_addon_config('wanlshop');
		    $bank = model('app\api\model\wanlshop\PayAccount')
		        ->where(['user_id' => $this->auth->id])
		        ->order('createtime desc')
		        ->find();
		    $this->success('ok', [
		        'money' => $this->auth->money,
				'servicefee' => $config['withdraw']['servicefee'],
		        'bank' => $bank
		    ]);
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 用戶提現
	 */
	public function withdraw()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        $user    = $this->auth->getUser();
	        $captcha = $this->request->post('captcha');
	        
	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
	            $this->error('間違った支払いパスワード');
	        }
	        // 金額
			$money = $this->request->post('money');
            // 賬戶
            $account_id = $this->request->post('account_id');
            if ($money <= 0) {
                $this->error('不正な引き出し金額');
            }
            if ($money > $this->auth->money) {
                $this->error('出金金額が出金限度額を超えている');
            }
            if (!$account_id) {
                $this->error("引き出し口座を空にすることはできません");
            }
            // 查詢提現賬戶
            $account = \app\api\model\wanlshop\PayAccount::where(['id' => $account_id, 'user_id' => $this->auth->id])->find();
            if (!$account) {
                $this->error("引き出し口座が存在しません");
            }
            $config = get_addon_config('wanlshop');
            if ($config['withdraw']['state'] == 'N'){
                $this->error("システムは引き出し機能を閉じる必要があります。プラットフォームのカスタマーサービスに連絡してください");
            }
            if (isset($config['withdraw']['minmoney']) && $money < $config['withdraw']['minmoney']) {
                $this->error('引き出し額は以下にすることはできません' . $config['withdraw']['minmoney'] . 'NT$');
            }
            if ($config['withdraw']['monthlimit']) {
                $count = \app\api\model\wanlshop\Withdraw::where('user_id', $this->auth->id)->whereTime('createtime', 'month')->count();
                if ($count >= $config['withdraw']['monthlimit']) {
                    $this->error("今月の最大引き出し数に達しました");
                }
            }
			// 計算提現手續費
			if($config['withdraw']['servicefee'] && $config['withdraw']['servicefee'] > 0){
				$servicefee = sprintf("%.2f",$money * $config['withdraw']['servicefee'] / 1000);
				$handingmoney = sprintf("%.2f",$money - ($money * $config['withdraw']['servicefee'] / 1000));
			}else{
				$servicefee = 0;
				$handingmoney = $money;
			}
            Db::startTrans();
            try {
                $data = [
                    'user_id' => $this->auth->id,
                    'money'   => $handingmoney,
                    'name'     => $user['nickname'],
                    'mobile'   => $user['mobile'],
					'handingfee' => $servicefee, // 手續費
                    'type'    => $account['bankCode'],
                    'account' => $account['cardCode'],
                    'username' => $account['username'],
                    'bankname2' => $account['bankName2'],
					'orderid' => date("Ymdhis") . sprintf("%08d", $this->auth->id) . mt_rand(1000, 9999)
                ];
                $withdraw = \app\api\model\wanlshop\Withdraw::create($data);
				$pay = new WanlPay;
				$pay->money(-$money, $this->auth->id, '撤退を申請する', 'withdraw', $withdraw['id']);
				
				/*
				    提现到-审批金额
				*/
			    $user->approval_money = $money;
			    $user->save();
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
			$this->success('出金申請は成功です！ バックグラウンドレビューをお待ちください', $this->auth->money);
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 獲取支付日誌
	 */
	public function withdrawLog()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Withdraw')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 獲取支付日誌
	 */
	public function rechargeLog()
	{
	    //設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Recharge')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 獲取支付日誌
	 */
	public function moneyLog()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\common\model\MoneyLog')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 獲取支付詳情
	 */
	public function details($id = null, $type = null)
	{
		if($type == 'pay'){
		    //var_dump($id);exit;
			$order = model('app\api\model\wanlshop\Order')
				->where('order_no', 'in', $id)
				//->where('user_id', $this->auth->id)
				->field('id,shop_id,createtime,paymenttime')
				->select();
			//var_dump($order);exit;
			
			if(!$order){
				$this->error(__('注文が削除されます'));
			}
			foreach($order as $vo){
			    $vo->pay->visible(['price','pay_no','order_no','order_price','trade_no','actual_payment','freight_price','discount_price','total_amount']);
				$vo->shop->visible(['shopname']);
				$vo->goods = model('app\api\model\wanlshop\OrderGoods')
					->where(['order_id' => $vo['id']])
					->field('id,title,difference,image,price,number')
					->select();
			}
			$this->success('ok', $order);
		}else if($type == 'recharge' || $type == 'withdraw'){ // 用戶充值
			if($type == 'recharge'){
				$model = model('app\api\model\wanlshop\RechargeOrder');
				$field = 'id,paytype,orderid,memo';
			}else{
				$model = model('app\api\model\wanlshop\Withdraw');
				$field = 'id,money,handingfee,status,type,account,orderid,memo,transfertime';
			}
			$row = $model
				->where(['id' => $id, 'user_id' => $this->auth->id])
				->field($field)
				->find();
			$this->success('ok', $row);
		}else if($type == 'refund'){
			$order = model('app\api\model\wanlshop\Order')
				->where('order_no', $id)
				->where('user_id', $this->auth->id)
				->field('id,shop_id,order_no,createtime,paymenttime')
				->find();
			if(!$order){
				$this->error(__('注文が削除されます'));
			}
			$order->shop->visible(['shopname']);
			$order['refund'] = model('app\api\model\wanlshop\Refund')
				->where(['order_id' => $order['id'], 'user_id' => $this->auth->id])
				->field('id,price,type,reason,createtime,completetime')
				->find();
			$this->success('ok', $order);
		}else{ // 系統
			$this->success('ok');
		}
	}
	
	public function getRechargemoney()
	{
	    $recharge_money =  Config::get('site.recharge_money');
		$this->success('ok', $recharge_money);
	}
	
	public function payisok()
	{
	    $payisok =  Config::get('site.payisok');
		$this->success('ok', $payisok);
	}
	
	/**
	 * 儲值金額
	 */
	public function getRecharge()
	{
	    $arr['rechargeline'] =  Config::get('site.rechargeline');
	    $arr['lineimages'] =  Config::get('site.lineimages');
	    $arr['lineurl'] =  Config::get('site.lineurl');
	    $arr['bank_kaihu'] =  Config::get('site.bank_kaihu');
	    $arr['bank_add']   =  Config::get('site.bank_add');
	    $arr['bank_name']  =  Config::get('site.bank_name');
	    $arr['bank_num']   =  Config::get('site.bank_num');
		$this->success('ok', $arr);
	}
	
	/**
	 * 獲取余額
	 */
	public function getBalance()
	{
		$this->success('ok', $this->auth->money);
	}
	
	/**
	 * 商户url
	 */
	public function getShanghuurl()
	{
	    $shanghuurl =  Config::get('site.shanghuurl');
		$this->success('ok', $shanghuurl);
	}
	
	
	/**
	 * 獲取余額
	 */
	public function getBalance1()
	{
	    $userid = $this->request->post('userid');
	    $user = model('app\admin\model\User')
				->where(['id' => $userid])
				->find();
		$this->success('ok', $user['money']?$user['money']:0);
	}
	
}