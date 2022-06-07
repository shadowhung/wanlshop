<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use addons\wanlshop\library\WanlChat\WanlChat;
use think\Session;
use think\Db;
/**
 * WanlShop即時通訊接口
 */
class Chat extends Api
{
    protected $noNeedLogin = ['shake','service','hello','state'];
	protected $noNeedRight = ['*'];
    

    public function _initialize()
    {
        parent::_initialize();
		//WanlChat 即時通訊調用
		$this->wanlchat = new WanlChat();
		// 調用配置
		$this->chatConfig = get_addon_config('wanlshop');

    }
    
    /**
     * 綁定UID
     *
	 * @ApiSummary  (WanlChat 綁定UID)
	 * @ApiMethod   (POST)
	 *
     * @param string $client_id 
     */
    public function shake()
    {
        //設置過濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$client_id = $this->request->post('client_id');
			$client_id?'':($this->error(__('Invalid parameters')));
			// 綁定在線
			if ($this->auth->isLogin()) {
			    $user_id = $this->auth->id;
			    // 查詢有沒有綁定其他如果有的話全部解綁，退出登錄頁執行此操作
			    foreach ($this->wanlchat->getUidToClientId($user_id) as $client_id_old) {
			    	$this->wanlchat->unbind($client_id_old, $user_id);
			    }
			    // 重新綁定壹個新的
			    $this->wanlchat->bind($client_id, $user_id);
			    // 查詢是否有離線消息
				$list = model('app\api\model\wanlshop\Chat')
					->where(['to_id' => $user_id, 'online' => 0, 'type' => 'chat'])
					->whereTime('createtime', 'week')
					->field('id,form_uid,to_id,form,message,type,online,createtime')
					->select();
				foreach($list as $message){
					$this->wanlchat->send($user_id, $message);
					model('app\api\model\wanlshop\Chat')->save(['online' => 1], ['id' => $message['id']]);
				}
				$this->success(__('IMが正常に初期化されました'), $client_id);
			}else{
			    // 綁定離線，可能用戶在線客服等其他消息通知
			    
			    $this->success(__('インスタントメッセージングのオフライン初期化に成功しました'), $client_id);
			}
		}
		$this->error(__('異常なリクエスト'));
    }
    
	/**
	 * 聊天列表
	 *
	 * @ApiSummary  (WanlChat 讀取聊天列表)
	 * @ApiMethod   (GET)
	 */
	public function lists()
	{
		$user_id = $this->auth->id;
		$list = [];
		$sub = Db::name('WanlshopChat')
			->where(['type' => 'chat'])
			->order('createtime', 'desc')
		    ->field('to_id as uid, message, isread, type, createtime')
		    ->where('form_uid ='.$user_id)
		    ->union('SELECT form_uid as uid, message, isread, type, createtime FROM '.config('database.prefix').'wanlshop_chat WHERE to_id = '.$user_id)
			->buildSql();
		$query = Db::table($sub)
			->alias('temp')
			->group('temp.uid')
			->select();
		foreach($query as $row)
		{
			if($row['type'] == 'chat'){ //臨時
				$shop = model('app\api\model\wanlshop\Shop')
					->where(['user_id' => $row['uid']])
					->find();
				// 統計未讀
				$count = model('app\api\model\wanlshop\Chat')
					->where(['form_uid' => $shop['user_id'], 'to_id' => $user_id, 'isread' => 0])
					->count();
				
				$content = json_decode($row['message'], true);
				// 轉換為文字消息 1.0.2升級
				if($content['type'] == 'img'){

					$msgtext = '[画像メッセージ]';

				}else if($content['type'] == 'voice'){

					$msgtext = '[ボイスメッセージ]';

				}else if($content['type'] == 'goods'){

					$msgtext = '[商品ニュース]';

				}else if($content['type'] == 'order'){

					$msgtext = '[注文メッセージ]';

				}else if($content['type'] == 'text'){

					$msgtext = $content['content']['text'];

				}else{

					$msgtext = '[不明なメッセージタイプ]';

				}
				// 輸出
				$list[] = [
					'id' => $shop['id'],
					'user_id' => $shop['user_id'],
					'name' => $shop['shopname'],
					'avatar' => $shop['avatar'],
					'content' => $msgtext,
					'count' => $count,
					'createtime' => $row['createtime']
				];
			}
		}
		$this->success(__('OK'),$list);
	}

	/**
	 * 發送消息
	 *
	 * @ApiSummary  (WanlChat 發送即使消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $message 消息內容JSON
	 */
	public function send()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){

			// 判斷服務是否啟動

			if(!$this->wanlchat->isWsStart()){

				$this->error('IMインスタントメッセージングサービスをアクティブにしてください');

			}
			$message = $this->request->post();
			$message['type'] = 'chat'; //用戶唯壹發送口，加chat防止偽裝客服或其他類型消息
			$message?'':($this->error(__('Invalid parameters')));
			if($message['form']['id'] != $this->auth->id){
				$this->error(__('不正アクセス'));
			}
			// 判斷是否為自己
			if($message['form']['id'] == $message['to_id']){
				$this->error(__('自分とチャットすることを許可しないでください'));
			}
			// 查詢是否在線
			$online = $this->wanlchat->isOnline($message['to_id']);

			// 保存聊天記錄到服務器
			$data = model('app\api\model\wanlshop\Chat');
			$data->form_uid = $message['form']['id'];
			$data->to_id = $message['to_id'];
			$data->form = json_encode($message['form']);
			$data->message = json_encode($message['message']);
			$data->type = $message['type'];
			$data->online = $online;
			$data->save();
			$message['id'] = $data->id;
			// 在線發送
			$online == 1 ? ($this->wanlchat->send($message['to_id'], $message)) : '';
			$this->success(__('正常に送信されました'), []);
		}
		$this->error(__('違法なリクエスト'));
	}
	

	/**

	 * 查詢IM服務器狀態

	 *

	 * @ApiSummary  (WanlChat 查詢用戶歷史消息)

	 * @ApiMethod   (GET)

	 */

	public function state()

	{

		if(!$this->wanlchat->isWsStart()){

			$this->error('IMサーバーが起動していません。管理者に確認してください。ライブブロードキャストサービスのログインサービスが一時停止されています。');

		}else{

			$this->success(__('IMサーバーが起動しました'));

		}

	}

	

	
	/**
	 * 查詢用戶聊天記錄
	 *
	 * @ApiSummary  (WanlChat 查詢用戶歷史消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $to_id 接受ID
	 */
	public function history()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('to_id');
			$id?'':($this->error(__('Invalid parameters')));
			$uid = $this->auth->id;
			// 查詢歷史記錄
			$result = model('app\api\model\wanlshop\Chat')
				->where("((form_uid={$uid} and to_id={$id}) or (form_uid={$id} and to_id={$uid})) and type='chat'")
				->whereTime('createtime', 'month')
				->order('createtime Desc')
				->paginate();
			$this->success(__('正常に送信されました'), $result);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 全部已讀
	 *
	 * @ApiSummary  (WanlChat 已讀店鋪消息)
	 * @ApiMethod   (POST)
	 */
	public function read()
	{
		if($this->request->isPost()){
			$uid = $this->auth->id;
			$data = model('app\api\model\wanlshop\Chat')
				->where(['to_id' => $uid, 'isread' => 0, 'type' => 'chat'])
				->update(['isread' => 1]);	
			$this->success(__('更新が完了しました'), []);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 已讀店鋪消息
	 *
	 * @ApiSummary  (WanlChat 已讀店鋪消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $shop_id 店鋪ID
	 */
	public function clear()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('id');
			$id?'':($this->error(__('Invalid parameters')));
			$uid = $this->auth->id;
			// 設置成已讀
			$data = model('app\api\model\wanlshop\Chat')
				->where(['form_uid' => $id, 'to_id' => $uid, 'isread' => 0])
				->update(['isread' => 1]);	
			$this->success(__('更新が完了しました'), $data);
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 刪除指定聊天記錄
	 *
	 * @ApiSummary  (WanlChat 刪除指定聊天記錄)
	 * @ApiMethod   (POST)
	 *
	 * @param string $shop_id 店鋪ID
	 */
	public function del()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('id');
			$id ? '' : ($this->error(__('Invalid parameters')));
			$uid = $this->auth->id;
			// 設置成已讀
			$data = model('app\api\model\wanlshop\Chat')
				->where("((form_uid={$uid} and to_id={$id}) or (form_uid={$id} and to_id={$uid})) and type='chat'")
				->delete();
			$this->success(__('更新が完了しました'), $data);
		}
		$this->error(__('違法なリクエスト'));
	}
	

	/**

	 * 加載歡迎消息 1.0.2升級

	 *

	 * @ApiSummary  (WanlChat 加載歡迎消息)

	 * @ApiMethod   (POST)

	 */

	public function hello()

	{

		//設置過濾方法

		$this->request->filter(['strip_tags']);

		if($this->request->isPost()){

			$post = $this->request->post();

			if($post['type'] == 'service'){

				$data['id'] = $post['id'] + 1;

				$data['type'] = 'service';

				$data['form']['id'] = 0;

				$data['message']['type'] = 'text'; //默認消息

				$data['message']['content']['text'] = $this->chatConfig['config']['auth_reply'];

				$data['createtime'] = time();

				$this->wanlchat->send($post['form_id'], $data);

			}else if($post['type'] == 'shop'){

				

			}

			$this->success(__('リクエストは成功しました'));

		}

		$this->error(__('違法なリクエスト'));

	}

	

	
	/**
	 * 智能小秘
	 *
	 * @ApiSummary  (WanlChat 智能小秘)
	 * @ApiMethod   (POST)
	 */
	public function service()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$post = $this->request->post();
			$form_id = $post['form']['id'];
			if($post['message']['type'] == 'text'){
				$content = $post['message']['content']['text'];
			}
			$data['id'] = $post['id'] + 1;  
			$data['type'] = 'service';
			$data['form']['id'] = 0;
			$data['message']['type'] = 'text'; //默認消息
			$data['createtime'] = time();
			if($post['to_id'] == 0){
				if($post['message']['type'] == 'text'){
					if($content == '手動カスタマーサービス' || $content == '顧客サービス' || $content == '人工的な'|| $content == '3'){
						// 查詢 哪個後臺在線
						$online = [];
						$admin = model('app\api\model\wanlshop\Admin')
							->field('id,nickname,avatar')
							->select();

						foreach($admin as $user){
							if($this->wanlchat->isOnline(bcadd(8080000,$user['id'])) == 1){
								 $online[] = $user;
							}
						}

						if(count($online) == 0){
							$data['message']['content']['text'] = $this->chatConfig['config']['not_online'];
						}else{
							$key = mt_rand(0,count($online)-1);
							$data['form']['id'] = bcadd(8080000, $online[$key]['id']); // 隨機發送壹個在線管理員
							$data['form']['name'] = $online[$key]['nickname'];
							$data['form']['avatar'] = $online[$key]['avatar'];
							$data['message']['content']['text'] = $this->chatConfig['config']['service_initial'];
						}
						$this->wanlchat->send($form_id, $data);
					}else{
						$list = model('app\api\model\wanlshop\Article')
							->where('keywords',$content)
							->field('id,title,content')
							->find();
						if($list){
							$data['message']['type'] = 'article';
							$data['message']['content'] = $list;
						}else{
							$arr = explode(' ',$content);
							$like = [];
							foreach($arr as $value){
								$like[] = '%'.$value.'%';
							}
							$article = model('app\api\model\wanlshop\Article')
								->where('title|content','like',$like,'OR')
								->field('id,title,keywords')
								->select();
							$data['message']['type'] = 'list';
							$data['message']['content'] = $article;
						}
						$this->wanlchat->send($form_id, $data);
					}
				}else{
					if($post['message']['type'] == 'img'){
						$type = '画像メッセージ';
					}
					if($post['message']['type'] == 'voice'){
						$type = 'ボイスメッセージ';
					}
					$data['message']['content']['text'] = '[悪い] [為為] [為為]、ちょっとした知的な秘密を一時的に特定できない“'.$type.'”，手動のカスタマーサービスと通信するときに使用できます~~';
					$this->wanlchat->send($form_id, $data);
				}
			}else{
				$online = 1;
				// 保存聊天記錄到服務器
				$data = model('app\api\model\wanlshop\Chat');
				$data->form_uid = $post['form']['id'];
				$data->to_id = $post['to_id'];
				$data->form = json_encode($post['form']);
				$data->message = json_encode($post['message']);
				$data->type = $post['type'];
				$data->online = $online;
				$data->save();
				$post['id'] = $data->id;
				// 在線發送
				$this->wanlchat->send($post['to_id'], $post);
			}
			$this->success(__('リクエストは成功しました'));
		}
		$this->error(__('違法なリクエスト'));
	}
}
