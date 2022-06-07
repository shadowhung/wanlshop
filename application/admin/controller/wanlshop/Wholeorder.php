<?php
// 2020年2月17日22:05:38
namespace app\admin\controller\wanlshop;
use addons\wanlshop\library\WanlChat\WanlChat;
use app\common\controller\Backend;
use addons\wanlshop\library\Ehund; //快递100订阅

/**
 * 订单管理
 *
 * @icon fa fa-circle-o
 */
class Wholeorder extends Backend
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * Order模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Wholeorder;
        $this->shopid = -1;
        
        $kuaidi = new \app\admin\model\wanlshop\Kuaidi;
		$this->wanlchat = new WanlChat();
        $this->view->assign("kuaidiList", $kuaidi->field('name,code')->select());
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("statesList", $this->model->getStatesList());
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
        if ($this->request->isAjax()) {
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['user','shop','pay','ordergoods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','shop','pay','ordergoods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                
                $user_id = $row->getRelation('shop')->user_id;
                $row->puserid =  model('app\common\model\User')->where(['id' =>$user_id])->find();

                $row->getRelation('user')->visible(['id','username','nickname','avatar']);
                $row->getRelation('pay')->visible(['pay_no','price','order_price','freight_price','discount_price','actual_payment']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    
    
    /**
     * 详情
     */
    public function detail($id = null)
    {
        $row = $this->model->get($id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判断权限
        if ($row['shop_id'] != $this->shopid) {
            //$this->error(__('You have no permission'));
        }
        $row['address'] = model('app\admin\model\wanlshop\OrderAddress')
            ->where(['order_id' => $id, 'shop_id' => $row['shop_id']])
            ->order('isaddress desc')
            ->field('id,name,mobile,address,address_name')
            ->find();

		// 查询快递状态

		switch ($row['state']) {

			case 1:

				$express = [

					'context' => '付款后，即可将商品发出',

					'status' => '尚未付款',

					'time' => date('Y-m-s h:i:s', $row['createtime'])

				];

				break;

			case 2:

				$express = [

					'context' => '商家正在处理订单',

					'status' => '已付款',

					'time' => date('Y-m-s h:i:s', $row['paymenttime'])

				];

				break;

			default: // 获取物流

				$eData = model('app\api\model\wanlshop\KuaidiSub')

					->where(['express_no' => $row['express_no']])

					->find();

				$ybData = json_decode($eData['data'], true);

				if($ybData){

					$express = $ybData[0];

				}else{

					$express = [

						'status' => '已发货',

						'context' => '包裹正在等待快递小哥揽收~',

						'time' => date('Y-m-s h:i:s', $row['delivertime'])

					];

				}

		}

		$this->view->assign("kuaidi", $express);

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
	
	/**
	 * 快递查询
	 */
	public function relative($id = null)
	{
		$row = $this->model->get($id);
		if (!$row) {
			$this->error(__('No Results were found'));
		}
		// 判断权限
		if ($row['shop_id'] != $this->shopid) {
		    //$this->error(__('You have no permission'));
		}
		$data = model('app\admin\model\wanlshop\KuaidiSub')
			->where(['express_no' => $row['express_no']])
			->find();
		$data = json_decode($data['data'], true);
		$list = [];
		$week = array(
		    "0"=>"星期日",
		    "1"=>"星期一",
		    "2"=>"星期二",
		    "3"=>"星期三",
		    "4"=>"星期四",
		    "5"=>"星期五",
		    "6"=>"星期六"
		);
		if($data){
			foreach($data as $vo){
				$list[] = [
					'time' => strtotime($vo['time']),
					'status' => $vo['status'],
					'context' => $vo['context'],
					'week' => $week[date('w', strtotime($vo['time']))]
				];
			}
		}
		$this->view->assign("week", $week);
		$this->view->assign("list", $list);
		$this->view->assign("row", $row);
		return $this->view->fetch();
	}
	
    
    /**
     * 打印发货单
     */
    public function invoice($ids = null)
    {
        $row = $this->model->all($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        foreach ($row as $data) {
            // 判断权限
            if ($data['shop_id'] != $this->shopid) {
                //$this->error(__('You have no permission'));
            }
            $data['address'] = model('app\admin\model\wanlshop\OrderAddress')
                ->where(['order_id' => $data['id'], 'shop_id' => $data['shop_id']])
                ->order('isaddress desc')
                ->field('id,name,mobile,address,address_name')
                ->find();
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    
    /**
     * 发货 &批量发货
     */
    public function delivery($ids = null)
    {
        $data = [];
        $lists = [];
        $row = $this->model->all($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        foreach ($row as $vo) {
            if ($vo['shop_id'] != $this->shopid) {
                //$this->error(__('You have no permission'));
            }
            $vo['address'] = model('app\admin\model\wanlshop\OrderAddress')
                ->where(['order_id' => $vo['id'], 'shop_id' => $vo['shop_id']])
                ->order('isaddress desc')
                ->field('id,name,mobile,address,address_name')
                ->find();
            if ($vo['state'] == 2) {
                $lists[] = $vo;
            } else {
                $data[] = $vo;
            }
        }
        if ($this->request->isAjax()) {
            $request = $this->request->post();
            if (!array_key_exists("order", $request['row'])) {
                $this->success(__('没有发现可以发货订单~'));
            }

			if(!$this->wanlchat->isWsStart()){

				$this->error('平台未启动IM即时通讯服务，暂时不可以发货');

			}

            $config = get_addon_config('wanlshop');
            $ehund = new Ehund($config['kuaidi']['secretKey'], $config['ini']['appurl'].$config['kuaidi']['callbackUrl']);
            $order = [];
			foreach ($request['row']['order']['id'] as $key => $id) {
                $express_no = $request['row']['order']['express_no'][$key];
                $express_name = $request['row']['express_name'];
                $order[] = [
                    'id' => $id,
                    'express_name' => $express_name,
                    'express_no' => $express_no,
                    'delivertime' => time(),
                    'state' => 3
                ];
                // 订阅快递查询
                /*if ($config['kuaidi']['secretKey']) {
                    $returncode = $ehund->subScribe($express_name, $express_no);
                    if ($returncode['returnCode'] != 200) {
                        $this->error('快递订阅接口异常-'.$returncode['message']);
                    }
                    $express[] = [
                        'sign' => $ehund->sign($express_no),
                        'express_no' => $express_no,
                        'returncode' => $returncode['returnCode'],
                        'message' => $returncode['message']
                    ];
                }*/
				// 推送消息
				$this->pushOrder($id,'已发货');
            }
            $this->model->saveAll($order);
            // 写入快递订阅列表
            if ($config['kuaidi']['secretKey']) {
                //model('app\index\model\wanlshop\KuaidiSub')->saveAll($express);
            }
            $this->success();
        }
        $this->view->assign("lists", $lists); //可以发货
        $this->view->assign("data", $data);
        return $this->view->fetch();
    }
    
    /**
     * 评论管理
     */
    public function comment()
    {
        return $this->view->fetch('wanlshop/commentfront/index');
    }
	
	/**
	 * 订单推送消息（方法内使用）
	 * 
	 * @param string order_id 订单ID
	 * @param string state 状态
	 */
	private function pushOrder($order_id = 0, $state = '已发货')
	{
		$order = $this->model->get($order_id);
		$orderGoods = model('app\admin\model\wanlshop\OrderGoods')
			->where(['order_id' => $order_id])
			->select();
		$msgData = [];
		foreach ($orderGoods as $goods) {
			$msg = [
				'user_id' => $order['user_id'], // 推送目标用户
				'shop_id' => $order['shop_id'], 
				'title' => '您的订单'.$state, // 推送标题
				'image' => $goods['image'], // 推送图片
				'content' => '您购买的商品 '.(mb_strlen($goods['title'],'utf8') >= 25 ? mb_substr($goods['title'],0,25,'utf-8').'...' : $goods['title']).' '.$state, 
				'type' => 'order',  // 推送类型
				'modules' => 'order',  // 模块类型
				'modules_id' => $order_id,  // 模块ID
				'come' => '订单'.$order['order_no'] // 来自
			];
			$msgData[] = $msg;
			$this->wanlchat->send($order['user_id'], $msg);
		}
		$notice = model('app\admin\model\wanlshop\Notice')->saveAll($msgData);
	}
}
