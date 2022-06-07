<?php
namespace app\api\controller\wanlshop;

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
	 * 查詢退款
	 *
	 * @ApiSummary  (WanlShop 退款接口查詢退款)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function refundList()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Refund')
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
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 提交售後服務
	 *
	 * @ApiSummary  (WanlShop 退款接口提交售後服務)
	 * @ApiMethod   (POST)
	 * 
	 */
	public function addApply()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $params = $this->request->post();
			$params ? $params : ($this->error(__('異常な訪問')));
			$user_id = $this->auth->id;
			// 查詢商品
			$goods = model('app\api\model\wanlshop\OrderGoods')->get($params['goods']);
			if(!$goods || $goods['refund_status'] != 0){
				$this->error(__('注文のアイテムが存在しないか、返金されました！'));
			}
			// 查詢訂單
			$order = model('app\api\model\wanlshop\Order')
				->where(['id' => $params['order_id'], 'user_id' => $user_id])
				->find();
			$order ? $order : $this->error(__('注文の例外'));

			// 判斷金額 1.0.2升級

			if($params['money'] > $order->pay->price){

				$this->error('違法な操作：払い戻しは超過できません'. $order->pay->price .'円');

			}

			// 獲取配置
			$config = get_addon_config('wanlshop');
			if($order['taketime']){
				if(time() - ($order['taketime'] + $config['order']['customer'] * 60 * 60 * 24) > 0){
					$this->error(__('注文がアプリケーションのアフターセールス時間を超えました'));
				}
			}
			// 查詢支付
			$pay = $order->pay;
			if($pay['pay_state'] != 1){
				$this->error(__('異常な訪問，注文は支払われていません'));
			}
			// 判斷是否填寫
			if(is_array($params['type'])){
				$this->error(__('払い戻しの種類'));
			}
			if(is_array($params['reason'])){
				$this->error(__('帰国の理由'));
			}
			if(is_array($params['expressType'])){
				$this->error(__('ロジスティクスステータス'));
			}
			// 提交數據
			$refund = model('app\api\model\wanlshop\Refund');
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
			// 創建時間 = 退款時間
			// 保存
			if($refund->save()){
				// $order->save(['state' => 5]);  // 修改訂單狀態，已棄用
				$goods->save(['refund_status' => 1, 'refund_id' => $refund->id]);  // 修改訂單商品狀態提交退款中,並更新退款ID
				// 寫入日誌
				$this->refundLog($refund->id, '参加する'. $refund->type_text .',ロジスティクスステータス：'. $refund->expressType_text .'，帰国の理由：'. $refund->reason_text .'，返金金額：'. $refund->price .'NT$；返金の理由：'. $refund->refund_content);
				$this->success('ok', $refund->id);
			}
			$this->error(__('ネットワークの異常'));
		}
		$this->error(__('違法なリクエスト'));
	}
	
	
	/**
	 * 提交售後服務
	 *
	 * @ApiSummary  (WanlShop 退款接口提交售後服務)
	 * @ApiMethod   (POST)
	 * 
	 */
	public function editRefund()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$params = $this->request->post();
			$params ? $params : ($this->error(__('異常な訪問')));
			$user_id = $this->auth->id;
			// 查詢退貨
			$refund = model('app\api\model\wanlshop\Refund')
				->where(['id' => $params['id'], 'user_id' => $user_id])
				->find();
			$refund ? $refund : ($this->error(__('返金情報が見つかりません')));
			// 更新退款
			$params['state'] = 0;
			$data = $refund->update($params);
			// 寫入日誌
			$this->refundLog($data['id'], '買家修改退款：'. $data['type_text'] .',ロジスティクスステータス：'. $data['expressType_text'] .'，帰国の理由：'. $data['reason_text'] .'，返金金額：'. $data['price'] .'NT$；返金の理由：'. $data['refund_content']);
		    $this->success('ok', $data['id']);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 查看退款詳情
	 *
	 * @ApiSummary  (WanlShop 退款接口查看退款詳情)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $id 退款ID
	 */
	public function getRefundInfo()
	{
		$this->request->filter(['strip_tags']);
		$id = $this->request->request('id');
		$config = get_addon_config('wanlshop');
		// 獲取退款
		$refund = $this->getRefund($id);
		// 獲取快遞列表
		$kuaidi = model('app\api\model\wanlshop\Kuaidi')
			->field('id,name,code')
			->select();
		$refund['kuaidi'] = $kuaidi?$kuaidi:[];
		// 運費策略
		$refund['freight_type'] = model('app\api\model\wanlshop\Order')->get($refund['order_id'])['freight_type'];
		// 獲取商家退貨地址
		if($refund['state'] == 1){
			$shopConfig = model('app\api\model\wanlshop\ShopConfig')
				->where(['shop_id' => $refund['shop_id']])
				->field('returnAddr,returnName,returnPhoneNum')
				->find();
			$refund['shopConfig'] = $shopConfig?$shopConfig:[];
		}
		// 獲取系統配置
		$refund['config'] = $config['order'];
		// 獲取訂單商品
		$refund['goods'] = model('app\api\model\wanlshop\OrderGoods')
			->where(['id' => $refund['goods_ids']])
			->field('id,title,difference,image,price,freight_price,number')
			->find();
		// 獲取訂單商品總數
		$refund['goods_number'] = model('app\api\model\wanlshop\OrderGoods')
			->where(['order_id' => $refund['order_id']])
			->count();
		$this->success('ok', $refund);
	}
	
	/**
	 * 提交退貨快遞
	 *
	 * @ApiSummary  (WanlShop 退款接口提交退貨快遞)
	 * @ApiMethod   (POST)
	 */
	public function toExpress()
	{
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$params = $this->request->post();
			$params ? $params : ($this->error(__('異常な訪問')));
			// 查詢退貨
			$refund = $this->getRefund($params['id']);
			// 更新退款
			$result = $refund->allowField(true)->save([
				'state' => 6,
				'express_name' => $params['express_name'],
				'express_no' => $params['express_no'],
				'returntime' => time()
			]);
			// 寫入日誌
			$this->refundLog($refund['id'], '購入者が商品、運送状番号を返品しました：'.$params['express_no'].'，宅配会社：'.$params['express_name']);
		    $this->success('ok', $params['id']);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 提交關閉退款
	 *
	 * @ApiSummary  (WanlShop 退款接口提交關閉退款)
	 * @ApiMethod   (GET)
	 */
	public function closeRefund($id = null)
	{
		$row = model('app\api\model\wanlshop\Refund')
			->where(['id' => $id, 'user_id' => $this->auth->id])
			->find();
		// 更新退款
		$row->allowField(true)->save(['closingtime' => time(),'state' => 5]);
		if($row){
			// 修改訂單商品退款狀態
			model('app\api\model\wanlshop\OrderGoods')->allowField(true)->save(['refund_status' => 4],['id' => $row['goods_ids']]);
			// 寫入日誌
			$this->refundLog($id, '購入者は払い戻しを終了します');
			$this->success('ok', $id);
		}
		$this->error(__('払い戻しの順序が異常です。しばらくしてからもう一度お試しください'));
	}
	
	/**
	 * 獲取退款歷史
	 *
	 * @ApiSummary  (WanlShop 退款接口獲取退款歷史)
	 * @ApiMethod   (GET)
	 */
	public function getRefundLog($id = null)
	{
		$log = model('app\api\model\wanlshop\RefundLog')
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
					$shop = model('app\api\model\wanlshop\Shop')->get($vo['shop_id']);
					$name = $shop['shopname'];
					$avatar = $shop['avatar'];
				}else if($vo['type'] == 2){
					$name = 'こうじ';
					$avatar = '/assets/addons/wanlshop/img/common/service_3x.png';
				}else{
					$name = 'システム';
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
		$this->error(__('払い戻しの順序が異常です。しばらくしてからもう一度お試しください'));
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
			$this->refundLog($id, 'バイヤーはカスタマーサービスの介入を申請します');
			$this->success('ok', $id);
		}
		$this->error(__('売り手が拒否した後、あなたは介入するためにカスタマーサービスを申請することができます'));
	}
	
	/**
	 * 退款日誌（方法內使用）
	 *
	 * @ApiSummary  (WanlShop 退款日誌)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $refund_id 退款ID
	 * @param string $content 日誌內容
	 */
	private function refundLog($refund_id = 0, $content = '')
	{
		return model('app\api\model\wanlshop\RefundLog')->save([
			'user_id' => $this->auth->id,
			'refund_id' => $refund_id,
			'content' => $content
		]);
	}
	
	/**
	 * 查詢退款（方法內使用）
	 *
	 * @ApiSummary  (WanlShop 查詢退款)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $refund_id 退款ID
	 */
	private function getRefund($refund_id = 0)
	{
		$refund = model('app\api\model\wanlshop\Refund')
			->where(['id' => $refund_id, 'user_id' => $this->auth->id])
			->find();
		return  $refund ? $refund : ($this->error(__('返金情報が見つかりません')));
	}
	
}