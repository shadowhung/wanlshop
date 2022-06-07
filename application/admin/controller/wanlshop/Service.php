<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use addons\wanlshop\library\WanlChat\WanlChat;

/**
 * 店铺服务
 *
 * @icon fa fa-circle-o
 */
class Service extends Backend
{
    
    /**
     * Service模型对象
     * @var \app\admin\model\wanlshop\Service
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
		//WanlChat 即时通讯调用
		$this->wanlchat = new WanlChat();
        $this->model = new \app\admin\model\wanlshop\Service;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
	/**
	 * 绑定 1.0.2升级
	 */
	public function bind()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags', 'trim']);
		if ($this->request->isPost())
		{
		    $client_id = $this->request->post('client_id');
		    $user_id = bcadd(8080000, $this->auth->id);
			$this->wanlchat->bind($client_id, $user_id);
			// 查询是否有离线消息
			$list = model('app\admin\model\wanlshop\Chat')
				->where(['to_id' => $user_id, 'online' => 0, 'type' => 'service'])
				->whereTime('createtime', 'week')
				->field('id,form_uid,to_id,form,message,type,online,createtime')
				->select();
			$this->success(__('绑定成功'),null,$this->wanlchat->isOnline($user_id));
		}
	}
	
	
	/**
	 * 全部消息列表 1.0.2升级
	 */
	public function lists()
	{
		if(!$this->wanlchat->isWsStart()){
			$this->error('请启动IM即时通讯服务');
		}
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isAjax()) {
		    $user_id = bcadd(8080000, $this->auth->id);
			$chatModel = model('app\admin\model\wanlshop\Chat');
		    $formlist = [];
		    $tolist = [];
		    
			
		    $history = $chatModel->where("(form_uid={$user_id} or to_id={$user_id}) and type='service'")
		        ->order('createtime esc')
		        ->select();
		    foreach (collection($history)->toArray() as $vo) {
		        if ($vo['form_uid'] == $user_id) {
		            $formlist[] = $vo['to_id'];
		        }
		        if ($vo['to_id'] == $user_id) {
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
		        //查询店铺为读消息
		        $count = $chatModel
		            ->where(['form_uid' => $user['id'], 'to_id' => $user_id, 'isread' => 0])
		            ->count();
		        //查询和店铺最新消息
		        $content = $chatModel->where("((form_uid={$user_id} and to_id={$user['id']}) or (form_uid={$user['id']} and to_id={$user_id})) and type='service'")
		            ->order('createtime desc')
		            ->limit(1)
		            ->find();
		        //转换图片类型
				if($content['message']['type'] == 'img'){
					$msgtext = '[图片消息]';
				}else if($content['message']['type'] == 'voice'){
					$msgtext = '[语音消息]';
				}else if($content['message']['type'] == 'goods'){
					$msgtext = '[商品消息]';
				}else if($content['message']['type'] == 'order'){
					$msgtext = '[订单消息]';
				}else if($content['message']['type'] == 'text'){
					$msgtext = $content['message']['content']['text'];
				}else{
					$msgtext = '[未知消息类型]';
				}
		        //整理输出
		        $chat[] = [
		            'user_id' => $user['id'],
		            'nickname' => $user['nickname'],
		            'avatar' => $user['avatar'],
		            'content' => $msgtext,
		            'count' => $count,
					'createtime' => $content['createtime'],
					'isOnline' => $this->wanlchat->isOnline($user['id'])
		        ];
				// 时间排序
				$datetime[] = $content['createtime'];
		    }
			if($datetime){
				array_multisort($datetime, SORT_DESC, $chat);
			}
			// 获取配置
			$config = get_addon_config('wanlshop');
		    $this->success("拉取成功", null, [
				'chat' => $chat,
				'service' => [
					'id' => $user_id,
					'avatar' => $this->auth->avatar,
					'nickname' => $this->auth->nickname,
					'socketurl' => $config['ini']['socketurl']
				]
			]);
		}
	}
	
	
	/**
	 * 查询历史记录 1.0.2升级
	 */
	public function history()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('id');
			$id?'':($this->error(__('Invalid parameters')));
			$user_id = bcadd(8080000, $this->auth->id);
			$chat = model('app\admin\model\wanlshop\Chat');
			// 查询历史记录
			$result = $chat
				->where("((form_uid={$user_id} and to_id={$id}) or (form_uid={$id} and to_id={$user_id})) and type='service'")
				->whereTime('createtime', 'month')
				->order('createtime esc')
				->select();
			// 读取历史记录则标记已读
			$chat->where(['form_uid' => $id, 'to_id' => $user_id, 'isread' => 0])
				->update(['isread' => 1]);		
			$this->success("成功", null, [
			    'chat' => $result,
			    'isOnline' => $this->wanlchat->isOnline($id)
			]);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 全部已读 1.0.2升级
	 */
	public function read()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isAjax()) {
		    $id = $this->request->post('id');
		    $id ? '' : ($this->error(__('Invalid parameters')));
		    // 设置成已读
		    $chat = model('app\admin\model\wanlshop\Chat')
		        ->where(['form_uid' => $id, 'to_id' => bcadd(8080000, $this->auth->id), 'isread' => 0])
		        ->update(['isread' => 1]);
		    $this->success(__('全部已读'));
		}
	}
	
	/**
	 * 发送 1.0.2升级
	 */
	public function send()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags', 'trim']);
		if ($this->request->isPost()){
			$message = $this->request->post();
			$message?'':($this->error(__('Invalid parameters')));
			// 判断是否为自己
			if($message['form']['id'] == $message['to_id']){
				$this->error(__('不允许自己和自己聊天'));
			}
			// 查询是否在线
			if($this->wanlchat->isOnline($message['to_id']) == 1){
				$online = 1;
			}else{
				$online = 0;
			}
			
			// 保存聊天记录到服务器
			$data = model('app\admin\model\wanlshop\Chat');
			$data->form_uid = bcadd(8080000, $this->auth->id);
			$data->to_id = $message['to_id'];
			$data->form = json_encode($message['form']);
			$data->message = json_encode($message['message']);
			$data->type = $message['type'];
			$data->online = $online;
			$data->save();
			$message['id'] = $data->id;
			// 在线发送
			$online == 1 ? ($this->wanlchat->send($message['to_id'], $message)) : '';
			$this->success(__('发送成功'));
		}
	}
	
	/**
	 * 关闭聊天窗口 1.0.2升级
	 */
	public function close()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('to_id');
			$id?'':($this->error(__('Invalid parameters')));
			$data['type'] = 'service';
			$data['form']['id'] = 0;
			$data['form']['name'] = '智能小秘';
			$data['message']['type'] = 'end'; 
			$data['message']['content'] = '会话已结束';
			$this->wanlchat->send($id, $data);
			$this->success(__('会话已结束'));
		}
		$this->error(__('非法请求'));
	}
	
}
