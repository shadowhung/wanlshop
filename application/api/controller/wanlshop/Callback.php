<?php
namespace app\api\controller\wanlshop;

use think\View;
use app\common\controller\Api;
use addons\wanlshop\library\WanlChat\WanlChat;
use addons\wanlshop\library\WanlPay\WanlPay;

/**
 * WanlShop 回調接口
 */
class Callback extends Api
{
    protected $noNeedLogin = ['*'];
	protected $noNeedRight = ['*'];
    
	
	public function _initialize()
	{
	    parent::_initialize();
	    
	}
	/**
	 * 接收快遞100推送消息
	 *
	 * @ApiSummary  (WanlShop 快遞接口-接收快遞100推送消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $status 物流狀態 polling:監控中，shutdown:結束，abort:中止，updateall：重新推送
	 * @param array $lastResult 最新物流動態
	 */
	public function kuaidi()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $kuaidi = model('app\api\model\wanlshop\KuaidiSub');
			$post = $this->request->post();
			// 接收消息
			try {
    			$param = json_decode($post["param"], true);
    			$status = $param['status']; // 狀態 polling:監控中，shutdown:結束，abort:中止，updateall：重新推送
    			$message = $param['lastResult']['message']; // 消息體
    			$state = $param['lastResult']['state']; // 快遞單當前狀態，包括0在途，1攬收，2疑難，3簽收，4退簽，5派件，6退回，7轉投
    			$ischeck = $param['lastResult']['ischeck']; // 是否簽收標記
    			$nu = $param['lastResult']['nu']; // 快遞單號
    			$com = $param['lastResult']['com']; // 快遞公司編碼
    			$data = $param['lastResult']['data']; // 數組，包含多個對象，每個對象字段如展開所示
    			// 查詢快遞是否存在
    		    $express = $kuaidi->get(['express_no' => $nu]);
    			if($express){
    			    // 判斷來源
    			    if($post["sign"] != strtoupper(md5($post["param"].$express['sign']))){
    			        return json(["result" => false, "returnCode" => "405", "message" => "コードエラーを確認してください"]);
    			    }
    			    // 更新數據
                    $express->message = $message;
                    $express->status = $status;
                    $express->state = $state;
                    $express->ischeck = $ischeck;
                    $express->com = $com;
                    $express->data = json_encode($data);
                    $express->save();
                    // 判斷更新狀態
        			if($express){
        			    return json(["result" => true, "returnCode" => "200", "message" => "正常に受信されました"]);
        			} 
    			}else{
    			    return json(["result" => false, "returnCode" => "404", "message" => "宅配便の追跡番号が存在しません"]);
    			}
			} catch (Exception $e) {
                return json(["result" => false, "returnCode" => "500", "message" => "サーバーエラー"]);
            }
		}
		return json(["result" => false, "returnCode" => "500", "message" => "異常な訪問"]);
	}
	
	/**
	 * 推流狀態回調
	 *
	 * @ApiSummary  (WanlShop 直播接口-推流狀態回調)
	 * @ApiMethod   (POST)
	 *
	 * @param string $action 回調狀態 publish / publish_done
	 * @param string $ip 回調地址ip
	 * @param string $id 推流流名
	 * @param string $app 推流域名
	 * @param string $appname 推流app名
	 * @param string $time timestamp
	 * @param string $usrargs 用戶參數
	 * @param string $node 內部節點ip
	 */
	public function push($id, $action)
	{
		$row = model('app\api\model\wanlshop\Live')->get(['liveid' => $id]);
		$find = model('app\api\model\wanlshop\Find');
		if($row){
			if($action == 'publish'){
				$this->sendLiveGroup($id, ['type' => 'publish']);
				$row->save(['state' => 1]);
				// 避免多次推流，檢查是否存在多個
				$count = $find->where('live_id', $row['id'])->count();
				// 發布動態
				if($count == 0){
					// 關聯商品
					$goods = model('app\api\model\wanlshop\Goods')
						->where('id','in',$row['goods_ids'])

						->limit(2)
						->select();
					$image = [$row['image']];
					foreach ($goods as $vo) {
						$image[] = $vo['image'];
					}
					$find->save([
						'shop_id' => $row['shop_id'],
						'type' => 'live',
						'goods_ids' => $row['goods_ids'],
						'live_id' => $row['id'],
						'content' => $row['content'],
						'images' => implode(',', $image)
					]);
				}
			}else if($action == 'publish_done'){
				$this->sendLiveGroup($id, ['type' => 'publish_done']);
				$row->save(['state' => 2]);
			}
		}else{
			$this->error(__('関連するプッシュストリームが見つかりません'));
		}
		
	}
	
	/**
	 * 錄制文件回調
	 *
	 * @ApiSummary  (WanlShop 直播接口-錄制文件回調)
	 * @ApiMethod   (POST)
	 *
	 * @param string $domain 回調狀態 publish / publish_done
	 * @param string $app 回調地址ip
	 * @param string $stream 推流流名
	 * ------------------------------------
	 * @param string $event record_started/record_paused/record_resumed
	 *-------------------------------------
	 * @param string $uri 推流域名
	 * @param string $duration 推流app名
	 * @param string $start_time timestamp
	 * @param string $stop_time 用戶參數
	 */
	public function record()
	{
		if ($this->request->isPost()) {
			$event = $this->request->post('event');
			$stream = $this->request->post('stream');
			$uri = $this->request->post('uri');
			
		    if($event == 'record_started'){
			    // 錄制開始
    		}else if($event == 'record_paused'){
    			// 錄制暫停
    		}else if($event == 'record_resumed'){
    			// 錄制繼續
    		}else{
    			// 錄制成功
    			if($uri && $stream){
    				$config = get_addon_config('wanlshop');
    				$live = model('app\api\model\wanlshop\Live');
    				$live->save(['recordurl' => $config['live']['liveCnd'].'/'.$uri],['liveid' => $stream]);
    			}else{
    				$this->error(__('録音に失敗しました'));
    			}
    		}
		}
		$this->error(__('異常な訪問'));
	}
	
	/**
	 * 安全審核
	 *
	 * @ApiSummary  (WanlShop 直播接口-安全審核)
	 * @ApiMethod   (POST)
	 *
	 * @param string $DomainName 用戶域名
	 * @param string $AppName  App名
	 * @param string $StreamName 流名
	 * @param string $OssEndpoint 存儲對象 Endpoint
	 * @param string $OssBucket 存儲對象的 Bucket
	 * @param string $OssObject 存儲對象的文件名
	 * @param array $Result 參數
	 */
	public function detectporn($StreamName, $Result)
	{
		$res = $Result[0]['Result'][0];
		if($res['Suggestion'] == 'block'){ // 違規
			$live = model('app\api\model\wanlshop\Live')->get(['liveid' => $StreamName]);
			model('app\api\model\wanlshop\Find')->where(['live_id' => $live['id']])->delete();
			$live->save(['gestion' => $res['Scene'], 'state' => 3]);
			// 封禁直播間
			$this->sendLiveGroup($StreamName, ['type' => 'ban']);
			
		}else if($res['Suggestion'] == 'review'){ // 直播間存在違規
			$this->sendLiveGroup($StreamName, [
				'type' => 'review',
				'text' => '生放送室に違反がありますので、時間内に修正してください'
			]);
		}
	}
	
	/**
	 * 支付成功回調
	 *
	 * @ApiSummary  (WanlShop 支付接口-支付成功回調)
	 * @ApiMethod   (POST)
	 *
	 */
	public function notify($type)
    {
        if(empty($type)){
            $this->error(__('異常な訪問'));
        }
        $wanlpay = new WanlPay($type);
        $result = $wanlpay->notify();
        if($result['code'] == 200){
            return $result['msg'];
        }else{
            \Think\Log::write($result, 'debug');
            $this->error($result['msg']);
        }
    }
    
    /**
	 * 支付成功回調
	 *
	 * @ApiSummary  (WanlShop 支付接口-支付成功回調)
	 * @ApiMethod   (POST)
	 *
	 */
	public function notify_recharge($type)
    {
        if(empty($type)){
            $this->error(__('異常な訪問'));
        }
        $wanlpay = new WanlPay($type);
        $result = $wanlpay->notify_recharge();
        if($result['code'] == 200){
            return $result['msg'];
        }else{
            \Think\Log::write($result, 'debug');
            $this->error($result['msg']);
        }
    }
	
	/**
	 * 支付成功返回
	 *
	 * @ApiSummary  (WanlShop 支付接口-支付成功返回)
	 * @ApiMethod   (POST)
	 *
	 */
	public function return($type)
	{
		if(empty($type)){
            $this->error(__('異常な訪問'));
        }
        $view = new View();
        $wanlpay = new WanlPay($type);
        $config = get_addon_config('wanlshop');
        $view->row = $wanlpay->return();
        $view->config = $config['h5'];
        return $view->fetch('index@wanlshop/page/success');
	}
	
	
	
	/**
	 * 發送直播群組消息
	 * 內部方法
	 */
	private function sendLiveGroup($group, $message)
	{
		$wanlchat = new WanlChat();
		$wanlchat->sendGroup($group, [
			'type' => 'live',
			'group' => $group,
			'form' => [
				'id' => 0,
				'nickname' => 'システム'
			],
			'message' => $message,
			'online' => 0,
			'like' => 0
		]);
	}
}
	
	
	
	