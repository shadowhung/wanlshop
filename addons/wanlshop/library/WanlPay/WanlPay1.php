<?php
namespace addons\wanlshop\library\WanlPay;

use app\common\library\Auth;
use think\Db;
use think\Request;
use fast\Http;
use fast\Random;
use WanlPay\Yansongda\Pay;
use WanlPay\Yansongda\Log;


/**
 * 
 * WanlPay 多终端支付
 * @author 福建度虎科技有限公司 <wanlshop@i36k.com> 
 * @link http://www.wanlshop.com
 * 
 * @careful 未经版权所有权人书面许可，不得自行复制到第三方系统使用、二次开发、分支、复制和商业使用！
 * @creationtime  2020年8月7日23:46:12 - 2020年8月26日05:10:09
 * @lasttime -
 * @version V0.0.1 https://pay.yanda.net.cn/docs/2.x/overview
 **/
class WanlPay1
{
	private $type;
	private $method;
	private $code;
	
	public function __construct($type = '' ,$method = '', $code = '')
	{
	    $auth = Auth::instance(); // 方式
	    $this->type = $type;  // 类型
		$this->method = $method; // 方式
		$this->user_id = $auth->isLogin() ? $auth->id : 0; // 用户ID
		$this->request = \think\Request::instance();
		$this->code = $code; // 小程序code
	}
    
    /**
	 * 支付
	 */
	public function pay($order_id)
	{
		if($this->user_id == 0){
			return ['code' => 10001 ,'msg' => '用户ID不存在'];
		}
		// 获取支付信息
		$pay = model('app\api1\model\wanlshop\Pay')
			->where('order_id', 'in', $order_id)
			->where('user_id', $this->user_id)
			->select();
    	// 交易号
        $pay_no = '';
		// 订单号
		$order_no = [];
        // 付款金额
    	$price = 0;
		foreach($pay as $row){
			// 总价格
			$price += $row['price'];
			// 订单集
			$order_no[] = $row['order_no'];
			// 交易集
			$pay_no = $row['pay_no'];
		}
		// 标题
		$title = '商城订单-' . $pay_no;
		// 支付列表
		$pay_list = [];
		// 订单列表
		$order_list = [];
		
        // 支付方式
		if ($this->type == 'balance') {

			// 判断金额

			$user = model('app\common\model\User')->get($this->user_id);

			if (!$user || $user['money'] < $price) {

				return ['code' => 500 ,'msg' => '餘额不足本次支付'];

			}

		    $result = false;
			$balance_no = date('YmdHis') . rand(10000000,99999999);
            Db::startTrans();
			try {
				foreach($pay as $row){
					// 新增付款人数&新增销量
					foreach(model('app\api1\model\wanlshop\OrderGoods')->where('order_id',$row['order_id'])->select() as $goods){
						model('app\api1\model\wanlshop\Goods')->where('id', $goods['goods_id'])->inc('payment')->inc('sales', $goods['number'])->update();
					}
					// 订单列表
					$order_list[] = ['id' => $row['order_id'], 'state'  => 2, 'paymenttime' => time()];
					// 支付列表
					$pay_list[] = [
						'id' => $row['id'],
						'trade_no'  => $balance_no, // 第三方交易号
						'pay_type'  => 0, // 支付类型:0=餘额支付,1=微信支付,2=支付宝支付
						'pay_state'  => 1, // 支付状态 (支付回调):0=未支付,1=已支付,2=已退款
						'total_amount' => $price, // 总金额
						'actual_payment' => $row['price'], // 实际支付
						'notice'  => json_encode([
						    'type' => $this->type,
						    'user_id' => $user['id'],
							'trade_no' => $balance_no,
						    'out_trade_no' => $row['pay_no'],
							'amount' => $row['price'],
							'total_amount' => $price,
						    'order_id' => $row['order_id'],
						    'trade_type' => 'BALANCE',
						    'version' => '1.0.0'
						 ])
					];
				}
				// 更新支付列表
				$result = model('app\api1\model\wanlshop\Pay')->saveAll($pay_list);
				// 更新订单列表
				$result = model('app\api1\model\wanlshop\Order')->saveAll($order_list);
				// 修改用户金额
				if(count($order_no) == 1){
					$result = self::money(-$price, $user['id'], "餘额支付订单", 'pay', implode(",",$order_no));
				}else{
					$result = self::money(-$price, $user['id'], "餘额合并支付订单", 'pay', implode(",",$order_no));
				}
				if(isset($result['code'])&&$result['code'] == 500){
				    $result = false;
    			}
				Db::commit();
			} catch (Exception $e) {
			    Db::rollback();
			    return ['code' => 10002 ,'msg' => $e->getMessage()];
			}
			// 返回结果
    		if ($result !== false) {
                return ['code' => 200 ,'msg' => '成功', 'data' => []]; 
            } else {
                return ['code' => 10003 ,'msg' => '支付异常'];
            }
        // 支付宝支付、更新数据均在回调中执行
		} else if($this->type == 'alipay'){
		    $data = [
                'out_trade_no' => $pay_no, 
                'total_amount' => $price,
                'subject'      => $title
            ];
            try{
    		    $alipay = Pay::alipay($this->getConfig($this->type))->{$this->method}($data);
    		    if($this->method == 'app' || $this->method == 'wap'){
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $alipay->getContent()]; 
        	    }else{
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $alipay]; 
        	    }
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
                
            }
    	    
    	// 微信支付
    	} else if($this->type == 'wechat'){
    	    $data = [
                'out_trade_no' => $pay_no, // 订单号
                'body' => $title, // 标题
                'total_fee' => $price * 100 //付款金额 单位分
            ];
            if($this->method == 'miniapp' || $this->method == 'mp'){
                // 获取微信openid，前期版本仅可安全获取，后续版本优化登录逻辑
                $config = get_addon_config('wanlshop');
                $params = [
					'appid'      => $config['mp_weixin']['appid'],
					'secret'     => $config['mp_weixin']['appsecret'],
					'js_code'    => $this->code,
					'grant_type' => 'authorization_code'
				];
				$time = time();
				$result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
                if ($result['ret']) {
                    $json = (array)json_decode($result['msg'], true);
				    $third = model('app\api1\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
				    if(!$third){
						$third = model('app\api1\model\wanlshop\Third');
						// array_key_exists("unionid",$json)
				        if(isset($json['unionid'])){
							$third->unionid  = $json['unionid'];
							$third->openid  = $json['openid'];
						}else{
							$third->openid  = $json['openid'];
						}
                        $third->access_token  = $json['session_key'];
                        $third->expires_in  = 7776000;
                        $third->logintime  = $time;
                        $third->expiretime  = $time + 7776000;
				        $third->user_id  = $this->user_id;
                        $third->save();
				    }
                    $data['openid'] = $json['openid'];
                }else{
                    return ['code' => 10005 ,'msg' => '获取微信openid失败，无法支付'];
                }
            }
            // 开始支付
            try{
        	    $wechat = Pay::wechat($this->getConfig($this->type))->{$this->method}($data);
        	    if($this->method == 'app'){
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $wechat->getContent()]; 
        	    }else if($this->method == 'wap'){    
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $wechat->getTargetUrl()]; 
        	    }else{
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $wechat]; 
        	    }
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	// 百度支付
    	} else if($this->type == 'baidu'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
        // QQ支付
    	} else if($this->type == 'qq'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	// 苹果支付
    	} else if($this->type == 'apple'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	}
	}
	
	/**
	 * 支付回调
	 */
	public function notify()
	{
	    $wanlpay = Pay::{$this->type}($this->getConfig($this->type));
	    try{
	        $result = $wanlpay->verify();
	        // 查询订单是否存在
			$pay = model('app\api1\model\wanlshop\Pay')
				->where(['pay_no' => $result['out_trade_no']])
				->select();
			if(!$pay){
			    return ['code' => 10001 ,'msg' => '网络异常'];
			}
			// 支付类型
			$pay_type = 8;
			$user_id = 0;
			$order_list = [];
			$order_no = [];
	        $pay_list = [];
			// 总价格
	        $price = 0;
			foreach($pay as $row){
				$price += $row['price'];
				// 订单集
				$order_no[] = $row['order_no'];
				$user_id = $row['user_id'];
			}
			
	        // -----------------------------判断订单是否合法-----------------------------
	        $config = get_addon_config('wanlshop');
	        // 支付宝
	        if ($this->type == 'alipay') {
	            // 判断状态
	            if (in_array($result['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
	                // 判断金额
	                if($price != $result['total_amount']){
	                    return ['code' => 10002 ,'msg' => '支付金额不合法'];
	                }
	                // 判断appid
	                if($config['sdk_alipay']['app_id'] != $result['app_id']){
	                    return ['code' => 10003 ,'msg' => 'APPID不合法'];
	                }
	            }else{
	                return ['code' => 500 ,'msg' => '支付回调失败'];
	            }
	            // 回调支付
	            $pay_type = 2; // 支付类型:0=餘额支付,1=微信支付,2=支付宝支付
				$pay_name = '支付宝';
				$trade_no = $result['trade_no'];
	        } else if($this->type == 'wechat'){
	            // 判断状态
	            if ($result['result_code'] == 'SUCCESS') {
	                // 判断金额
	                if($price != ($result['total_fee'] / 100)){
	                    return ['code' => 10002 ,'msg' => '支付金额不合法'];
	                }
	                // 判断商家ID
	                if($config['sdk_qq']['mch_id'] != $result['mch_id']){
	                    return ['code' => 10004 ,'msg' => '商户不合法'];
	                }
	                // H5微信支付
	                if($result['trade_type'] == 'MWEB'){
	                    if($config['sdk_qq']['gz_appid'] != $result['appid']){
	                       return ['code' => 10005 ,'msg' => '支付类型 '.$result['trade_type'] .' 不合法'];
	                    }
	                }
	                // 小程序支付
	                if($result['trade_type'] == 'JSAPI'){
	                    if($config['mp_weixin']['appid'] != $result['appid']){
	                        return ['code' => 10006 ,'msg' => '支付类型 '.$result['trade_type'] .' 不合法'];
	                    }
	                }
	                // App支付
	                if($result['trade_type'] == 'APP'){
	                    if($config['sdk_qq']['wx_appid'] != $result['appid']){
	                        return ['code' => 10007 ,'msg' => '支付类型 '.$result['trade_type'] .' 不合法'];    
	                    }
	                }
	            }else{
	                return ['code' => 500 ,'msg' => '支付回调失败'];
	            }
	            // 回调支付
	            $pay_type = 1; // 支付类型:0=餘额支付,1=微信支付,2=支付宝支付
				$pay_name = '微信';
				$trade_no = $result['transaction_id'];
	        }
	        
	        // -----------------------------支付成功，修改订单-----------------------------
			foreach($pay as $row){
				// 新增付款人数&新增销量
				foreach(model('app\api1\model\wanlshop\OrderGoods')->where('order_id',$row['order_id'])->select() as $goods){
					model('app\api1\model\wanlshop\Goods')->where('id', $goods['goods_id'])->inc('payment')->inc('sales', $goods['number'])->update();
				}
				// 订单列表
				$order_list[] = ['id' => $row['order_id'], 'state'  => 2, 'paymenttime' => time()];
				// 支付列表
				$pay_list[] = [
					'id' => $row['id'],
					'trade_no'  => $trade_no, // 第三方交易号
					'pay_type'  => $pay_type, // 支付类型:0=餘额支付,1=微信支付,2=支付宝支付
					'pay_state'  => 1, // 支付状态 (支付回调):0=未支付,1=已支付,2=已退款
					'total_amount' => $price, // 总金额
					'actual_payment' => $row['price'], // 实际支付
					'notice'  => json_encode($result)
				];
			}
			// 更新支付列表
			model('app\api1\model\wanlshop\Pay')->saveAll($pay_list);
			// 更新订单列表
			model('app\api1\model\wanlshop\Order')->saveAll($order_list);
			// 支付日志
			model('app\common\model\MoneyLog')->create([
				'user_id' => $user_id, 
				'money' => -$price, // 操作金额
				'memo' => $pay_name.'支付订单', // 备注
				'type' => 'pay', // 类型
				'service_ids' => implode(",",$order_no) // 业务ID
			]);
	        Log::debug('Alipay notify', $result->all());
	    } catch (\Exception $e) {
	        return ['code' => 10008 ,'msg' => $e->getMessage()]; 
	    }
	    // 返回给支付接口
	    return ['code' => 200 ,'msg' => $wanlpay->success()->send()]; 
	}
	
    /**
	 * 用户充值
	 */
    public function recharge($price)
    {
        if($this->user_id == 0){
			return ['code' => 10001 ,'msg' => '用户ID不存在'];
		}
		if($price <= 0){
		    return ['code' => 10002 ,'msg' => '充值金额不合法'];
		}
		// 充值订单号
		$pay_no = date("Ymdhis") . sprintf("%08d", $this->user_id) . mt_rand(1000, 9999);
		// 支付标题
		$title = '充值-' . $pay_no;
		// 生成一个订单
		$order = \app\api1\model\wanlshop\RechargeOrder::create([
            'orderid'   => $pay_no,
            'user_id'   => $this->user_id,
            'amount'    => $price,
            'payamount' => 0,
            'paytype'   => $this->type,
            'ip'        => $this->request->ip(),
            'useragent' => substr($this->request->server('HTTP_USER_AGENT'), 0, 255),
            'status'    => 'created'
        ]);
		// 获取配置
		$payConfig = $this->getConfig($this->type);
		$payConfig['notify_url'] = str_replace("notify", "notify_recharge", $payConfig['notify_url']);
		if($this->type == 'alipay'){
		    $data = [
                'out_trade_no' => $pay_no, 
                'total_amount' => $price,
                'subject'      => $title
            ];
            try{
    		    $alipay = Pay::alipay($payConfig)->{$this->method}($data);
    		    if($this->method == 'app' || $this->method == 'wap'){
    		        return ['code' => 200 ,'msg' => '成功', 'data' => $alipay->getContent()]; 
        	    }else{
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $alipay]; 
        	    }
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	    
    	// 微信支付
    	} else if($this->type == 'wechat'){
    	    $data = [
                'out_trade_no' => $pay_no, // 订单号
                'body' => $title, // 标题
                'total_fee' => $price * 100 //付款金额 单位分
            ];
            if($this->method == 'miniapp' || $this->method == 'mp'){
                // 获取微信openid，前期版本仅可安全获取，后续版本优化登录逻辑
                $config = get_addon_config('wanlshop');
                $params = [
					'appid'      => $config['mp_weixin']['appid'],
					'secret'     => $config['mp_weixin']['appsecret'],
					'js_code'    => $this->code,
					'grant_type' => 'authorization_code'
				];
				$time = time();
				$result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
                if ($result['ret']) {
                    $json = (array)json_decode($result['msg'], true);
				    $third = model('app\api1\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
				    if(!$third){
						$third = model('app\api1\model\wanlshop\Third');
				        if(isset($json['unionid'])){
							$third->unionid  = $json['unionid'];
							$third->openid  = $json['openid'];
						}else{
							$third->openid  = $json['openid'];
						}
                        $third->access_token  = $json['session_key'];
                        $third->expires_in  = 7776000;
                        $third->logintime  = $time;
                        $third->expiretime  = $time + 7776000;
				        $third->user_id  = $this->user_id;
                        $third->save();
				    }
                    $data['openid'] = $json['openid'];
                }else{
                    return ['code' => 10003 ,'msg' => '获取微信openid失败，无法支付'];
                }
            }
            // 开始支付
            try{
        	    $wechat = Pay::wechat($payConfig)->{$this->method}($data);
        	    if($this->method == 'app'){
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $wechat->getContent()];
        	    }else if($this->method == 'wap'){    
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $wechat->getTargetUrl()];
        	    }else{
        	        return ['code' => 200 ,'msg' => '成功', 'data' => $wechat];
        	    }
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	// 百度支付
    	} else if($this->type == 'baidu'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
        // QQ支付
    	} else if($this->type == 'qq'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	// 苹果支付
    	} else if($this->type == 'apple'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	}
    }
	
	/**
	 * 充值支付回调
	 */
	public function notify_recharge()
	{
	    $wanlpay = Pay::{$this->type}($this->getConfig($this->type));
        try{
            $result = $wanlpay->verify();
            // 查询订单是否存在
			$order = model('app\api1\model\wanlshop\RechargeOrder')
			    ->where(['orderid' => $result['out_trade_no']])
			    ->find();
            if (!$order) {
                return ['code' => 10001 ,'msg' => '支付订单不存在']; 
            }
			$memo = '';
			$trade_no = '';
            // -----------------------------判断订单是否合法-----------------------------
            $config = get_addon_config('wanlshop');
            // 支付宝
            if ($this->type == 'alipay') {
                // 判断状态
                if (in_array($result['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
                    // 判断金额
                    if($order['amount'] != $result['total_amount']){
                        return ['code' => 10002 ,'msg' => '支付金额不合法'];
                    }
                    // 判断appid
                    if($config['sdk_alipay']['app_id'] != $result['app_id']){
                        return ['code' => 10003 ,'msg' => 'APPID不合法'];
                    }
                }else{
                    return ['code' => 500 ,'msg' => '支付回调失败'];
                }
				$memo = '支付宝餘额充值';
				$trade_no = $result['trade_no'];
            } else if($this->type == 'wechat'){
                // 判断状态
                if ($result['result_code'] == 'SUCCESS') {
                    // 判断金额
                    if($order['amount'] != ($result['total_fee'] / 100)){
                        return ['code' => 10002 ,'msg' => '支付金额不合法'];
                    }
                    // 判断商家ID
                    if($config['sdk_qq']['mch_id'] != $result['mch_id']){
                        return ['code' => 10004 ,'msg' => '商户不合法'];
                    }
                    // H5微信支付
                    if($result['trade_type'] == 'MWEB'){
                        if($config['sdk_qq']['gz_appid'] != $result['appid']){
                           return ['code' => 10005 ,'msg' => '支付类型 '.$result['trade_type'] .' 不合法'];
                        }
                    }
                    // 小程序支付
                    if($result['trade_type'] == 'JSAPI'){
                        if($config['mp_weixin']['appid'] != $result['appid']){
                            return ['code' => 10006 ,'msg' => '支付类型 '.$result['trade_type'] .' 不合法'];
                        }
                    }
                    // App支付
                    if($result['trade_type'] == 'APP'){
                        if($config['sdk_qq']['wx_appid'] != $result['appid']){
                            return ['code' => 10007 ,'msg' => '支付类型 '.$result['trade_type'] .' 不合法'];    
                        }
                    }
                }else{
                    return ['code' => 500 ,'msg' => '支付回调失败'];
                }
				$memo = '微信餘额充值';
				$trade_no = $result['transaction_id'];
            }
            // -----------------------------支付成功，修改订单-----------------------------
			if ($order['status'] == 'created') {
				$order->memo = $trade_no;
			    $order->payamount = $order['amount']; // 上面已经判断过金额，可以直接使用
                $order->paytime = time();
                $order->status = 'paid';
                $order->save();
                // 更新用户金额
                self::money(+$order['amount'], $order['user_id'], $memo, 'recharge', $order['id']); 
            }
            Log::debug('Alipay notify', $result->all());
        } catch (\Exception $e) {
            return ['code' => 10008 ,'msg' => $e->getMessage()]; 
        }
        // 返回给支付接口
        return ['code' => 200 ,'msg' => $wanlpay->success()->send()];
	}
	
	/**
	 * 支付成功
	 */
	public function return()
	{
	    $wanlpay = Pay::{$this->type}($this->getConfig($this->type));
	    try{
	        return $wanlpay->verify();
	    } catch (\Exception $e) {
	        return __($e->getMessage());
	    }
	}
	
	/**
	 * 获取配置
	 * @param string $type 支付类型
	 * @return array|mixed
	 */
	public function getConfig()
	{
		$config = get_addon_config('wanlshop');
		
		$pay_config = [];
		if($this->type == 'alipay'){
			$pay_config = [
				'app_id' => $config['sdk_alipay']['app_id'],
				'notify_url' => $config['ini']['appurl'].$config['sdk_alipay']['notify_url'],
				'return_url' => $config['ini']['appurl'].$config['sdk_alipay']['return_url'],
				'ali_public_key' => $config['sdk_alipay']['ali_public_key'],
				'private_key' => $config['sdk_alipay']['private_key'],
				'log' => [ // optional
					'file'  => LOG_PATH.'wanlpay'.DS.$this->type.'-'.date("Y-m-d").'.log',
					'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
					'type' => 'single', // optional, 可选 daily.
					'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
				],
				'http' => [ // optional
					'timeout' => 5.0,
					'connect_timeout' => 5.0
				],
				// 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
			];
		}else if($this->type == 'wechat'){
			$pay_config = [
				'appid' => $config['sdk_qq']['wx_appid'], // APP APPID
				'app_id' => $config['sdk_qq']['gz_appid'], // 公众号 APPID
				'miniapp_id' => $config['mp_weixin']['appid'], // 小程序 APPID
				'mch_id' => $config['sdk_qq']['mch_id'],
				'key' => $config['sdk_qq']['key'],
				'notify_url' => $config['ini']['appurl'].$config['sdk_qq']['notify_url'],
				'log' => [ // optional
					'file'  => LOG_PATH.'wanlpay'.DS.$this->type.'-'.date("Y-m-d").'.log',
					'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
					'type' => 'single', // optional, 可选 daily.
					'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
				],
				'http' => [ // optional
					'timeout' => 5.0,
					'connect_timeout' => 5.0,
					// 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
				],
				// 'mode' => 'dev',
			];
			if($config['sdk_qq']['pay_cert'] == 1){
				$pay_config['cert_client'] = ADDON_PATH.'wanlshop' .DS. 'certs' .DS. $this->type .DS. 'apiclient_cert.pem'; // optional, 退款，红包等情况时需要用到
				$pay_config['cert_key'] = ADDON_PATH.'wanlshop' .DS. 'certs' .DS. $this->type .DS. 'apiclient_key.pem';// optional, 退款，红包等情况时需要用到
			}
		}
		return $pay_config;
	}
	
	/**
	 * 变更会员餘额
	 * @param int    $money   餘额
	 * @param int    $user_id 会员ID
	 * @param string $memo    备注
	 * @param string $type    类型
	 * @param string $ids  	  业务ID
	 */
	public static function money($money, $user_id, $memo, $type = '', $ids = '')
	{
	    $user = model('app\common\model\User')->get($user_id);
	    if ($user && $money != 0) {
	        $before = $user->money;
			$after = function_exists('bcadd') ? bcadd($user->money, $money, 2) : $user->money + $money;
			//更新会员信息
			$user->save(['money' => $after]);
			//写入日志
			$row = model('app\common\model\MoneyLog')->create([
				'user_id' => $user_id, 
				'money' => $money, // 操作金额
				'before' => $before, // 原金额
				'after' => $after, // 增加后金额
				'memo' => $memo, // 备注
				'type' => $type, // 类型
				'service_ids' => $ids // 业务ID
			]);
			return $row;
	    }else{

			return ['code' => 500 ,'msg' => '变更金额失败'];

		}
	}
}