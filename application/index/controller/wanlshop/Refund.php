<?php
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use addons\wanlshop\library\WanlChat\WanlChat;
use think\Db;
use Exception;
/**
 * 訂單退款管理
 *
 * @icon fa fa-circle-o
 */
class Refund extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * Refund模型對象
     * @var \app\index\model\wanlshop\Refund
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\Refund;
		$this->wanlchat = new WanlChat();
        $this->view->assign("expresstypeList", $this->model->getExpresstypeList());
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("reasonList", $this->model->getReasonList());
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    
    /**
     * 查看
     */
    public function index()
    {
        //當前是否為關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果發送的來源是Selectpage，則轉發到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['order','pay','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();
    
            $list = $this->model
                    ->with(['order','pay','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
    
            foreach ($list as $row) {
                $row->getRelation('goods')->visible(['title','image']);
                $row->getRelation('order')->visible(['id']);
    			$row->getRelation('pay')->visible(['pay_no']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
        return $this->view->fetch();
    }
	
	/**
	 * 退款詳情
	 */
	public function detail($ids = null, $type = 0)
	{
		if($type == 1){
			$row = $this->model->get(['order_id' => $ids]);
		}else{
			$row = $this->model->get($ids);
		}
	    if (!$row) {
	        $this->error(__('No Results were found'));
	    }
		if ($row['shop_id'] !=$this->shop->id) {
		    $this->error(__('You have no permission'));
		}
		$row['images'] = explode(',', $row['images']);
		$row['ordergoods'] = model('app\index\model\wanlshop\OrderGoods')
			->where('id', 'in', $row['goods_ids'])
			// ->where('shop_id', $row['shop_id'])
			->select();
		$row['log'] = model('app\index\model\wanlshop\RefundLog')
			->where(['refund_id' => $ids])
			->order('createtime desc')
			->select();
	    $this->view->assign("row", $row);
		return $this->view->fetch();
	}
	
	/**
	 * 同意退款
	 */
	public function agree($ids = null)
	{
		$row = $this->model->get($ids);
		if (!$row) {
		    $this->error(__('No Results were found'));
		}
		if ($row['shop_id'] !=$this->shop->id) {
		    $this->error(__('You have no permission'));
		}
		if ($row['state'] == 2 || $row['state'] == 3 || $row['state'] == 4 || $row['state'] == 5) {
			$this->error(__('現在のステータス、動作していません'));
		}
		// 判斷金額
		// if(number_format($row['price'], 2) > number_format($row->pay->price, 2)){
		// 	$this->error(__('非法退款金額，金額超過訂單金額！！請拒絕退款！！'));
		// }
		$result = false;
		Db::startTrans();
		try {
			// 判斷退款類型
			if($row['type'] == 0){
				$refund_status = 3;
				$data['state'] = 4; // 退款完成
				$data['completetime'] = time(); // 完成退款 時間
				$content = '売り手は返金に同意します，'.$row['price'].'円購入者のアカウント残高への払い戻し';
				// 如果僅有壹個商品的訂單退款完成，同時關閉訂單
				$this->setRefundState($row['order_id']);
				// 查詢訂單是已確定收貨
				$order = model('app\index\model\wanlshop\Order')->get($row['order_id']);
				
				
				$shop  = model('app\index\model\wanlshop\Shop')->get($order['shop_id']);
				// 更新錢包
				// 1.此訂單如果已確認收貨扣商家
				// 2.此訂單沒有確認收貨，平臺退款	
				if($order['state'] == 4){
					// 扣商家$order['shop']['user_id']
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$row['price'], $shop['user_id'], '領収書を確認し、払い戻しに同意します', 'refund', $order['order_no']);

					// 退款給用戶
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '売り手は返金に同意します', 'refund', $order['order_no']);
					
					if($order['wholesale_id']!=0&&$order['is_wholesale']==1){
					    controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['wholesale_price'], $shop['user_id'], 'ワンクリック卸売、お支払いの返金', 'refund', $order['order_no']);
					}
				}else{
					//退款給用戶
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '売り手は返金に同意します', 'refund', $order['order_no']);
					if($order['wholesale_id']!=0&&$order['is_wholesale']==1){
					    controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['wholesale_price'], $shop['user_id'], 'ワンクリック卸売、お支払いの返金', 'refund', $order['order_no']);
					}
				}
				// 推送開始
				$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '払い戻しが完了しました');
			}else if($row['type'] == 1){
				$refund_status = 2;
				$data['state'] = 1; // 先同意退款，還需要買家繼續退貨
				$data['agreetime'] = time(); // 賣家同意 時間
				// 退貨地址
				$shopConfig = model('app\index\model\wanlshop\ShopConfig')
					->where(['shop_id' => $this->shop->id])
					->field('returnAddr,returnName,returnPhoneNum')
					->find();
				$content = '売り手は、申請書、差出人住所を返却することに同意します：'.$shopConfig['returnName'].'，'.$shopConfig['returnPhoneNum'].'，'.$shopConfig['returnAddr'];
				// 推送開始
				$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '売り手は返品に同意します');
			}else{
				$this->error(__('返金タイプが不正ですので、返金をお断りください！'));
			}
			// 更新商品狀態
			$this->setOrderGoodsState($refund_status, $row['goods_ids']);
			// 更新退款
			$result = $row->allowField(true)->save($data);
			// 寫入日誌
			$this->refundLog($row['user_id'], $ids, $content);
			Db::commit();
		} catch (ValidateException $e) {
		    Db::rollback();
		    $this->error($e->getMessage());
		} catch (PDOException $e) {
		    Db::rollback();
		    $this->error($e->getMessage());
		} catch (Exception $e) {
		    Db::rollback();
		    $this->error($e->getMessage());
		}
		if ($result !== false) {
		    $this->success();
		} else {
		    $this->error(__('No rows were updated'));
		}
	}
	
	/**
	 * 確認收貨
	 */
	public function receiving($ids = null)
	{
		$row = $this->model->get($ids);
		if (!$row) {
		    $this->error(__('No Results were found'));
		}
		if ($row['shop_id'] != $this->shop->id) {
		    $this->error(__('You have no permission'));
		}
		if ($row['state'] == 2 || $row['state'] == 3 || $row['state'] == 4 || $row['state'] == 5) {
			$this->error(__('現在のステータス、動作していません'));
		}
		$result = false;
		Db::startTrans();
		try {
			// 判斷退款類型
			if($row['type'] == 1){
				// 判斷金額
				if($row['price'] > $row->pay->price){
					$this->error(__('払い戻し金額が不正です。注文金額を超えています。 ！ 返金をお断りください！ ！'));
				}
			}else{
				$this->error(__('払い戻しの種類が不正です。払い戻しを拒否してください！'));
			}
			// 更新商品狀態
			$this->setOrderGoodsState(3, $row['goods_ids']);
			// 查詢訂單是已確定收貨
			$order = model('app\index\model\wanlshop\Order')->get($row['order_id']);
			$shop  = model('app\index\model\wanlshop\Shop')->get($order['shop_id']);
			// 更新錢包
			// 1.此訂單如果已確認收貨扣商家
			// 2.此訂單沒有確認收貨，平臺退款	
			if($order['state'] == 4){
				// 扣商家
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$row['price'], $shop['user_id'], '領収書を確認し、払い戻しに同意します', 'refund', $order['order_no']);

				// 退款給用戶
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '売り手は返金に同意します', 'refund', $order['order_no']);
				
				if($order['wholesale_id']!=0&&$order['is_wholesale']==1){
					   controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['wholesale_price'], $shop['user_id'], 'ワンクリック卸売、お支払いの返金', 'refund', $order['order_no']);
				}

				//後續版本推送訂購單
			}else{
				//退款給用戶
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '売り手は返金に同意します', 'refund', $order['order_no']);

                if($order['wholesale_id']!=0&&$order['is_wholesale']==1){
					   controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['wholesale_price'], $shop['user_id'], 'ワンクリック卸売、お支払いの返金', 'refund', $order['order_no']);
				}
				//後續版本推送訂購單
			}
			// 推送開始
			$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '払い戻しが完了しました');
			// 寫入日誌
			$this->refundLog($row['user_id'], $ids, '売り手は返品の受領を確認し、'.$row['price'].'円$購入者のアカウント残高への払い戻し');
			// 更新退款
			$result = $row->allowField(true)->save(['state' => 4,'completetime' => time()]);
			// 如果僅有壹個商品的訂單退款完成，同時關閉訂單
			$this->setRefundState($row['order_id']);
		    Db::commit();
		} catch (ValidateException $e) {
		    Db::rollback();
		    $this->error($e->getMessage());
		} catch (PDOException $e) {
		    Db::rollback();
		    $this->error($e->getMessage());
		} catch (Exception $e) {
		    Db::rollback();
		    $this->error($e->getMessage());
		}
		if ($result !== false) {
		    $this->success();
		} else {
		    $this->error(__('No rows were updated'));
		}
	}
	
	/**
	 * 拒絕退款
	 */
	public function refuse($ids = null)
	{
		$row = $this->model->get($ids);
		if (!$row) {
		    $this->error(__('No Results were found'));
		}
		if ($row['shop_id'] != $this->shop->id) {
		    $this->error(__('You have no permission'));
		}
		if ($row['state'] != 0) {
			$this->error(__('現在のステータス、動作していません'));
		}
		if ($this->request->isPost()) {
		    $params = $this->request->post("row/a");
		    if ($params) {
		        $result = false;
		        Db::startTrans();
		        try {
					$params['state'] = 2;
					// 寫入日誌
					$this->refundLog($row['user_id'], $row['id'], '売り手はあなたの返金リクエストを拒否しました、拒否の理由：'.$params['refuse_content']);
					// 更新商品狀態
					$this->setOrderGoodsState(5, $row['goods_ids']);
					// 更新訂單狀態
					$this->setRefundState($row['order_id']);
					// 推送開始
					$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '払い戻しリクエストが拒否されました');
					// 更新退款
					$result = $row->allowField(true)->save($params);
		            Db::commit();
		        } catch (ValidateException $e) {
		            Db::rollback();
		            $this->error($e->getMessage());
		        } catch (PDOException $e) {
		            Db::rollback();
		            $this->error($e->getMessage());
		        } catch (Exception $e) {
		            Db::rollback();
		            $this->error($e->getMessage());
		        }
		        if ($result !== false) {
		            $this->success();
		        } else {
		            $this->error(__('No rows were updated'));
		        }
		    }
		    $this->error(__('Parameter %s can not be empty', ''));
		}
		$this->view->assign("row", $row);
		return $this->view->fetch();
	}
	
	/**
	 * 推送退款消息（方法內使用）
	 *
	 * @param string refund_id 訂單ID
	 * @param string order_id 訂單ID
	 * @param string goods_id 訂單ID
	 * @param string title 標題
	 */
	private function pushRefund($refund_id = 0, $order_id = 0, $goods_id = 0, $title = '')
	{
		$order = model('app\index\model\wanlshop\Order')->get($order_id);
		$goods = model('app\index\model\wanlshop\OrderGoods')->get($goods_id);
		$msg = [
			'user_id' => $order['user_id'], // 推送目標用戶
			'shop_id' => $this->shop->id, 
			'title' => $title,  // 推送標題
			'image' => $goods['image'], // 推送圖片
			'content' => '払い戻しをリクエストしているアイテム '.(mb_strlen($goods['title'],'utf8') >= 25 ? mb_substr($goods['title'],0,25,'utf-8').'...' : $goods['title']).' '.$title, 
			'type' => 'order',  // 推送類型
			'modules' => 'refund',  // 模塊類型
			'modules_id' => $refund_id,  // 模塊ID
			'come' => '注文'.$order['order_no'] // 來自
		];
		$this->wanlchat->send($order['user_id'], $msg);
		$notice = model('app\index\model\wanlshop\Notice');
		$notice->data($msg);
		$notice->allowField(true)->save();
	}
	
	/**
	 * 修改訂單狀態（方法內使用）
	 *
	 * @ApiSummary  (WanlShop 修改訂單狀態)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 訂單ID
	 */
	private function setRefundState($order_id = 0)
	{
		$goods_count = model('app\index\model\wanlshop\OrderGoods')
			->where(['order_id' => $order_id])
			->count();
		if($goods_count == 1){
			model('app\index\model\wanlshop\Order')->save(['state'  => 7],['id' => $order_id]);
			return true;
		}
		return false;
	}
	
	/**
	 * 退款日誌（方法內使用）
	 *
	 * @ApiSummary  (WanlShop 退款日誌)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $user_id 用戶ID
	 * @param string $refund_id 退款ID
	 * @param string $content 日誌內容
	 */
	private function refundLog($user_id = 0, $refund_id = 0, $content = '')
	{
		return model('app\index\model\wanlshop\RefundLog')->allowField(true)->save([
			'shop_id' => $this->shop->id,
			'user_id' => $user_id,
			'refund_id' => $refund_id,
			'type' => 1,
			'content' => $content
		]);
	}
	
	/**
	 * 更新訂單商品狀態（方法內使用）
	 *
	 * @ApiSummary  (WanlShop 更新訂單商品狀態)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $status 狀態
	 * @param string $goods_id 商品ID
	 */
	private function setOrderGoodsState($status = 0, $goods_id = 0)
	{
		return model('app\index\model\wanlshop\OrderGoods')
			->save(['refund_status' => $status],['id' => $goods_id]);
	}
	
	
	
}
