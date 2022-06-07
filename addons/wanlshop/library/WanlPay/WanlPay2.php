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
 * WanlPay 多終端支付
 * @author 福建度虎科技有限公司 <wanlshop@i36k.com> 
 * @link http://www.wanlshop.com
 * 
 * @careful 未經版權所有權人書面許可，不得自行復制到第三方系統使用、二次開發、分支、復制和商業使用！
 * @creationtime  2020年8月7日23:46:12 - 2020年8月26日05:10:09
 * @lasttime -
 * @version V0.0.1 https://pay.yanda.net.cn/docs/2.x/overview
 **/
class WanlPay2
{
	private $type;
	private $method;
	private $code;
	
	public function __construct($type = '' ,$method = '', $code = '')
	{
	    $auth = Auth::instance(); // 方式
	    $this->type = $type;  // 類型
		$this->method = $method; // 方式
		$this->user_id = $auth->isLogin() ? $auth->id : 0; // 用戶ID
		$this->request = \think\Request::instance();
		$this->code = $code; // 小程序code
	}
    
    /**
	 * 支付
	 */
	public function pay($order_id)
	{
		if($this->user_id == 0){
			return ['code' => 10001 ,'msg' => '用戶ID不存在'];
		}
		// 獲取支付信息
		$pay = model('app\api\model\wanlshop\Pay')
			->where('order_id', 'in', $order_id)
			//->where('user_id', $this->user_id)
			->select();
    	// 交易號
        $pay_no = '';
		// 訂單號
		$order_no = [];
        // 付款金額
    	$wholesale_price = 0;
		foreach($pay as $row){
			// 總價格
			$wholesale_price += $row['wholesale_price'];
			// 訂單集
			$order_no[] = $row['order_no'];
			// 交易集
			$pay_no = $row['pay_no'];
		}
		//var_dump($wholesale_price);exit;
		// 標題
		$title = '商城訂單-' . $pay_no;
		// 支付列表
		$pay_list = [];
		// 訂單列表
		$order_list = [];
		
        // 支付方式
		if ($this->type == 'balance') {

			// 判斷金額

			$user = model('app\common\model\User')->get($this->user_id);

			if (!$user || $user['money'] < $wholesale_price) {

				return ['code' => 500 ,'msg' => '餘額不足本次支付'];

			}

		    $result = false;
			$balance_no = date('YmdHis') . rand(10000000,99999999);
            Db::startTrans();
			try {
				
				// 修改用戶金額
				if(count($order_no) == 1){
					$result = self::money(-$wholesale_price, $user['id'], "餘額支付訂單", 'pay', implode(",",$order_no));
				}else{
					$result = self::money(-$wholesale_price, $user['id'], "餘額合並支付訂單", 'pay', implode(",",$order_no));
				}
				if(isset($result['code'])&&$result['code'] == 500){
				    $result = false;
    			}
				Db::commit();
			} catch (Exception $e) {
			    Db::rollback();
			    return ['code' => 10002 ,'msg' => $e->getMessage()];
			}
			// 返回結果
    		if ($result !== false) {
                return ['code' => 200 ,'msg' => '成功', 'data' => []]; 
            } else {
                return ['code' => 10003 ,'msg' => '支付異常'];
            }
        // 支付寶支付、更新數據均在回調中執行
		} 
	}
	
	/**
	 * 支付回調
	 */
	public function notify()
	{
	    $wanlpay = Pay::{$this->type}($this->getConfig($this->type));
	    try{
	        $result = $wanlpay->verify();
	        // 查詢訂單是否存在
			$pay = model('app\api\model\wanlshop\Pay')
				->where(['pay_no' => $result['out_trade_no']])
				->select();
			if(!$pay){
			    return ['code' => 10001 ,'msg' => '網絡異常'];
			}
			// 支付類型
			$pay_type = 8;
			$user_id = 0;
			$order_list = [];
			$order_no = [];
	        $pay_list = [];
			// 總價格
	        $price = 0;
			foreach($pay as $row){
				$price += $row['price'];
				// 訂單集
				$order_no[] = $row['order_no'];
				$user_id = $row['user_id'];
			}
			
	        // -----------------------------判斷訂單是否合法-----------------------------
	        $config = get_addon_config('wanlshop');
	        // 支付寶
	        if ($this->type == 'alipay') {
	            // 判斷狀態
	            if (in_array($result['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
	                // 判斷金額
	                if($price != $result['total_amount']){
	                    return ['code' => 10002 ,'msg' => '支付金額不合法'];
	                }
	                // 判斷appid
	                if($config['sdk_alipay']['app_id'] != $result['app_id']){
	                    return ['code' => 10003 ,'msg' => 'APPID不合法'];
	                }
	            }else{
	                return ['code' => 500 ,'msg' => '支付回調失敗'];
	            }
	            // 回調支付
	            $pay_type = 2; // 支付類型:0=餘額支付,1=微信支付,2=支付寶支付
				$pay_name = '支付寶';
				$trade_no = $result['trade_no'];
	        } else if($this->type == 'wechat'){
	            // 判斷狀態
	            if ($result['result_code'] == 'SUCCESS') {
	                // 判斷金額
	                if($price != ($result['total_fee'] / 100)){
	                    return ['code' => 10002 ,'msg' => '支付金額不合法'];
	                }
	                // 判斷商家ID
	                if($config['sdk_qq']['mch_id'] != $result['mch_id']){
	                    return ['code' => 10004 ,'msg' => '商戶不合法'];
	                }
	                // H5微信支付
	                if($result['trade_type'] == 'MWEB'){
	                    if($config['sdk_qq']['gz_appid'] != $result['appid']){
	                       return ['code' => 10005 ,'msg' => '支付類型 '.$result['trade_type'] .' 不合法'];
	                    }
	                }
	                // 小程序支付
	                if($result['trade_type'] == 'JSAPI'){
	                    if($config['mp_weixin']['appid'] != $result['appid']){
	                        return ['code' => 10006 ,'msg' => '支付類型 '.$result['trade_type'] .' 不合法'];
	                    }
	                }
	                // App支付
	                if($result['trade_type'] == 'APP'){
	                    if($config['sdk_qq']['wx_appid'] != $result['appid']){
	                        return ['code' => 10007 ,'msg' => '支付類型 '.$result['trade_type'] .' 不合法'];    
	                    }
	                }
	            }else{
	                return ['code' => 500 ,'msg' => '支付回調失敗'];
	            }
	            // 回調支付
	            $pay_type = 1; // 支付類型:0=餘額支付,1=微信支付,2=支付寶支付
				$pay_name = '微信';
				$trade_no = $result['transaction_id'];
	        }
	        
	        // -----------------------------支付成功，修改訂單-----------------------------
			foreach($pay as $row){
				// 新增付款人數&新增銷量
				foreach(model('app\api\model\wanlshop\OrderGoods')->where('order_id',$row['order_id'])->select() as $goods){
					model('app\api\model\wanlshop\Goods')->where('id', $goods['goods_id'])->inc('payment')->inc('sales', $goods['number'])->update();
				}
				// 訂單列表
				$order_list[] = ['id' => $row['order_id'], 'state'  => 2, 'paymenttime' => time()];
				// 支付列表
				$pay_list[] = [
					'id' => $row['id'],
					'trade_no'  => $trade_no, // 第三方交易號
					'pay_type'  => $pay_type, // 支付類型:0=餘額支付,1=微信支付,2=支付寶支付
					'pay_state'  => 1, // 支付狀態 (支付回調):0=未支付,1=已支付,2=已退款
					'total_amount' => $price, // 總金額
					'actual_payment' => $row['price'], // 實際支付
					'notice'  => json_encode($result)
				];
			}
			// 更新支付列表
			model('app\api\model\wanlshop\Pay')->saveAll($pay_list);
			// 更新訂單列表
			model('app\api\model\wanlshop\Order')->saveAll($order_list);
			// 支付日誌
			model('app\common\model\MoneyLog')->create([
				'user_id' => $user_id, 
				'money' => -$price, // 操作金額
				'memo' => $pay_name.'支付訂單', // 備註
				'type' => 'pay', // 類型
				'service_ids' => implode(",",$order_no) // 業務ID
			]);
	        Log::debug('Alipay notify', $result->all());
	    } catch (\Exception $e) {
	        return ['code' => 10008 ,'msg' => $e->getMessage()]; 
	    }
	    // 返回給支付接口
	    return ['code' => 200 ,'msg' => $wanlpay->success()->send()]; 
	}
	
    /**
	 * 用戶充值
	 */
    public function recharge($price)
    {
        if($this->user_id == 0){
			return ['code' => 10001 ,'msg' => '用戶ID不存在'];
		}
		if($price <= 0){
		    return ['code' => 10002 ,'msg' => '充值金額不合法'];
		}
		// 充值訂單號
		$pay_no = date("Ymdhis") . sprintf("%08d", $this->user_id) . mt_rand(1000, 9999);
		// 支付標題
		$title = '充值-' . $pay_no;
		// 生成壹個訂單
		$order = \app\api\model\wanlshop\RechargeOrder::create([
            'orderid'   => $pay_no,
            'user_id'   => $this->user_id,
            'amount'    => $price,
            'payamount' => 0,
            'paytype'   => $this->type,
            'ip'        => $this->request->ip(),
            'useragent' => substr($this->request->server('HTTP_USER_AGENT'), 0, 255),
            'status'    => 'created'
        ]);
		// 獲取配置
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
                'out_trade_no' => $pay_no, // 訂單號
                'body' => $title, // 標題
                'total_fee' => $price * 100 //付款金額 單位分
            ];
            if($this->method == 'miniapp' || $this->method == 'mp'){
                // 獲取微信openid，前期版本僅可安全獲取，後續版本優化登錄邏輯
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
				    $third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
				    if(!$third){
						$third = model('app\api\model\wanlshop\Third');
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
                    return ['code' => 10003 ,'msg' => '獲取微信openid失敗，無法支付'];
                }
            }
            // 開始支付
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
    	// 蘋果支付
    	} else if($this->type == 'apple'){
    	    try{
        	    
            } catch (\Exception $e) {
                return ['code' => 10006 ,'msg' => $this->type.'：'.$e->getMessage()];
            }
    	}
    }
	
	/**
	 * 充值支付回調
	 */
	public function notify_recharge()
	{
	    $wanlpay = Pay::{$this->type}($this->getConfig($this->type));
        try{
            $result = $wanlpay->verify();
            // 查詢訂單是否存在
			$order = model('app\api\model\wanlshop\RechargeOrder')
			    ->where(['orderid' => $result['out_trade_no']])
			    ->find();
            if (!$order) {
                return ['code' => 10001 ,'msg' => '支付訂單不存在']; 
            }
			$memo = '';
			$trade_no = '';
            // -----------------------------判斷訂單是否合法-----------------------------
            $config = get_addon_config('wanlshop');
            // 支付寶
            if ($this->type == 'alipay') {
                // 判斷狀態
                if (in_array($result['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
                    // 判斷金額
                    if($order['amount'] != $result['total_amount']){
                        return ['code' => 10002 ,'msg' => '支付金額不合法'];
                    }
                    // 判斷appid
                    if($config['sdk_alipay']['app_id'] != $result['app_id']){
                        return ['code' => 10003 ,'msg' => 'APPID不合法'];
                    }
                }else{
                    return ['code' => 500 ,'msg' => '支付回調失敗'];
                }
				$memo = '支付寶餘額充值';
				$trade_no = $result['trade_no'];
            } else if($this->type == 'wechat'){
                // 判斷狀態
                if ($result['result_code'] == 'SUCCESS') {
                    // 判斷金額
                    if($order['amount'] != ($result['total_fee'] / 100)){
                        return ['code' => 10002 ,'msg' => '支付金額不合法'];
                    }
                    // 判斷商家ID
                    if($config['sdk_qq']['mch_id'] != $result['mch_id']){
                        return ['code' => 10004 ,'msg' => '商戶不合法'];
                    }
                    // H5微信支付
                    if($result['trade_type'] == 'MWEB'){
                        if($config['sdk_qq']['gz_appid'] != $result['appid']){
                           return ['code' => 10005 ,'msg' => '支付類型 '.$result['trade_type'] .' 不合法'];
                        }
                    }
                    // 小程序支付
                    if($result['trade_type'] == 'JSAPI'){
                        if($config['mp_weixin']['appid'] != $result['appid']){
                            return ['code' => 10006 ,'msg' => '支付類型 '.$result['trade_type'] .' 不合法'];
                        }
                    }
                    // App支付
                    if($result['trade_type'] == 'APP'){
                        if($config['sdk_qq']['wx_appid'] != $result['appid']){
                            return ['code' => 10007 ,'msg' => '支付類型 '.$result['trade_type'] .' 不合法'];    
                        }
                    }
                }else{
                    return ['code' => 500 ,'msg' => '支付回調失敗'];
                }
				$memo = '微信餘額充值';
				$trade_no = $result['transaction_id'];
            }
            // -----------------------------支付成功，修改訂單-----------------------------
			if ($order['status'] == 'created') {
				$order->memo = $trade_no;
			    $order->payamount = $order['amount']; // 上面已經判斷過金額，可以直接使用
                $order->paytime = time();
                $order->status = 'paid';
                $order->save();
                // 更新用戶金額
                self::money(+$order['amount'], $order['user_id'], $memo, 'recharge', $order['id']); 
            }
            Log::debug('Alipay notify', $result->all());
        } catch (\Exception $e) {
            return ['code' => 10008 ,'msg' => $e->getMessage()]; 
        }
        // 返回給支付接口
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
	 * 獲取配置
	 * @param string $type 支付類型
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
					'level' => 'info', // 建議生產環境等級調整為 info，開發環境為 debug
					'type' => 'single', // optional, 可選 daily.
					'max_file' => 30, // optional, 當 type 為 daily 時有效，默認 30 天
				],
				'http' => [ // optional
					'timeout' => 5.0,
					'connect_timeout' => 5.0
				],
				// 'mode' => 'dev', // optional,設置此參數，將進入沙箱模式
			];
		}else if($this->type == 'wechat'){
			$pay_config = [
				'appid' => $config['sdk_qq']['wx_appid'], // APP APPID
				'app_id' => $config['sdk_qq']['gz_appid'], // 公眾號 APPID
				'miniapp_id' => $config['mp_weixin']['appid'], // 小程序 APPID
				'mch_id' => $config['sdk_qq']['mch_id'],
				'key' => $config['sdk_qq']['key'],
				'notify_url' => $config['ini']['appurl'].$config['sdk_qq']['notify_url'],
				'log' => [ // optional
					'file'  => LOG_PATH.'wanlpay'.DS.$this->type.'-'.date("Y-m-d").'.log',
					'level' => 'info', // 建議生產環境等級調整為 info，開發環境為 debug
					'type' => 'single', // optional, 可選 daily.
					'max_file' => 30, // optional, 當 type 為 daily 時有效，默認 30 天
				],
				'http' => [ // optional
					'timeout' => 5.0,
					'connect_timeout' => 5.0,
					// 更多配置項請參考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
				],
				// 'mode' => 'dev',
			];
			if($config['sdk_qq']['pay_cert'] == 1){
				$pay_config['cert_client'] = ADDON_PATH.'wanlshop' .DS. 'certs' .DS. $this->type .DS. 'apiclient_cert.pem'; // optional, 退款，紅包等情況時需要用到
				$pay_config['cert_key'] = ADDON_PATH.'wanlshop' .DS. 'certs' .DS. $this->type .DS. 'apiclient_key.pem';// optional, 退款，紅包等情況時需要用到
			}
		}
		return $pay_config;
	}
	
	/**
	 * 變更會員餘額
	 * @param int    $money   餘額
	 * @param int    $user_id 會員ID
	 * @param string $memo    備註
	 * @param string $type    類型
	 * @param string $ids  	  業務ID
	 */
	public static function money($money, $user_id, $memo, $type = '', $ids = '')
	{
	    $user = model('app\common\model\User')->get($user_id);
	    if ($user && $money != 0) {
	        $before = $user->money;
			$after = function_exists('bcadd') ? bcadd($user->money, $money, 2) : $user->money + $money;
			//更新會員信息
			$user->save(['money' => $after]);
			//寫入日誌
			$row = model('app\common\model\MoneyLog')->create([
				'user_id' => $user_id, 
				'money' => $money, // 操作金額
				'before' => $before, // 原金額
				'after' => $after, // 增加後金額
				'memo' => $memo, // 備註
				'type' => $type, // 類型
				'service_ids' => $ids // 業務ID
			]);
			return $row;
	    }else{

			return ['code' => 500 ,'msg' => '變更金額失敗'];

		}
	}
}