<?php
namespace app\api1\controller\wanlshop;

use addons\wanlshop\library\WanlPay\WanlPay1;
use app\common\controller\Api;
use think\Db;

/**
 * WanlShop支付接口
 */
class Pay extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	/**
	 * 获取支付信息
	 *
	 * @ApiSummary  (WanlShop 获取支付信息)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 订单ID
	 */
	public function getPay()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('order_id');
			$id ? $id : ($this->error(__('非法请求')));
			// 判断权限
			$orderState = model('app\api1\model\wanlshop\Order')
				->where(['id' => $id, 'user_id' => $this->auth->id])
				->find();
			$orderState['state'] != 1 ? ($this->error(__('订单异常'))):'';
			// 获取支付信息
			$pay = model('app\api1\model\wanlshop\Pay')
				->where('order_id',$id)
				->field('id,order_id,order_no,pay_no,price')
				->find();
			$this->success('ok', $pay);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 支付订单
	 *
	 * @ApiSummary  (WanlShop 支付订单)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $order_id 订单ID
	 * @param string $type 支付类型
	 */
	public function payment()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $order_id = $this->request->post('order_id/a');
			$order_id ? $order_id : ($this->error(__('非法请求')));
			$type = $this->request->post('type');
			$method = $this->request->post('method');
			$code = $this->request->post('code');
			$user_id = $this->auth->id;
			$type ? $type : ($this->error(__('未选择支付类型')));
			// 判断权限
			$order = model('app\api1\model\wanlshop\Order')
                ->where('id', 'in', $order_id)
                ->where('user_id', $user_id)
				->select();
			if(!$order){
			    $this->error(__('没有找到任何要支付的订单'));
			}
			foreach($order as $item){
				if($item['state'] != 1){
				    $this->error(__('订单已支付，或网络繁忙'));
				}
			}
			// 调用支付
			$wanlPay = new WanlPay1($type, $method, $code);
			$data = $wanlPay->pay($order_id);
			if($data['code'] == 200){
			    $this->success('ok', $data['data']);
			}else{
			    $this->error($data['msg']);
			}
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 用户充值
	 */
	public function recharge()
	{
	    //设置过滤方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
			$money = $this->request->post('money');
			$type = $this->request->post('type');
			$method = $this->request->post('method');
			$code = $this->request->post('code');
			$user_id = $this->auth->id;
			$type ? $type : ($this->error(__('未选择支付类型')));
			$money ? $money : ($this->error(__('为输入充值金额')));
			// 调用支付
			$wanlPay = new WanlPay1($type, $method, $code);
			$data = $wanlPay->recharge($money);
			if($data['code'] == 200){
			    $this->success($data['msg'], $data['data']);
			}else{
			    $this->error($data['msg']);
			}
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 用户提现账户
	 */
	public function getPayAccount()
	{
	    //设置过滤方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $row = model('app\api1\model\wanlshop\PayAccount')
		        ->where(['user_id' => $this->auth->id])
		        ->order('createtime desc')
		        ->select();
		    $this->success('ok', $row);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 新增提现账户
	 */
	public function addPayAccount()
	{
	    //设置过滤方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $post = $this->request->post();
		    $post['user_id'] = $this->auth->id;
            $row = model('app\api1\model\wanlshop\PayAccount')->allowField(true)->save($post);
		    if($row){
		        $this->success('ok', $row);
		    }else{
		        $this->error(__('新增失败'));
		    }
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 删除提现账户
	 */
	public function delPayAccount($ids = '')
	{	
		$row = model('app\api1\model\wanlshop\PayAccount')
			->where('id', 'in', $ids)
			->where(['user_id' => $this->auth->id])
			->delete();
		if($row){
		    $this->success('ok', $row);
		}else{
		    $this->error(__('删除失败'));
		}
	}
	
	/**
	 * 初始化提现
	 */
	public function initialWithdraw()
	{
	    //设置过滤方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
			$config = get_addon_config('wanlshop');
		    $bank = model('app\api1\model\wanlshop\PayAccount')
		        ->where(['user_id' => $this->auth->id])
		        ->order('createtime desc')
		        ->find();
		    $this->success('ok', [
		        'money' => $this->auth->money,
				'servicefee' => $config['withdraw']['servicefee'],
		        'bank' => $bank
		    ]);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 用户提现
	 */
	public function withdraw()
	{
	    //设置过滤方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        // 金额
			$money = $this->request->post('money');
            // 账户
            $account_id = $this->request->post('account_id');
            if ($money <= 0) {
                $this->error('提现金额不正确');
            }
            if ($money > $this->auth->money) {
                $this->error('提现金额超出可提现额度');
            }
            if (!$account_id) {
                $this->error("提现账户不能为空");
            }
            // 查询提现账户
            $account = \app\api1\model\wanlshop\PayAccount::where(['id' => $account_id, 'user_id' => $this->auth->id])->find();
            if (!$account) {
                $this->error("提现账户不存在");
            }
            $config = get_addon_config('wanlshop');
            if ($config['withdraw']['state'] == 'N'){
                $this->error("系统该关闭提现功能，请联系平台客服");
            }
            if (isset($config['withdraw']['minmoney']) && $money < $config['withdraw']['minmoney']) {
                $this->error('提现金额不能低于' . $config['withdraw']['minmoney'] . '元');
            }
            if ($config['withdraw']['monthlimit']) {
                $count = \app\api1\model\wanlshop\Withdraw::where('user_id', $this->auth->id)->whereTime('createtime', 'month')->count();
                if ($count >= $config['withdraw']['monthlimit']) {
                    $this->error("已达到本月最大可提现次数");
                }
            }
			// 计算提现手续费
			if($config['withdraw']['servicefee'] && $config['withdraw']['servicefee'] > 0){
				$servicefee = number_format($money * $config['withdraw']['servicefee'] / 1000, 2);
				$handingmoney = $money - number_format($money * $config['withdraw']['servicefee'] / 1000, 2);
			}else{
				$servicefee = 0;
				$handingmoney = $money;
			}
            Db::startTrans();
            try {
                $data = [
                    'user_id' => $this->auth->id,
                    'money'   => $handingmoney,
					'handingfee' => $servicefee, // 手续费
                    'type'    => $account['bankCode'],
                    'account' => $account['cardCode'],
					'orderid' => date("Ymdhis") . sprintf("%08d", $this->auth->id) . mt_rand(1000, 9999)
                ];
                $withdraw = \app\api1\model\wanlshop\Withdraw::create($data);
				$pay = new WanlPay1;
				$pay->money(-$money, $this->auth->id, '申请提现', 'withdraw', $withdraw['id']);
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
			$this->success('提现申请成功！请等待后台审核', $this->auth->money);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 获取支付日志
	 */
	public function withdrawLog()
	{
	    //设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api1\model\wanlshop\Withdraw')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 获取支付日志
	 */
	public function moneyLog()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\common\model\MoneyLog')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 获取支付详情
	 */
	public function details($id = null, $type = null)
	{
		if($type == 'pay'){
			$order = model('app\api1\model\wanlshop\Order')
				->where('order_no', 'in', $id)
				->where('user_id', $this->auth->id)
				->field('id,shop_id,createtime,paymenttime')
				->select();
			if(!$order){
				$this->error(__('订单异常'));
			}
			foreach($order as $vo){
			    $vo->pay->visible(['price','pay_no','order_no','order_price','trade_no','actual_payment','freight_price','discount_price','total_amount']);
				$vo->shop->visible(['shopname']);
				$vo->goods = model('app\api1\model\wanlshop\OrderGoods')
					->where(['order_id' => $vo['id']])
					->field('id,title,difference,image,price,number')
					->select();
			}
			$this->success('ok', $order);
		}else if($type == 'recharge' || $type == 'withdraw'){ // 用户充值
			if($type == 'recharge'){
				$model = model('app\api1\model\wanlshop\RechargeOrder');
				$field = 'id,paytype,orderid,memo';
			}else{
				$model = model('app\api1\model\wanlshop\Withdraw');
				$field = 'id,money,handingfee,status,type,account,orderid,memo,transfertime';
			}
			$row = $model
				->where(['id' => $id, 'user_id' => $this->auth->id])
				->field($field)
				->find();
			$this->success('ok', $row);
		}else if($type == 'refund'){
			$order = model('app\api1\model\wanlshop\Order')
				->where('order_no', $id)
				->where('user_id', $this->auth->id)
				->field('id,shop_id,order_no,createtime,paymenttime')
				->find();
			if(!$order){
				$this->error(__('订单异常'));
			}
			$order->shop->visible(['shopname']);
			$order['refund'] = model('app\api1\model\wanlshop\Refund')
				->where(['order_id' => $order['id'], 'user_id' => $this->auth->id])
				->field('id,price,type,reason,createtime,completetime')
				->find();
			$this->success('ok', $order);
		}else{ // 系统
			$this->success('ok');
		}
	}
	
	/**
	 * 获取余额
	 */
	public function getBalance()
	{
		$this->success('ok', $this->auth->money);
	}
	
}