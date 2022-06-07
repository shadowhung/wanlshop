<?php
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use addons\wanlshop\library\WanlChat\WanlChat;

use think\Config;
use think\Db;

/**
 * 主頁
 * @internal
 */
class Chat extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    
    public function _initialize()
    {
        parent::_initialize();
		$this->model = new \app\index\model\wanlshop\Chat;
		$this->wanlchat = new WanlChat();
    }
    

	/**

	 * 即時通訊綁定client_id 1.0.2升級

	 */

	public function chatbind()

	{

	    //設置過濾方法

	    $this->request->filter(['strip_tags']);

	    if ($this->request->isAjax()) {

	        $client_id = $this->request->post('client_id');

	        $client_id ? '' : ($this->error(__('Invalid parameters')));

	        $user_id = $this->auth->id;

			$this->wanlchat->bind($client_id, $user_id);

	        // 查詢是否有離線消息 1.0.2升級 棄用貌似意義不大

	   //      $list = $this->model

	   //          ->where(['to_id' => $user_id, 'online' => 0, 'type' => 'chat'])

	   //          ->whereTime('createtime', 'week')

	   //          ->field('id,form_uid,to_id,form,message,type,online,createtime')

	   //          ->select();

	   //      foreach ($list as $row) {

	   //          $this->wanlchat->send($user_id, $row);

				// $this->model->save(['online' => 1], ['id' => $row['id']]);

	   //      }

	        $this->success(__('正常にバインド'), null, $this->wanlchat->isOnline($user_id));

	    }

	}

	

	

	/**

	 * 全部消息列表 1.0.2升級

	 */

	public function lists()

	{

		if(!$this->wanlchat->isWsStart()){

			$this->error('IMインスタントメッセージングサービスをアクティブにしてください');

		}

		//設置過濾方法

		$this->request->filter(['strip_tags']);

		if ($this->request->isAjax()) {

		    $uid = $this->auth->id;

		    $formlist = [];

		    $tolist = [];

		    $chatModel = $this->model;

		    $history = $chatModel->where("(form_uid={$uid} or to_id={$uid}) and type='chat'")

		        ->order('createtime esc')

		        ->select();

		    foreach (collection($history)->toArray() as $vo) {

		        if ($vo['form_uid'] == $uid) {

		            $formlist[] = $vo['to_id'];

		        }

		        if ($vo['to_id'] == $uid) {

		            $tolist[] = $vo['form_uid'];

		        }

		    }

		    $list = model('app\common\model\User')

		        ->where('id', 'in', array_unique(array_merge($formlist, $tolist)))

		        ->field('id,username,nickname,avatar')

		        ->select();

			$chat = [];

		    $message = [];

			$datetime = [];

			$countNum = 0;

		    foreach (collection($list)->toArray() as $user) {

		        //查詢店鋪為讀消息

		        $count = $chatModel

		            ->where(['form_uid' => $user['id'], 'to_id' => $uid, 'isread' => 0])

		            ->count();

		        //查詢和店鋪最新消息

		        $content = $chatModel->where("((form_uid={$uid} and to_id={$user['id']}) or (form_uid={$user['id']} and to_id={$uid})) and type='chat'")

		            ->order('createtime desc')

		            ->limit(1)

		            ->find();

		        //轉換圖片類型

				if($content['message']['type'] == 'img'){

					$msgtext = '[画像メッセージ]';

				}else if($content['message']['type'] == 'voice'){

					$msgtext = '[ボイスメッセージ]';

				}else if($content['message']['type'] == 'goods'){

					$msgtext = '[商品ニュース]';

				}else if($content['message']['type'] == 'order'){

					$msgtext = '[注文メッセージ]';

				}else if($content['message']['type'] == 'text'){

					$msgtext = $content['message']['content']['text'];

				}else{

					$msgtext = '[不明なメッセージタイプ]';

				}

		        //整理輸出

		        $chat[] = [

		            'user_id' => $user['id'],

		            'nickname' => $user['nickname'],

		            'avatar' => $user['avatar'],

		            'content' => $msgtext,

		            'count' => $count,

					'createtime' => $content['createtime'],

					'isOnline' => $this->wanlchat->isOnline($user['id'])

		        ];

				// 時間排序

				$datetime[] = $content['createtime'];

		    }

			if($datetime){

				array_multisort($datetime, SORT_DESC, $chat);

			}

		    $this->success("正常に引っ張る", null, [

				'chat' => $chat,

				'shop' => [

					'id' => $this->shop->id,

					'user_id' => $this->shop->user_id,

					'avatar' => $this->shop->avatar,

					'shopname' => $this->shop->shopname

				]

			]);

		}

	}

	

	/**

	 * 歷史消息記錄 1.0.2升級

	 */

	public function history()

	{

	    //設置過濾方法

	    $this->request->filter(['strip_tags']);

	    if ($this->request->isAjax()) {

	        $id = $this->request->post('id');

	        $id?'':($this->error(__('Invalid parameters')));

	        $uid = $this->auth->id;

	        // 設置成已讀

	        $this->model

	            ->where(['form_uid' => $id, 'to_id' => $uid, 'isread' => 0])

	            ->update(['isread' => 1]);

	        $chat = $this->model

	            ->where("((form_uid={$uid} and to_id={$id}) or (form_uid={$id} and to_id={$uid})) and type='chat'")

	            // ->whereTime('createtime', 'month')

	            ->order('createtime esc')

	            ->limit(500) //最多拉取500條，叠代版本做分頁

	            ->select();

	        $this->success("成功", null, [

	            'chat' => $chat,

	            'isOnline' => $this->wanlchat->isOnline($id)

	        ]);

	    }

	}

	

	/**

	 * 全部已讀

	 */

	public function read()

	{

	    //設置過濾方法

	    $this->request->filter(['strip_tags']);

	    if ($this->request->isAjax()) {

	        $id = $this->request->post('id');

	        $id?'':($this->error(__('Invalid parameters')));

	        $uid = $this->auth->id;

	        // 設置成已讀

	        $this->model

	            ->where(['form_uid' => $id, 'to_id' => $uid, 'isread' => 0])

	            ->update(['isread' => 1]);

	        $this->success(__('すべて読んだ'));

	    }

	}
    
    /**
     * 發送消息
     */
    public function chatSend()
    {
        //設置過濾方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            $message = $this->request->post();
            $message['form']['id'] = $this->auth->id;

			$message['form']['shop_id'] = $this->shop->id;
            // 未來增加權限判斷
            // 查詢是否在線
			$online = $this->wanlchat->isOnline($message['to_id']);
            // 保存聊天記錄到服務器
            $data = $this->model;
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
            $this->success(__('正常に送信されました'));
        }
    }
}
