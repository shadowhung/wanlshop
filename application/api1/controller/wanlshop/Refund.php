<?php
namespace app\api1\controller\wanlshop;

use app\common\controller\Api;
use think\Db;

/**
 * WanlShop退款接口
 */
class Refund extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	/**
	 * 查询退款
	 *
	 * @ApiSummary  (WanlShop 退款接口查询退款)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function refundList()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api1\model\wanlshop\Refund')
				->where('user_id', $this->auth->id)
				->field('id,shop_id,goods_ids,price,type,state')
				->order('createtime desc')
				->paginate()
				->each(function($data, $key){
					$data['goods'] = $data->goods ? $data->goods->visible(['id','title','image','price','difference']):'';
					$data['shop'] = $data->shop ? $data->shop->visible(['id','shopname']):'';
					return $data;
				});
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 提交售后服务
	 *
	 * @ApiSummary  (WanlShop 退款接口提交售后服务)
	 * @ApiMethod   (POST)
	 * 
	 */
	public function addApply()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $params = $this->request->post();
			$params ? $params : ($this->error(__('非正常访问')));
			$user_id = $this->auth->id;
			// 查询商品
			$goods = model('app\api1\model\wanlshop\OrderGoods')->get($params['goods']);
			if(!$goods || $goods['refund_status'] != 0){
				$this->error(__('订单中商品不存在，或已退款！'));
			}
			// 查询订单
			$order = model('app\api1\model\wanlshop\Order')
				->where(['id' => $params['order_id'], 'user_id' => $user_id])
				->find();
			$order ? $order : $this->error(__('订单异常'));

			// 判断金额 1.0.2升级

			if($params['money'] > $order->pay->price){

				$this->error('非法操作：退款不能超过'. $order->pay->price .'元');

			}

			// 获取配置
			$config = get_addon_config('wanlshop');
			if($order['taketime']){
				if(time() - ($order['taketime'] + $config['order']['customer'] * 60 * 60 * 24) > 0){
					$this->error(__('订单已经超过申请售后时间'));
				}
			}
			// 查询支付
			$pay = $order->pay;
			if($pay['pay_state'] != 1){
				$this->error(__('非正常访问，订单尚未付款'));
			}
			// 判断是否填写
			if(is_array($params['type'])){
				$this->error(__('退款类型'));
			}
			if(is_array($params['reason'])){
				$this->error(__('退款原因'));
			}
			if(is_array($params['expressType'])){
				$this->error(__('物流状态'));
			}
			// 提交数据
			$refund = model('app\api1\model\wanlshop\Refund');
			$refund->user_id = $user_id;
			$refund->shop_id = $order['shop_id'];
			$refund->order_id = $order['id'];
			$refund->order_pay_id = $pay['id'];
			$refund->goods_ids = $params['goods'];
			$refund->expressType = $params['expressType'];
			$refund->price = $params['money'];
			$refund->type = $params['type'];
			$refund->reason = $params['reason'];
			$refund->images = $params['images'];
			$refund->refund_content = $params['refund_content'];
			// 创建时间 = 退款时间
			// 保存
			if($refund->save()){
				// $order->save(['state' => 5]);  // 修改订单状态，已弃用
				$goods->save(['refund_status' => 1, 'refund_id' => $refund->id]);  // 修改订单商品状态提交退款中,并更新退款ID
				// 写入日志
				$this->refundLog($refund->id, '提交'. $refund->type_text .',物流状态：'. $refund->expressType_text .'，退款原因：'. $refund->reason_text .'，退款金额：￥'. $refund->price .'元；退款理由：'. $refund->refund_content);
				$this->success('ok', $refund->id);
			}
			$this->error(__('网络异常'));
		}
		$this->error(__('非法请求'));
	}
	
	
	/**
	 * 提交售后服务
	 *
	 * @ApiSummary  (WanlShop 退款接口提交售后服务)
	 * @ApiMethod   (POST)
	 * 
	 */
	public function editRefund()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$params = $this->request->post();
			$params ? $params : ($this->error(__('非正常访问')));
			$user_id = $this->auth->id;
			// 查询退货
			$refund = model('app\api1\model\wanlshop\Refund')
				->where(['id' => $params['id'], 'user_id' => $user_id])
				->find();
			$refund ? $refund : ($this->error(__('没找到退款信息')));
			// 更新退款
			$params['state'] = 0;
			$data = $refund->update($params);
			// 写入日志
			$this->refundLog($data['id'], '买家修改退款：'. $data['type_text'] .',物流状态：'. $data['expressType_text'] .'，退款原因：'. $data['reason_text'] .'，退款金额：￥'. $data['price'] .'元；退款理由：'. $data['refund_content']);
		    $this->success('ok', $data['id']);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 查看退款详情
	 *
	 * @ApiSummary  (WanlShop 退款接口查看退款详情)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $id 退款ID
	 */
	public function getRefundInfo()
	{
		$this->request->filter(['strip_tags']);
		$id = $this->request->request('id');
		$config = get_addon_config('wanlshop');
		// 获取退款
		$refund = $this->getRefund($id);
		// 获取快递列表
		$kuaidi = model('app\api1\model\wanlshop\Kuaidi')
			->field('id,name,code')
			->select();
		$refund['kuaidi'] = $kuaidi?$kuaidi:[];
		// 运费策略
		$refund['freight_type'] = model('app\api1\model\wanlshop\Order')->get($refund['order_id'])['freight_type'];
		// 获取商家退货地址
		if($refund['state'] == 1){
			$shopConfig = model('app\api1\model\wanlshop\ShopConfig')
				->where(['shop_id' => $refund['shop_id']])
				->field('returnAddr,returnName,returnPhoneNum')
				->find();
			$refund['shopConfig'] = $shopConfig?$shopConfig:[];
		}
		// 获取系统配置
		$refund['config'] = $config['order'];
		// 获取订单商品
		$refund['goods'] = model('app\api1\model\wanlshop\OrderGoods')
			->where(['id' => $refund['goods_ids']])
			->field('id,title,difference,image,price,freight_price,number')
			->find();
		// 获取订单商品总数
		$refund['goods_number'] = model('app\api1\model\wanlshop\OrderGoods')
			->where(['order_id' => $refund['order_id']])
			->count();
		$this->success('ok', $refund);
	}
	
	/**
	 * 提交退货快递
	 *
	 * @ApiSummary  (WanlShop 退款接口提交退货快递)
	 * @ApiMethod   (POST)
	 */
	public function toExpress()
	{
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$params = $this->request->post();
			$params ? $params : ($this->error(__('非正常访问')));
			// 查询退货
			$refund = $this->getRefund($params['id']);
			// 更新退款
			$result = $refund->allowField(true)->save([
				'state' => 6,
				'express_name' => $params['express_name'],
				'express_no' => $params['express_no'],
				'returntime' => time()
			]);
			// 写入日志
			$this->refundLog($refund['id'], '买家已退货，运单号：'.$params['express_no'].'，快递公司：'.$params['express_name']);
		    $this->success('ok', $params['id']);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 提交关闭退款
	 *
	 * @ApiSummary  (WanlShop 退款接口提交关闭退款)
	 * @ApiMethod   (GET)
	 */
	public function closeRefund($id = null)
	{
		$row = model('app\api1\model\wanlshop\Refund')
			->where(['id' => $id, 'user_id' => $this->auth->id])
			->find();
		// 更新退款
		$row->allowField(true)->save(['closingtime' => time(),'state' => 5]);
		if($row){
			// 修改订单商品退款状态
			model('app\api1\model\wanlshop\OrderGoods')->allowField(true)->save(['refund_status' => 4],['id' => $row['goods_ids']]);
			// 写入日志
			$this->refundLog($id, '买家关闭退款');
			$this->success('ok', $id);
		}
		$this->error(__('退款订单异常，请稍后再试'));
	}
	
	/**
	 * 获取退款历史
	 *
	 * @ApiSummary  (WanlShop 退款接口获取退款历史)
	 * @ApiMethod   (GET)
	 */
	public function getRefundLog($id = null)
	{
		$log = model('app\api1\model\wanlshop\RefundLog')
			->where(['refund_id' => $id, 'user_id' => $this->auth->id])
			->order('createtime desc')
			->select();
		if($log){
			$data = [];
			foreach ($log as $vo) {
				if($vo['type'] == 0){
					$name = $this->auth->nickname;
					$avatar = $this->auth->avatar;
				}else if($vo['type'] == 1){
					$shop = model('app\api1\model\wanlshop\Shop')->get($vo['shop_id']);
					$name = $shop['shopname'];
					$avatar = $shop['avatar'];
				}else if($vo['type'] == 2){
					$name = '小二';
					$avatar = '/assets/addons/wanlshop/img/common/service_3x.png';
				}else{
					$name = '系统';
					$avatar = '/assets/addons/wanlshop/img/common/logo.png';
				}
				$data[] = [
					'id' => $vo['id'],
					'content' => $vo['content'],
					'name' => $name,
					'createtime_text' => $vo['createtime_text'],
					'avatar' => $avatar
				];
			}
			$this->success('ok', $data);
		}
		$this->error(__('退款订单异常，请稍后再试'));
	}
	
	/**
	 * 客服介入
	 *
	 * @ApiSummary  (WanlShop 退款接口客服介入)
	 * @ApiMethod   (GET)
	 */
	public function arbitrationRefund($id = null)
	{
		$refund = $this->getRefund($id);
		if($refund['state'] == 2){
			$refund->save(['state' => 3]);
			$this->refundLog($id, '买家申请客服介入');
			$this->success('ok', $id);
		}
		$this->error(__('卖家拒绝后，才可以申请客服介入'));
	}
	
	/**
	 * 退款日志（方法内使用）
	 *
	 * @ApiSummary  (WanlShop 退款日志)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $refund_id 退款ID
	 * @param string $content 日志内容
	 */
	private function refundLog($refund_id = 0, $content = '')
	{
		return model('app\api1\model\wanlshop\RefundLog')->save([
			'user_id' => $this->auth->id,
			'refund_id' => $refund_id,
			'content' => $content
		]);
	}
	
	/**
	 * 查询退款（方法内使用）
	 *
	 * @ApiSummary  (WanlShop 查询退款)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $refund_id 退款ID
	 */
	private function getRefund($refund_id = 0)
	{
		$refund = model('app\api1\model\wanlshop\Refund')
			->where(['id' => $refund_id, 'user_id' => $this->auth->id])
			->find();
		return  $refund ? $refund : ($this->error(__('没找到退款信息')));
	}
	
}