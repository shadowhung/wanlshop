<?php
// 2020年2月17日22:05:38
namespace app\index\controller\wanlshop;
use addons\wanlshop\library\WanlChat\WanlChat;
use app\common\controller\Wanlshop;
use think\Db;
use addons\wanlshop\library\Ehund; //快遞100訂閱
use addons\wanlshop\library\WanlPay\WanlPay2;
/**
 * 訂單管理
 *
 * @icon fa fa-circle-o
 */
class Order extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * Order模型對象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\Order;
        $kuaidi = new \app\index\model\wanlshop\Kuaidi;
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
        //當前是否為關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['user','pay','ordergoods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','pay','ordergoods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {

                $row->getRelation('user')->visible(['id','username','nickname','avatar']);
                $row->getRelation('pay')->visible(['pay_no','price','order_price','freight_price','discount_price','actual_payment']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    
    
    
    public function postcurl($url,$data = null){		
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$output = curl_exec($ch);
    	curl_close($ch);
    	return 	$output=json_decode($output,true);			
	}
	
    /**
     * 壹鍵發貨
     */
    public function wholesale1($id = null)
    {
        $row = $this->model->get($id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷權限
        if ($row['shop_id'] != $this->shop->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isAjax()) {
            $address = model('app\index\model\wanlshop\OrderAddress')
            ->where(['order_id' => $id, 'shop_id' => $this->shop->id])
            ->order('isaddress desc')
            ->field('id,name,mobile,address,address_name')
            ->find();
            
            $data['name']         = $address['name'];
            $data['mobile']       = $address['mobile'];
            $data['address']      = $address['address'];
            $data['address_name'] = $address['address_name'];
            $data['order_no']     = $row['order_no'];
            $ff = $this->postcurl('https://xp.shopptw.com/api/index/kuaidi',$data);
            //var_dump($ff);exit;
            //var_dump($address);exit;
            
	        $user     = $this->auth->getUser();
	        
	        $password = $this->request->post('password');
	        //var_dump($user['paypass']);var_dump($password);exit;
	        if(empty($user['paypass'])){
	            $this->error('支払いパスワードを設定してください');
	        }
	        if($user['paypass'] != $password){
	            $this->error('間違った支払いパスワード');
	        }
            if ($row['wholesale_id'] == 0) {
                $this->error('卸売注文はワンクリックで発送できます');
            }
            if($row['is_wholesale'] == 1){
                $this->error('注文は卸売りされました');
            }
            $user = model('app\common\model\User')->get($row['user_id']);
            // 調用支付
			$wanlPay = new WanlPay2('balance', 'balance', null);
			$data = $wanlPay->pay($row['id']);
			if($data['code'] == 200){
			    $order[] = [
                    'id' => $row['id'],
                    'is_wholesale' => 1,
                    'state' => 3,
                    'delivertime' => time()
                ];
                $this->model->saveAll($order);
                $this->success();
			    // $this->success('ok', $data['data']);
			}else{
			    $this->error($data['msg']);
			}
        }
        $row['address'] = model('app\index\model\wanlshop\OrderAddress')
            ->where(['order_id' => $id, 'shop_id' => $this->shop->id])
            ->order('isaddress desc')
            ->field('id,name,mobile,address,address_name')
            ->find();
		// 查詢快遞狀態
		switch ($row['state']) {
			case 1:
				$express = [
					'context' => 'お支払い後、発送可能です',
					'status' => 'まだ支払われていません',
					'time' => date('Y-m-d H:i:s', $row['createtime'])
				];
				break;
			case 2:
				$express = [
					'context' => '販売者が注文を処理しています',
					'status' => '有料',
					'time' => date('Y-m-d H:i:s', $row['paymenttime'])
				];
				break;
			default: // 獲取物流
				$eData = model('app\api\model\wanlshop\KuaidiSub')
					->where(['express_no' => $row['express_no']])
					->find();
				$ybData = json_decode($eData['data'], true);
				if($ybData){
					$express = $ybData[0];
				}else{
				    $tex = 'ロジスティクス配送，期待される';
				    $time1 = date('H',$row['paymenttime']);$time2 = 259200;if($time1 >= 0 && $time1 < 7){$time2 = 259200;}else if($time1 >= 18 && $time1 < 24){$time2 = 259200+3600*24;}
                    $tex = $tex.date('Y-m-d', $row['paymenttime']+$time2).'サービス，受け取りまで辛抱強くお待ちください~';
				    
					$express = [
						'status' => '出荷済み',
						'context' => $tex,
						'time' => date('Y-m-d H:i:s', $row['delivertime'])
					];
				}
		}
		$this->view->assign("kuaidi", $express);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    
     /**
     * 詳情
     */
    public function detail1($id = null)
    {
        $row = $this->model->get($id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷權限
        if ($row['shop_id'] != $this->shop->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isAjax()) {
	        $user     = $this->auth->getUser();
	        
	        
	        $editprice = $this->request->post('editprice');
	       
	        
            if ($row['state'] != 1) {
                $this->error('注文の支払い後に価格を変更できます');
            }
            $payinfo = model('app\api\model\wanlshop\Pay')
			->where('order_id', 'in', $row['id'])
			->where('user_id', $row['user_id'])
			->find();
			//var_dump($payinfo['price']);exit;
            
            
			if($payinfo){
			    $order[] = [
                    'id' => $payinfo['id'],
                    'price' => $editprice
                ];
                model('app\api\model\wanlshop\Pay')->saveAll($order);
                $this->success();
			    // $this->success('ok', $data['data']);
			}else{
			    $this->error($data['msg']);
			}
        }
        
        $row['address'] = model('app\index\model\wanlshop\OrderAddress')
            ->where(['order_id' => $id, 'shop_id' => $this->shop->id])
            ->order('isaddress desc')
            ->field('id,name,mobile,address,address_name')
            ->find();

		// 查詢快遞狀態

		switch ($row['state']) {

			case 1:

				$express = [

					'context' => 'お支払い後、発送可能です',

					'status' => 'まだ支払われていません',

					'time' => date('Y-m-d H:i:s', $row['createtime'])

				];

				break;

			case 2:

				$express = [

					'context' => '販売者が注文を処理しています',

					'status' => '有料',

					'time' => date('Y-m-d H:i:s', $row['paymenttime'])

				];

				break;

			default: // 獲取物流

				$eData = model('app\api\model\wanlshop\KuaidiSub')

					->where(['express_no' => $row['express_no']])

					->find();

				$ybData = json_decode($eData['data'], true);

				if($ybData){

					$express = $ybData[0];

				}else{
				    $tex = 'ロジスティクス配送，期待される'; 
				    $time1 = date('H',$row['paymenttime']);$time2 = 259200;if($time1 >= 0 && $time1 < 7){$time2 = 259200;}else if($time1 >= 18 && $time1 < 24){$time2 = 259200+3600*24;}
                    $tex = $tex.date('Y-m-d', $row['paymenttime']+$time2).'サービス，受け取りまで辛抱強くお待ちください~';

					$express = [

						'status' => '出荷済み',

						'context' => $tex,

						'time' => date('Y-m-d H:i:s', $row['delivertime'])

					];

				}

		}

		$this->view->assign("kuaidi", $express);

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 壹鍵發貨
     */
    public function wholesale($ids = null)
    {
        $data = [];
        $lists = [];
        $row = $this->model->all($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $order = [];
        foreach ($row as $vo) {
            if ($vo['shop_id'] != $this->shop->id) {
                $this->error(__('You have no permission'));
            }
            if ($vo['wholesale_id'] == 0) {
                $this->error('卸売注文はワンクリックで発送できます');
            }
            $order[] = [
                'id' => $vo['id'],
                'is_wholesale' => 1
            ];
        }
        
        $this->model->saveAll($order);
        $this->success();
    }
    
    
    /**
     * 詳情
     */
    public function detail($id = null)
    {
        $row = $this->model->get($id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷權限
        if ($row['shop_id'] != $this->shop->id) {
            $this->error(__('You have no permission'));
        }
        $row['address'] = model('app\index\model\wanlshop\OrderAddress')
            ->where(['order_id' => $id, 'shop_id' => $this->shop->id])
            ->order('isaddress desc')
            ->field('id,name,mobile,address,address_name')
            ->find();

		// 查詢快遞狀態

		switch ($row['state']) {

			case 1:

				$express = [

					'context' => 'お支払い後、発送可能です',

					'status' => 'まだ支払われていません',

					'time' => date('Y-m-d H:i:s', $row['createtime'])

				];

				break;

			case 2:

				$express = [

					'context' => '販売者が注文を処理しています',

					'status' => '有料',

					'time' => date('Y-m-d H:i:s', $row['paymenttime'])

				];

				break;

			default: // 獲取物流

				$eData = model('app\api\model\wanlshop\KuaidiSub')

					->where(['express_no' => $row['express_no']])

					->find();

				$ybData = json_decode($eData['data'], true);

				if($ybData){

					$express = $ybData[0];

				}else{
				    
				    $tex = 'ロジスティクス配送，期待される';
				    $time1 = date('H',$row['paymenttime']);$time2 = 259200;if($time1 >= 0 && $time1 < 7){$time2 = 259200;}else if($time1 >= 18 && $time1 < 24){$time2 = 259200+3600*24;}
                    $tex = $tex.date('Y-m-d', $row['paymenttime']+$time2).'サービス，受け取りまで辛抱強くお待ちください~';

					$express = [

						'status' => '出荷済み',

						'context' => $tex,

						'time' => date('Y-m-d H:i:s', $row['delivertime'])

					];

				}

		}

		$this->view->assign("kuaidi", $express);

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
	
	/**
	 * 快遞查詢
	 */
	public function relative($id = null)
	{
		$row = $this->model->get($id);
		//var_dump($row);exit;
		if (!$row) {
			$this->error(__('No Results were found'));
		}
		// 判斷權限
		if ($row['shop_id'] != $this->shop->id) {
		    $this->error(__('You have no permission'));
		}
		$data = model('app\index\model\wanlshop\Kuaidi')
			->where(['code' => $row['express_name']])
			->find();
		//KuaidiSub
		$data = json_decode($data, true);
	    //var_dump($data);exit;
		$list = [];
		$week = array(
		    "0"=>"日曜日",
		    "1"=>"週の1",
		    "2"=>"火曜日",
		    "3"=>"水曜日",
		    "4"=>"木曜日",
		    "5"=>"金曜日",
		    "6"=>"土曜日"
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
		
		$address = model('app\index\model\wanlshop\OrderAddress')
            ->where(['order_id' => $id, 'shop_id' => $this->shop->id])
            ->order('isaddress desc')
            ->field('id,name,mobile,address,address_name')
            ->find();
            
        /*$data['name']         = $address['name'];
        $data['mobile']       = $address['mobile'];
        $data['address']      = $address['address'];
        $data['address_name'] = $address['address_name'];*/
        
        $address1 = explode('/',$address['address']);
        $address['rcity']      = isset($address1['1'])?$address1['1']:'';
        $address['rprovince']  = isset($address1['2'])?$address1['2']:'';
        $address['rdetailed']  = isset($address1['3'])?$address1['3']:'';;
        $address['order_no']  = $row['order_no'];
		
		$this->view->assign("data", $data);
		$this->view->assign("week", $week);
		$this->view->assign("list", $list);
		$this->view->assign("row", $row);
		$this->view->assign("address", $address);
		return $this->view->fetch();
	}
	
    
    /**
     * 打印發貨單
     */
    public function invoice($ids = null)
    {
        $row = $this->model->all($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        foreach ($row as $data) {
            // 判斷權限
            if ($data['shop_id'] != $this->shop->id) {
                $this->error(__('You have no permission'));
            }
            $data['address'] = model('app\index\model\wanlshop\OrderAddress')
                ->where(['order_id' => $data['id'], 'shop_id' => $this->shop->id])
                ->order('isaddress desc')
                ->field('id,name,mobile,address,address_name')
                ->find();
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    
    /**
     * 發貨 &批量發貨
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
            if ($vo['shop_id'] != $this->shop->id) {
                $this->error(__('You have no permission'));
            }
            if ($vo['wholesale_id'] != 0) {
                $this->error('卸売注文を削除してください');
            }
            $vo['address'] = model('app\index\model\wanlshop\OrderAddress')
                ->where(['order_id' => $vo['id'], 'shop_id' => $this->shop->id])
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
                $this->success(__('注文は発送できません~'));
            }

			if(!$this->wanlchat->isWsStart()){

				$this->error('プラットフォームがIMインスタントメッセージングサービスをアクティブ化しておらず、一時的に利用できません');

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
                // 訂閱快遞查詢
                /*if ($config['kuaidi']['secretKey']) {
                    $returncode = $ehund->subScribe($express_name, $express_no);
                    if ($returncode['returnCode'] != 200) {
                        $this->error('快遞訂閱接口異常-'.$returncode['message']);
                    }
                    $express[] = [
                        'sign' => $ehund->sign($express_no),
                        'express_no' => $express_no,
                        'returncode' => $returncode['returnCode'],
                        'message' => $returncode['message']
                    ];
                }*/
				// 推送消息
				$this->pushOrder($id,'出荷済み');
            }
            $this->model->saveAll($order);
            // 寫入快遞訂閱列表
            if ($config['kuaidi']['secretKey']) {
                //model('app\index\model\wanlshop\KuaidiSub')->saveAll($express);
            }
            $this->success();
        }
        $this->view->assign("lists", $lists); //可以發貨
        $this->view->assign("data", $data);
        return $this->view->fetch();
    }
    
    /**
     * 評論管理
     */
    public function comment()
    {
        return $this->view->fetch('wanlshop/comment/index');
    }
	
	/**
	 * 訂單推送消息（方法內使用）
	 * 
	 * @param string order_id 訂單ID
	 * @param string state 狀態
	 */
	private function pushOrder($order_id = 0, $state = '出荷済み')
	{
		$order = $this->model->get($order_id);
		$orderGoods = model('app\index\model\wanlshop\OrderGoods')
			->where(['order_id' => $order_id])
			->select();
		$msgData = [];
		foreach ($orderGoods as $goods) {
			$msg = [
				'user_id' => $order['user_id'], // 推送目標用戶
				'shop_id' => $this->shop->id, 
				'title' => 'ご注文'.$state, // 推送標題
				'image' => $goods['image'], // 推送圖片
				'content' => '購入した商品 '.(mb_strlen($goods['title'],'utf8') >= 25 ? mb_substr($goods['title'],0,25,'utf-8').'...' : $goods['title']).' '.$state, 
				'type' => 'order',  // 推送類型
				'modules' => 'order',  // 模塊類型
				'modules_id' => $order_id,  // 模塊ID
				'come' => '注文'.$order['order_no'] // 來自
			];
			$msgData[] = $msg;
			$this->wanlchat->send($order['user_id'], $msg);
		}
		$notice = model('app\index\model\wanlshop\Notice')->saveAll($msgData);
	}
}
