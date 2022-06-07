<?php
namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use addons\wanlshop\library\WanlChat\WanlChat;
use think\Db;
use Exception;
/**
 * 订单退款管理
 *
 * @icon fa fa-circle-o
 */
class Wholerefund extends Backend
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * Refund模型对象
     * @var \app\admin\model\wanlshop\Wholerefund
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Wholerefund;
        $this->shopid = -1;
        
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
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
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
	 * 退款详情
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
		if ($row['shop_id'] !=$this->shopid) {
		    $this->error(__('You have no permission'));
		}
		$row['images'] = explode(',', $row['images']);
		$row['ordergoods'] = model('app\admin\model\wanlshop\OrderGoods')
			->where('id', 'in', $row['goods_ids'])
			// ->where('shop_id', $row['shop_id'])
			->select();
		$row['log'] = model('app\admin\model\wanlshop\RefundLog')
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
		if ($row['shop_id'] !=$this->shopid) {
		    $this->error(__('You have no permission'));
		}
		if ($row['state'] == 2 || $row['state'] == 3 || $row['state'] == 4 || $row['state'] == 5) {
			$this->error(__('当前状态，不可操作'));
		}
		// 判断金额
		// if(number_format($row['price'], 2) > number_format($row->pay->price, 2)){
		// 	$this->error(__('非法退款金额，金额超过订单金额！！请拒绝退款！！'));
		// }
		$result = false;
		Db::startTrans();
		try {
			// 判断退款类型
			if($row['type'] == 0){
				$refund_status = 3;
				$data['state'] = 4; // 退款完成
				$data['completetime'] = time(); // 完成退款 时间
				$content = '卖家同意退款，'.$row['price'].'元退款到买家账号余额';
				// 如果仅有一个商品的订单退款完成，同时关闭订单
				$this->setRefundState($row['order_id']);
				// 查询订单是已确定收货
				$order = model('app\admin\model\wanlshop\Wholerorder')->get($row['order_id']);
				// 更新钱包
				// 1.此订单如果已确认收货扣商家
				// 2.此订单没有确认收货，平台退款	
				if($order['state'] == 4){
					// 扣商家

					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$row['price'], $order['shop']['user_id'], '确认收货，同意退款', 'refund', $order['order_no']);

					// 退款给用户
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '卖家同意退款', 'refund', $order['order_no']);
				}else{
					//退款给用户
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '卖家同意退款', 'refund', $order['order_no']);
				}
				// 推送开始
				$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '退款已完成');
			}else if($row['type'] == 1){
				$refund_status = 2;
				$data['state'] = 1; // 先同意退款，还需要买家继续退货
				$data['agreetime'] = time(); // 卖家同意 时间
				// 退货地址
				$shopConfig = model('app\admin\model\wanlshop\ShopConfig')
					->where(['shop_id' => $this->shopid])
					->field('returnAddr,returnName,returnPhoneNum')
					->find();
				$content = '卖家同意退货申请，退货地址：'.$shopConfig['returnName'].'，'.$shopConfig['returnPhoneNum'].'，'.$shopConfig['returnAddr'];
				// 推送开始
				$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '卖家同意退货');
			}else{
				$this->error(__('非法退款类型，请拒绝退款！'));
			}
			// 更新商品状态
			$this->setOrderGoodsState($refund_status, $row['goods_ids']);
			// 更新退款
			$result = $row->allowField(true)->save($data);
			// 写入日志
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
	 * 确认收货
	 */
	public function receiving($ids = null)
	{
		$row = $this->model->get($ids);
		if (!$row) {
		    $this->error(__('No Results were found'));
		}
		if ($row['shop_id'] != $this->shopid) {
		    $this->error(__('You have no permission'));
		}
		if ($row['state'] == 2 || $row['state'] == 3 || $row['state'] == 4 || $row['state'] == 5) {
			$this->error(__('当前状态，不可操作'));
		}
		$result = false;
		Db::startTrans();
		try {
			// 判断退款类型
			if($row['type'] == 1){
				// 判断金额
				if($row['price'] > $row->pay->price){
					$this->error(__('非法退款金额，金额超过订单金额！！请拒绝退款！！'));
				}
			}else{
				$this->error(__('非法退款类型，请拒绝退款！'));
			}
			// 更新商品状态
			$this->setOrderGoodsState(3, $row['goods_ids']);
			// 查询订单是已确定收货
			$order = model('app\admin\model\wanlshop\Wholerorder')->get($row['order_id']);
			// 更新钱包
			// 1.此订单如果已确认收货扣商家
			// 2.此订单没有确认收货，平台退款	
			if($order['state'] == 4){
				// 扣商家
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$row['price'], $order['shop']['user_id'], '确认收货，同意退款', 'refund', $order['order_no']);

				// 退款给用户
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '卖家同意退款', 'refund', $order['order_no']);

				//后续版本推送订购单
			}else{
				//退款给用户
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '卖家同意退款', 'refund', $order['order_no']);

				//后续版本推送订购单
			}
			// 推送开始
			$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '退款已完成');
			// 写入日志
			$this->refundLog($row['user_id'], $ids, '卖家确认收到退货，并将'.$row['price'].'元退款到买家账号余额');
			// 更新退款
			$result = $row->allowField(true)->save(['state' => 4,'completetime' => time()]);
			// 如果仅有一个商品的订单退款完成，同时关闭订单
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
	 * 拒绝退款
	 */
	public function refuse($ids = null)
	{
		$row = $this->model->get($ids);
		if (!$row) {
		    $this->error(__('No Results were found'));
		}
		if ($row['shop_id'] != $this->shopid) {
		    $this->error(__('You have no permission'));
		}
		if ($row['state'] != 0) {
			$this->error(__('当前状态，不可操作'));
		}
		if ($this->request->isPost()) {
		    $params = $this->request->post("row/a");
		    if ($params) {
		        $result = false;
		        Db::startTrans();
		        try {
					$params['state'] = 2;
					// 写入日志
					$this->refundLog($row['user_id'], $row['id'], '卖家拒绝了您的退款申请，拒绝理由：'.$params['refuse_content']);
					// 更新商品状态
					$this->setOrderGoodsState(5, $row['goods_ids']);
					// 更新订单状态
					$this->setRefundState($row['order_id']);
					// 推送开始
					$this->pushRefund($row['id'], $row['order_id'], $row['goods_ids'], $title = '退款申请被拒绝');
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
	 * 推送退款消息（方法内使用）
	 *
	 * @param string refund_id 订单ID
	 * @param string order_id 订单ID
	 * @param string goods_id 订单ID
	 * @param string title 标题
	 */
	private function pushRefund($refund_id = 0, $order_id = 0, $goods_id = 0, $title = '')
	{
		$order = model('app\admin\model\wanlshop\Order')->get($order_id);
		$goods = model('app\admin\model\wanlshop\OrderGoods')->get($goods_id);
		$msg = [
			'user_id' => $order['user_id'], // 推送目标用户
			'shop_id' => $this->shopid, 
			'title' => $title,  // 推送标题
			'image' => $goods['image'], // 推送图片
			'content' => '您申请退款的商品 '.(mb_strlen($goods['title'],'utf8') >= 25 ? mb_substr($goods['title'],0,25,'utf-8').'...' : $goods['title']).' '.$title, 
			'type' => 'order',  // 推送类型
			'modules' => 'refund',  // 模块类型
			'modules_id' => $refund_id,  // 模块ID
			'come' => '订单'.$order['order_no'] // 来自
		];
		$this->wanlchat->send($order['user_id'], $msg);
		$notice = model('app\admin\model\wanlshop\Notice');
		$notice->data($msg);
		$notice->allowField(true)->save();
	}
	
	/**
	 * 修改订单状态（方法内使用）
	 *
	 * @ApiSummary  (WanlShop 修改订单状态)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 订单ID
	 */
	private function setRefundState($order_id = 0)
	{
		$goods_count = model('app\admin\model\wanlshop\OrderGoods')
			->where(['order_id' => $order_id])
			->count();
		if($goods_count == 1){
			model('app\admin\model\wanlshop\Order')->save(['state'  => 7],['id' => $order_id]);
			return true;
		}
		return false;
	}
	
	/**
	 * 退款日志（方法内使用）
	 *
	 * @ApiSummary  (WanlShop 退款日志)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $user_id 用户ID
	 * @param string $refund_id 退款ID
	 * @param string $content 日志内容
	 */
	private function refundLog($user_id = 0, $refund_id = 0, $content = '')
	{
		return model('app\admin\model\wanlshop\RefundLog')->allowField(true)->save([
			'shop_id' => $this->shopid,
			'user_id' => $user_id,
			'refund_id' => $refund_id,
			'type' => 1,
			'content' => $content
		]);
	}
	
	/**
	 * 更新订单商品状态（方法内使用）
	 *
	 * @ApiSummary  (WanlShop 更新订单商品状态)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $status 状态
	 * @param string $goods_id 商品ID
	 */
	private function setOrderGoodsState($status = 0, $goods_id = 0)
	{
		return model('app\admin\model\wanlshop\OrderGoods')
			->save(['refund_status' => $status],['id' => $goods_id]);
	}
	
	
	
}
