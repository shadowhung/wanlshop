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
            $addressApilt = explode('/',$address['address']);
            
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
			    
			    /*
    			    订单金额，变成冻结金额
    			*/
			    
			    
			    /*
			        这里调用物流API，订单传过去
			    */
			     $postData = [
    		        'orderId'=>$row['order_no'] ,
    		        'storeId'=>$this->shop->id,
    		        'sku' =>'test',
    		        'country'=>'US',
    		        "state"=>$addressApilt[1],
                    "city"=>$addressApilt[2],
                    "address"=>$address['address'],
                    "name"=>$address['name'],
                    "email"=>"kate@gmail.com",
                    "phone"=>$address['mobile']
    		    ];
    			$result = $this->pushShipping($postData);
    
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
        
        $trackList = json_decode( $this->getShippingTrack($row->express_no) ,true);
        $listArr = [];
		if(!empty($trackList['trackDetails'])){
		    if(!empty($trackList['trackDetails'][0]['shipmentProgressActivities'])){
		        $listArr = $trackList['trackDetails'][0]['shipmentProgressActivities'];
		    }
		}
		
	    
		
		$this->view->assign('track_list',$listArr);
		$this->view->assign("data", $data);
		$this->view->assign("week", $week);
		$this->view->assign("list", $list);
		$this->view->assign("row", $row);
		$this->view->assign("address", $address);
		return $this->view->fetch();
	}
	
	/*
	    查询物流跟踪
	*/
    private function getShippingTrack($express_no){

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.ups.com/track/api/Track/GetStatus?loc=en_US',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"Locale":"en_US","TrackingNumber":["'.$express_no.'"],"Requester":"wems_1z","returnToValue":""}',
          CURLOPT_HTTPHEADER => array(
            'authority: www.ups.com',
            'accept: application/json, text/plain, */*',
            'accept-language: zh-CN,zh;q=0.9',
            'cache-control: no-cache',
            'content-type: application/json',
            'cookie: X-CSRF-TOKEN=CfDJ8Jcj9GhlwkdBikuRYzfhrpJtH8-Qidz-reAJ4-6W1E0lLFgkLOx7qCRCnlHAqhEc6pPeTUMUSKlH78MtdCL5i_QoVGDw4avyTdtYcojNjr-99f5FwQKghuBi3OOEAC6UfuqJhtPWvU7j22uu2JiElO4; AKA_A2=A; bm_sz=C28170B30446DA67E07F21A18D56C1EF~YAAQRn+GfOsumEWBAQAAlx/7YhCzsr/eqTa0xa0gfFKoZlL9ZJ4t19Mb+Az44Dh8O9XE7Iz3kQrAZ4xjcaGVHab5cEgJGHwQQydjNPq8vR5KiNntuGXaoq27+1XNcYd+Jgc5FSjsgepXVLIgY6B3l/yo5PuWPL0fW5fa0psx2AQ5iMlNzk6wQKdtjZi1josHnQUuukE8ZJiFBPXD110eeD/8RUYXchgKfdZocGCBgHFSleXJH2dvqbYynxQ6IPf5JPdsmU/reHr1ktByHN4rg1qt4OwUrGw3crHXVMEmTE8=~4538691~3621171; at_check=true; AMCVS_036784BD57A8BB277F000101%40AdobeOrg=1; CONSENTMGR=consent:true%7Cts:1655223039448; mboxEdgeCluster=32; st_cur_page=st_track; _gcl_au=1.1.1527191245.1655223040; s_vnum=1656604800274%26vn%3D1; s_invisit=true; dayssincevisit_s=First%20Visit; s_cc=true; AMCV_036784BD57A8BB277F000101%40AdobeOrg=-2121179033%7CMCIDTS%7C19158%7CMCMID%7C42059923917648290454333107397664055633%7CMCAAMLH-1655827850%7C11%7CMCAAMB-1655827850%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCOPTOUT-1655230250s%7CNONE%7CMCCIDH%7C790187782%7CvVersion%7C5.3.0; aam_uuid=42496359071315585774360989276130969749; aam_cms=segments%3D22945447; akacd_RWASP-default-phased-release=3832675853~rv=90~id=01fc2aa83db3f0a0356ceb1643365c60; HASSEENNOTICE=TRUE; com.ups.ims.lasso.sDataLassoFeb19=0b54c69e886c427d9ced1251f0a24ced:CronxC/i2Khx+JqBFG1ECzl2VTGJOaZyjrBm24mrhmY=; sharedsession=f1c1bfbc-81c5-491c-8c32-7b3007982116:w; ups_language_preference=en_US; gig_canary_ver=13076-3-27587025; gig_canary=false; gig_bootstrap_3_iCVSE9Ao6y9HITzXCDEN85YkhAnYbAuW1a6LOUnRKPEcwU_QCjFz7q_a1qfN5Vgd=_gigya_ver4; .AspNetCore.Antiforgery.pKFBCrPAOmA=CfDJ8H1SCHo8oO5Ascce1J42d2Dq4QyP2yVRKAyLEbg8jDTmdfzGTjQM4kiSq6Ec6OSmgtD_zUFAIEn1g5v0sWMUUltoakcdsfzkj-h9jgyKIlb2Y5Ti0fnhlJlEu6l91Yw7ObtmkMq-Ez7wI8hziYBNlCw; DOA-XSRF-TOKEN=CfDJ8H1SCHo8oO5Ascce1J42d2AKOrDRQupz2bPZ51QhvnlCaAeWcZl6PdHCXu3Qf7iRHv_KTOmQ2vO9UQf2QN0IhsSMvH7gCb4CrtMlZRtX07zdfZ2SQHMR0Q6XbdPtwwmTS-tH3w5-Yh-oB6hBDgbZTsM; bm_sv=BB8EA38CBCDF1D1D2B42957B278E88A9~YAAQVi43F6mvV16BAQAAUCz9YhBmTH+WbD+VPg3vEUeQYYjCTvahclkW+9juyh3lslExmobZSZn/47oTJYekp9osgrq2C9VhUK/lMMWpGTdQiqxgT03fCp4N4aRQ/IrhizXGdiDYL9UYsJqqDbfSv15jQrPzg/jucXaHVRE/VwnhCwcAaujhWpaniucs9R/7MglkgX8uYS4m1Z8j0iVQMQ1dVJGrwiIPf4Fejwlpp1zC3OzfHOC+3mm87lwn~1; ak_bmsc=341A729AAEBD311C6FF1933832ED4F6C~000000000000000000000000000000~YAAQRn+GfNswmEWBAQAAo9X+YhBHc68Mr8CaaLYqtoYAF2OLtyXf+5zMY3fN84krG5zVMNuboE0pZTL0CHbWoZgd7PGVwc4zZDKYrJ49Z0BCVm87/FAhEsUWrivPEIuillJc33SjLtNKBLLyBkEyRALGeouW2Uw1Z/0HUcDpbocEdUSHa5o1E/YmebBUMygKoZkFXz09xv7mm0c45d/ociHZDTu5biru3xDvfx98/jTYyvVJhn3kI553+qwFQhK9MRepZeO3Q57y4rgbZp7xqhFxap9y2gPiZ9GjX9RraUopMwmmhyw/RkCzv5A9SIfacdvWPgvEG0TySnDcwQ4rU1b64/YpDw/GahLGkU9rDwwAgDdnQ3pEltqtoCZuXknUztue9bzE/M7lsiKIFc4k9fN185MYtJrY/cZ1nQVBcukgiJqVIE6YWUwlk6pzKysvIfymQ7381IfmbHXexpEiQ3KyFTrnRRazYXiOa9MuNo8aue7+VsNppW7hRg3WFVAoKmo=; _abck=03797465F7667210832A2B65469BCD54~0~YAAQRn+GfOQwmEWBAQAAHPX+YgjfebyLADRC5CP8u8X53CsmfmOqpozMKttcIvFn0bMsW3E/LBy+DH3LivPCwAvktEKdfQ3wKVe6emmNwN37+GDx8IQ5cAJHAFeDHnemgOc0gW0mI9C6GpP4Gc6tzzSjchp0ebZprchZFA7O+fhNGMx5Yml5fL/5B6X5vXjzptZybRlRpeZqGx40mwDdmweP8l+MeS0t74v+dgzFwZPYAuzVl4JDt6hNN4LBmhogKxq4/zesmJeF/WChR5kT9ARM5yXdGlg+56DxhGqxWFmqPxmmtE9dvSsnLUn5IuNyi3AjCRvEkHXbA4YCiIageR7t78HtySi9MV7bf6rphjLj2u4IzirRLWOS0MTQEHPTFDnL8tYUdMxjtK868R/c25zc/1mg0g==~-1~-1~-1; s_nr=1655223308293-New; dayssincevisit=1655223308294; X-XSRF-TOKEN-ST=CfDJ8Jcj9GhlwkdBikuRYzfhrpKQI2TTLg5owYL9NqxGhyQeRnrZmyH29kM4_s7HAmE2RKlT3w_BJjnPgKAsCQvNcxCCijM0RrQXcSM7MJ11ZFLm-T23pM3T5yTeMb_TvO4p7nDwY_2nSjPxN1xmd6wGsQA; mbox=session#4fecd1d3e95a421395a03f6b3e8edda9#1655225170|PC#4fecd1d3e95a421395a03f6b3e8edda9.32_0#1718468110; utag_main=v_id:018162fb35bf008b279f7c15e9900506f00230670086e$_sn:1$_se:26$_ss:0$_st:1655225109849$ses_id:1655223039426%3Bexp-session$_pn:13%3Bexp-session$fs_sample_user:undefined%3Bexp-session$vapi_domain:ups.com$_prevpage:ups%3Aus%3Aen%3Atrack%3Bexp-1655226908286$_prevpageid:tracking%2FtrackWeb%2Ftra(3det).html%3Bexp-1655226908286$dc_visit:1$dc_event:18%3Bexp-session$dc_region:ap-east-1%3Bexp-session; RT="z=1&dm=ups.com&si=bb8d9eea-bcc3-4c1e-85a1-cb435f9ff71b&ss=l4ed25qg&sl=7&tt=27nh&bcn=%2F%2F684d0d41.akstat.io%2F"; _abck=03797465F7667210832A2B65469BCD54~-1~YAAQRn+GfBkxmEWBAQAA97j/YgiTgwdfpa4TG/D2MiRaPdGOQe9T3fMeD3czxaXRLYCJddFHNgbZzTD+iInooMdOc1XPRhdmjrpKPIfA0bDN5ERcyngNwd1xeGOhlGuS04dDKVHivkppZpwT7uvCtqAIE7bbcFZ0/WUvzEXrAbQkeSGVW5EebSG5RciAcVhtTgzya7RexYMiL7z3GAkVrwX548yY+l8x4hD9+E66qa2xKLFVGzZO5eJl7X0MAPeGNvNGy+Eo6ZKCaw/20tVAa1PE3RCqdxTQhmp6wZ+T1vZxOIAlFl8FeON4+BYLfBVcdLPbFrEBCk8CPbSZFbqITQPwyhTiPrKvpNWxISpPivgEoTLGUTTfF3U6njSpBw5cgFgewa/6KK3cLPWKwMnCO0AnWB7DFg==~0~-1~-1',
            'origin: https://www.ups.com',
            'pragma: no-cache',
            'referer: https://www.ups.com/track?loc=en_US&tracknum=1Z0R41W70328240826&requester=WEMS_1Z/trackdetails',
            'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="102", "Google Chrome";v="102"',
            'sec-ch-ua-mobile: ?1',
            'sec-ch-ua-platform: "Android"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-origin',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
            'x-xsrf-token: CfDJ8Jcj9GhlwkdBikuRYzfhrpKQI2TTLg5owYL9NqxGhyQeRnrZmyH29kM4_s7HAmE2RKlT3w_BJjnPgKAsCQvNcxCCijM0RrQXcSM7MJ11ZFLm-T23pM3T5yTeMb_TvO4p7nDwY_2nSjPxN1xmd6wGsQA'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;

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
	
	/*
	    外部物流API
	*/
	private function pushShipping($postData=array()){

        $curl = curl_init();
        curl_setopt_array($curl,array(
            CURLOPT_URL=>'http://47.88.32.48:8000/api/trackingRecord/order?orderId&storeId&sku&country&state&city&address',
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_ENCODING=>'',
            CURLOPT_MAXREDIRS=>10,
            CURLOPT_TIMEOUT=>0,
            CURLOPT_FOLLOWLOCATION=>true,
            CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST=>'POST',
            CURLOPT_POSTFIELDS=>json_encode($postData),
            CURLOPT_HTTPHEADER=>array(
                'Content-Type:application/json'
            ),
        ));
        
        $response=curl_exec($curl);
        curl_close($curl);
        return $response;

	}
}
