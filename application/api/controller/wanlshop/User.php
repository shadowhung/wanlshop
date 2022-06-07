<?php

namespace app\api\controller\wanlshop;

use addons\wanlshop\library\Decrypt\weixin\wxBizDataCrypt;
use addons\wanlshop\library\WanlChat\WanlChat;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use fast\Http;
use think\Validate;

/**
 * WanlShop會員接口
 */
class User extends Api
{
    protected $noNeedLogin = ['login', 'logout', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third', 'phone', 'perfect'];
    protected $noNeedRight = ['*'];
    
    public function _initialize()
    {
        parent::_initialize();
        //WanlChat 即時通訊調用
		$this->wanlchat = new WanlChat();
		$this->auth->setAllowFields(['id','username','nickname','mobile','avatar','level','gender','birthday','bio','money','score','successions','maxsuccessions','prevtime','logintime','loginip','jointime']);
    }

    /**
     * 會員登錄
     * @ApiMethod   (POST)
     * @param string $account  賬號
     * @param string $password 密碼
     */
    public function login()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$account = $this->request->post('account');
			$password = $this->request->post('password');
			$client_id = $this->request->post('client_id');
			if (!$account || !$password) {
				$this->error(__('Invalid parameters'));
			}
			$ret = $this->auth->login($account, $password);
			if ($ret) {
			    if($client_id){
			        $this->wanlchat->bind($client_id, $this->auth->id);
			    }
				$data = [
					'userinfo' => $this->auth->getUserinfo(),
					'statistics' => $this->statistics()
				];
				$this->success(__('Logged in successful'), $data);
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('違法なリクエスト'));
    }

    /**
     * 手機驗證碼登錄
     * @ApiMethod   (POST)
     * @param string $mobile  手機號
     * @param string $captcha 驗證碼
     */
    public function mobilelogin()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$mobile = $this->request->post('mobile');
			$captcha = $this->request->post('captcha');
			$client_id = $this->request->post('client_id');
			if (!$mobile || !$captcha) {
				$this->error(__('Invalid parameters'));
			}
			if (!Validate::regex($mobile, "^\d{8,15}$")) {
				$this->error(__('Mobile is incorrect'));
			}
			if (!Sms::check($mobile, $captcha, 'mobilelogin')) {
				$this->error(__('Captcha is incorrect'));
			}
			$user = \app\common\model\User::getByMobile($mobile);
			if ($user) {
				if ($user->status != 'normal') {
					$this->error(__('Account is locked'));
				}
				//如果已經有賬號則直接登錄
				$ret = $this->auth->direct($user->id);
			} else {
				$ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
			}
			if ($ret) {
				Sms::flush($mobile, 'mobilelogin');
				if($client_id){
			        $this->wanlchat->bind($client_id, $this->auth->id);
			    }
				$data = [
					'userinfo' => $this->auth->getUserinfo(),
					'statistics' => $this->statistics()
				];
				$this->success(__('Logged in successful'), $data);
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('違法なリクエスト'));
    }
    
    /**
     * 手機號登錄
     * @ApiMethod   (POST)
     * @param string $encryptedData  
     * @param string $iv  
     */
    public function phone()
    {
        //設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
		    if (!isset($post['iv'])) {
		        $this->error(__('携帯電話番号が異常になる'));
		    }
		    // 獲取配置
		    $config = get_addon_config('wanlshop');
		    // 微信小程序一鍵登錄
	        $params = [
			    'appid'    => $config['mp_weixin']['appid'],
			    'secret'   => $config['mp_weixin']['appsecret'],
			    'js_code'  => $post['code'],
			    'grant_type' => 'authorization_code'
			    ];
		    $result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
		    $json = (array)json_decode($result['msg'], true);
		    // 判斷third是否存在ID,存在快速登錄
			if(isset($json['unionid'])){
				$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'mp_weixin', 'unionid' => $json['unionid']]);
			}else{
				$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'mp_weixin', 'openid' => $json['openid']]);
			}
			
		    if ($third && $third['user_id'] != 0) {
		        //如果已經有賬號則直接登錄
    			$ret = $this->auth->direct($third['user_id']);
		    } else {
    		    // 手機號解碼
    		    $decrypt = new wxBizDataCrypt($config['mp_weixin']['appid'], $json['session_key']);
                $decrypt->decryptData($post['encryptedData'], $post['iv'], $data);
                $data = (array)json_decode($data, true);
                // 開始登錄
    		    $mobile = $data['phoneNumber'];
    			$user = \app\common\model\User::getByMobile($mobile);
    			if ($user) {
    				if ($user->status != 'normal') {
    					$this->error(__('Account is locked'));
    				}
    				//如果已經有賬號則直接登錄
    				$ret = $this->auth->direct($user->id);
    			} else {
    				$ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
    			}
		    }

			
		    if ($ret) {
		        if (isset($post['client_id']) && $post['client_id'] != null) {
    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
    		    }
    			$data = [
    				'userinfo' => $this->auth->getUserinfo(),
    				'statistics' => $this->statistics()
    			];
    			$this->success(__('Logged in successful'), $data);
    		} else {
    			$this->error($this->auth->getError());
    		}
		}
		$this->error(__('違法なリクエスト'));
    }
    
    
    /**
     * 註冊會員
     * @ApiMethod   (POST)
     * @param string $mobile   手機號
     * @param string $code   驗證碼
     */
    public function register()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$mobile = $this->request->post('mobile');
			$password = $this->request->post('password');
			
			$paypass = $this->request->post('password2');
			$client_id = $this->request->post('client_id');
			if ($mobile && !Validate::regex($mobile, "^\d{8,15}$")) {
				$this->error(__('Mobile is incorrect'));
			}
		    /*$ret = Sms::check($mobile, $code, 'register');
			if (!$ret) {
				$this->error(__('Captcha is incorrect'));
			}*/
			//Random::alnum()
			$ret = $this->auth->register($mobile, $password, '', $mobile, [],$paypass);
			if ($ret) {
			    $ret = $this->auth->login($mobile, $password);
			    if($client_id){
			        $this->wanlchat->bind($client_id, $this->auth->id);
			    }
				$data = [
					'userinfo' => $this->auth->getUserinfo(),
					'statistics' => $this->statistics()
				];
				$this->success(__('Sign up successful'), $data);
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('違法なリクエスト'));
    }

    /**
     * 註銷登錄
     */
    public function logout($client_id = null)
    {
        // 踢出即時通訊
        if($client_id){
            $this->wanlchat->destoryClient($client_id);
        }
        // 退出登錄
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }
    
    
    public function getpaypass()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			if(!empty($user['paypass'])){
			    $this->success('成功を返す',1);
			}else{
			    $this->success('成功を返す',0);
			}
		}
    }
    
    /**
     * 重置密碼
     * @ApiMethod   (POST)
     * @param string $mobile      手機號
     * @param string $newpassword 新密碼
     * @param string $captcha     驗證碼
     */
    public function resetloginpass()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $user = $this->auth->getUser();
			
			$oldpay   = $this->request->post('oldpay');
			$newpay   = $this->request->post('newpay');
			$renewpay = $this->request->post('renewpay');
			
			
			if($newpay!=$renewpay){
			    $this->error('2つのパスワードエントリに一貫性がありません');
			}
			//var_dump($user);exit;
			if(md5(md5($oldpay) . $user['salt'])==$user['password']){
			    //$ret = $this->auth->changepwd($newpay, '', true);
			    $user->password = md5(md5($newpay) . $user['salt']);
    			$user->save();
    		    $this->success(__('Reset password successful'));
			}else{
			    $this->error('古いパスワードが間違って入力されました');
			}
		}
		$this->error(__('違法なリクエスト'));
    }
    
    public function resetpass()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			
			$oldpay   = $this->request->post('oldpay');
			$newpay   = $this->request->post('newpay');
			$renewpay = $this->request->post('renewpay');
			
			
			if($newpay!=$renewpay){
			    $this->error('2つのパスワードエントリに一貫性がありません');
			}
			if(!empty($user['paypass'])&&$user['paypass']==$oldpay){
			    $user->paypass = $newpay;
    			$user->save();
    			$this->success('成功を返す',$user);
			}else{
			    if(empty($user['paypass'])){
			        $user->paypass = $newpay;
        			$user->save();
        			$this->success('成功を返す',$user);
			    }
			    $this->error('古いパスワードが間違って入力されました');
			}
		
		}
		$this->error(__('違法なリクエスト'));
    }

    /**
     * 修改會員個人信息
     * @ApiMethod   (POST)
	 *
     * @param string $avatar   頭像地址
     * @param string $username 用戶名
     * @param string $nickname 昵稱
     * @param string $bio      個人簡介
     */
    public function profile()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			$avatar = $this->request->post('avatar', '', 'trim,strip_tags,htmlspecialchars');
			if($avatar){
				$user->avatar = $avatar;
			}else{
				$username = $this->request->post('username');
				$nickname = $this->request->post('nickname');
				$bio = $this->request->post('bio');
				if ($username) {
					$exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
					if ($exists) {
						$this->error(__('Username already exists'));
					}
					$user->username = $username;
				}
				$user->nickname = $nickname;
				$user->bio = $bio;
			}
			$user->save();
			$this->success('成功を返す',$user);
		}
		$this->error(__('違法なリクエスト'));
    }

    /**
     * 修改手機號
     * @ApiMethod   (POST)
     * @param string $email   手機號
     * @param string $captcha 驗證碼
     */
    public function changemobile()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			$mobile = $this->request->request('mobile');
			$captcha = $this->request->request('captcha');
			if (!$mobile || !$captcha) {
			    $this->error(__('Invalid parameters'));
			}
			if (!Validate::regex($mobile, "^\d{8,15}$")) {
			    $this->error(__('Mobile is incorrect'));
			}
			if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find()) {
			    $this->error(__('Mobile already exists'));
			}
			$result = Sms::check($mobile, $captcha, 'changemobile');
			if (!$result) {
			    $this->error(__('Captcha is incorrect'));
			}
			$verification = $user->verification;
			$verification->mobile = 1;
			$user->verification = $verification;
			$user->mobile = $mobile;
			$user->save();
			
			Sms::flush($mobile, 'changemobile');
			$this->success();
		}
		$this->error(__('違法なリクエスト'));
    }
    
    /**
     * 重置密碼
     * @ApiMethod   (POST)
     * @param string $mobile      手機號
     * @param string $newpassword 新密碼
     * @param string $captcha     驗證碼
     */
    public function resetpwd()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$mobile = $this->request->post("mobile");
			$newpassword = $this->request->post("newpassword");
			$captcha = $this->request->post("captcha");
			if (!$newpassword || !$captcha || !$mobile) {
				$this->error(__('Invalid parameters'));
			}
			if (!Validate::regex($mobile, "^\d{8,15}$")) {
				$this->error(__('Mobile is incorrect'));
			}
			$user = \app\common\model\User::getByMobile($mobile);
			if (!$user) {
				$this->error(__('User not found'));
			}
			$ret = Sms::check($mobile, $captcha, 'resetpwd');
			if (!$ret) {
				$this->error(__('Captcha is incorrect'));
			}
			Sms::flush($mobile, 'resetpwd');
			//模擬一次登錄
			$this->auth->direct($user->id);
			$ret = $this->auth->changepwd($newpassword, '', true);
			if ($ret) {
				$this->success(__('Reset password successful'));
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('違法なリクエスト'));
    }
    
    /**
     * 第三方登錄-web登錄
     * @ApiMethod   (POST)
     * @param string $platform 平臺名稱
     */
    public function third_web()
    {
        $this->error(__('まだ開いていません'));
    }
    
    
    /**
     * 第三方登錄
     * @ApiMethod   (POST)
     * @param string $platform 平臺名稱
     * @param string $code     Code碼
     */
    public function third()
    {
        //設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    // 獲取登錄配置
			$config = get_addon_config('wanlshop');
			// 獲取前端參數
			$post = $this->request->post();
			// 登錄項目
			$time = time();
			$platform = $post['platform'];
			// 開始登錄
			switch ($platform)
			{
				// 微信小程序登錄
				case 'mp_weixin':
					$params = [
						'appid'      => $config[$platform]['appid'],
						'secret'     => $config[$platform]['appsecret'],
						'js_code'    => $post['loginData']['code'],
						'grant_type' => 'authorization_code'
					];
					$result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
					if ($result['ret']) {
					    $json = (array)json_decode($result['msg'], true);
						if(isset($json['unionid'])){
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'unionid' => $json['unionid']]);
						}else{
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
						}
                        // 成功登錄
                        if ($third) {
                            $user = model('app\common\model\User')->get($third['user_id']);
                            if (!$user) {
                                $this->success('ユーザーはまだバインドされていません', [
                                    'binding' => 0,
                                    'third_id' => $third['id']
                                ]);
                            }
                            $third->save([
                                'access_token' => $json['session_key'],
                                'expires_in' => 7776000,
                                'logintime' => $time,
                                'expiretime' => $time + 7776000
                            ]);
                            $ret = $this->auth->direct($user->id);
                            if ($ret) {
                			    if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
                        } else {
                            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'weixin_open';
							if(isset($json['unionid'])){
								$third->unionid  = $json['unionid'];
							}else{
								$third->openid  = $json['openid'];
							}
                            $third->access_token  = $json['session_key'];
                            $third->expires_in  = 7776000;
                            $third->logintime  = $time;
                            $third->expiretime  = $time + 7776000;
                            // 判斷當前是否登錄
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自動完成
                                $this->success('正常にバインド', [
                                    'binding' => 1
                                ]);
                            } else {
                                $third->save();
                                // 通知客戶端綁定
                                $this->success('ユーザーはまだバインドされていません', [
                                    'binding' => 0,
                                    'third_id' => $third->id
                                ]);
                            }
                        }
					}else{
						$this->error('API例外、WeChatアプレットのログインに失敗しました'); 
					}
					break;
					
				// 微信App登錄
				case 'app_weixin':
					$params = [
						'access_token' => $post['loginData']['authResult']['access_token'],
						'openid' => $post['loginData']['authResult']['openid']
					];
					$result = Http::sendRequest("https://api.weixin.qq.com/sns/userinfo", $params, 'GET');
					if ($result['ret']) {
					    $json = (array)json_decode($result['msg'], true);
						if(isset($json['unionid'])){
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'unionid' => $json['unionid']]);
						}else{
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
						}
					    // 成功登錄
                        if ($third) {
                            $third->save([
                                'access_token' => $post['loginData']['authResult']['access_token'],
                                'refresh_token' => $post['loginData']['authResult']['refresh_token'],
                                'expires_in' => $post['loginData']['authResult']['expires_in'],
                                'logintime' => $time,
                                'expiretime' => $time + $post['loginData']['authResult']['expires_in']
                            ]);
                            $ret = $this->auth->direct($third['user_id']);
                            if ($ret) {
                                if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
                        } else {
                            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'weixin_open';
							if(isset($json['unionid'])){
								$third->unionid  = $json['unionid'];
							}else{
								$third->openid  = $json['openid'];
							}
                            $third->access_token  = $post['loginData']['authResult']['access_token'];
                            $third->refresh_token  = $post['loginData']['authResult']['refresh_token'];
                            $third->expires_in  = $post['loginData']['authResult']['expires_in'];
                            $third->logintime  = $time;
                            $third->expiretime  = $time + $post['loginData']['authResult']['expires_in'];
                            // 判斷當前是否登錄,否則註冊
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自動完成
                                $this->success('正常にバインド', [
                                    'binding' => 1
                                ]);
                            } else {
                                $username = $json['nickname'];
                                $mobile = '';
                                $gender = $json['sex']==1 ? 1 : 0;
                                $avatar = $json['headimgurl'];
                                // 註冊賬戶        
                                $result = $this->auth->register('u_'.Random::alnum(6), Random::alnum(), '', $mobile, [
                    		        'gender' => $gender, 
                    		        'nickname' => $username, 
                    		        'avatar' => $avatar
                    		    ]);
                    			if ($result) {
                    			    if (isset($post['client_id']) && $post['client_id'] != null) {
                        		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                        		    }
                    				$data = [
                    					'userinfo' => $this->auth->getUserinfo(),
                    					'statistics' => $this->statistics()
                    				];
                    				// 更新第三方登錄
                    			    $third->user_id  = $this->auth->id;
                    			    $third->openname  = $username;
                    			    $third->save();
                    				$this->success(__('Sign up successful'), $data);
                    			} else {
                    				$this->error($this->auth->getError());
                    			}
                            }
                        }
					}else{
					    $this->error('API例外、アプリのログインに失敗しました'); 
					}
					break;
					
				// 微信公眾號登錄
				case 'h5_weixin':
					// 後續版本上線
					break;
					
				// QQ小程序登錄
				case 'mp_qq':
					$params = [
						'appid'      => $config[$platform]['appid'],
						'secret'     => $config[$platform]['appsecret'],
						'js_code'    => $post['loginData']['code'],
						'grant_type' => 'authorization_code'
					];
					$result = Http::sendRequest("https://api.q.qq.com/sns/jscode2session", $params, 'GET');
					if ($result['ret']) {
					    $json = (array)json_decode($result['msg'], true);
						if(isset($json['unionid'])){
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'qq_open', 'unionid' => $json['unionid']]);
						}else{
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'qq_open', 'openid' => $json['openid']]);
						}
                        // 成功登錄
                        if ($third) {
                            $user = model('app\common\model\User')->get($third['user_id']);
                            if (!$user) {
                                $this->success('ユーザーはまだバインドされていません', [
                                    'binding' => 0,
                                    'third_id' => $third['id']
                                ]);
                            }
                            $third->save([
                                'access_token' => $json['session_key'],
                                'expires_in' => 7776000,
                                'logintime' => $time,
                                'expiretime' => $time + 7776000
                            ]);
                            $ret = $this->auth->direct($user->id);
                            if ($ret) {
                                if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
                        } else {
                            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'qq_open';
							if(isset($json['unionid'])){
								$third->unionid  = $json['unionid'];
							}else{
								$third->openid  = $json['openid'];
							}
                            $third->access_token  = $json['session_key'];
                            $third->expires_in  = 7776000;
                            $third->logintime  = $time;
                            $third->expiretime  = $time + 7776000;
                            // 判斷當前是否登錄
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自動完成
                                $this->success('正常にバインド', [
                                    'binding' => 1
                                ]);
                            } else {
                                $third->save();
                                // 通知客戶端綁定
                                $this->success('ユーザーはまだバインドされていません', [
                                    'binding' => 0,
                                    'third_id' => $third->id
                                ]);
                            }
                        }
					}else{
						$this->error('API例外、WeChatアプレットのログインに失敗しました'); 
					}
					break; 
					
				// QQ App登錄
				case 'app_qq':
					$params = [
						'access_token' => $post['loginData']['authResult']['access_token']
					];
					$options = [
                        CURLOPT_HTTPHEADER  => [
                            'Content-Type: application/x-www-form-urlencoded'
                        ]
                    ];
					$result = Http::sendRequest("https://graph.qq.com/oauth2.0/me", $params, 'GET' ,$options);
					if ($result['ret']) {
					    $json = (array)json_decode(str_replace(" );","",str_replace("callback( ","",$result['msg'])), true);
					    if ($json['openid'] == $post['loginData']['authResult']['openid']) {
				            $third = model('app\api\model\wanlshop\Third')->get(['platform' => 'qq_open', 'openid' => $json['openid']]);
    				        if ($third) {
    				            $user = model('app\common\model\User')->get($third['user_id']);
                                if (!$user) {
                                    $this->success('ユーザーはまだバインドされていません', [
                                        'binding' => 0,
                                        'third_id' => $third['id']
                                    ]);
                                }
    				            $third->save([
                                    'access_token' => $post['loginData']['authResult']['access_token'],
                                    'expires_in' => $post['loginData']['authResult']['expires_in'],
                                    'logintime' => $time,
                                    'expiretime' => $time + $post['loginData']['authResult']['expires_in']
                                ]);
                                $ret = $this->auth->direct($third['user_id']);
                                if ($ret) {
                                    if (isset($post['client_id']) && $post['client_id'] != null) {
                        		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                        		    }
                    				$data = [
                    					'userinfo' => $this->auth->getUserinfo(),
                    					'statistics' => $this->statistics()
                    				];
                    				$this->success(__('Sign up successful'), $data);
                    			} else {
                    				$this->error($this->auth->getError());
                    			}
    				        } else {
    				            // 新增$third
                                $third = model('app\api\model\wanlshop\Third');
                                $third->platform  = 'qq_open';
                                $third->openid  = $json['openid'];
                                $third->access_token  = $post['loginData']['authResult']['access_token'];
                                $third->expires_in  = $post['loginData']['authResult']['expires_in'];
                                $third->logintime  = $time;
                                $third->expiretime  = $time + $post['loginData']['authResult']['expires_in'];
                                // 判斷當前是否登錄
                                if($this->auth->isLogin()){
                                    $third->user_id  = $this->auth->id;
                                    $third->save();
                                    // 直接綁定自動完成
                                    $this->success('正常にバインド', [
                                        'binding' => 1
                                    ]);
                                } else {
                                    $third->save();
                                    // 通知客戶端綁定
                                    $this->success('ユーザーはまだバインドされていません', [
                                        'binding' => 0,
                                        'third_id' => $third->id
                                    ]);
                                }
    				        }
					    } else {
					        $this->error(__('違法なリクエスト，機械情報が提出されました'));
					    }
					}else{
					    $this->error('API例外、アプリのログインに失敗しました'); 
					}
					break;
				// QQ 網頁登錄
				case 'h5_qq':
					// 後續版本上線
					break; 
				// 微博App登錄
				case 'app_weibo':
					$params = [
						'access_token' => $post['loginData']['authResult']['access_token']
					];
					$options = [
                        CURLOPT_HTTPHEADER  => [
                            'Content-Type: application/x-www-form-urlencoded'
                        ],
                        CURLOPT_POSTFIELDS => http_build_query($params),
                        CURLOPT_POST => 1
                    ];
					$result = Http::post("https://api.weibo.com/oauth2/get_token_info", $params, $options);
					$json = (array)json_decode($result, true);
				    if($json['uid'] == $post['loginData']['authResult']['uid']){
				        $third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weibo_open', 'openid' => $json['uid']]);
				        if ($third) {
				            $user = model('app\common\model\User')->get($third['user_id']);
                            if (!$user) {
                                $this->success('ユーザーはまだバインドされていません', [
                                    'binding' => 0,
                                    'third_id' => $third['id']
                                ]);
                            }
				            $third->save([
                                'access_token' => $post['loginData']['authResult']['access_token'],
                                'expires_in' => $json['expire_in'],
                                'logintime' => $json['create_at'],
                                'expiretime' => $json['create_at'] + $json['expire_in']
                            ]);
                            $ret = $this->auth->direct($third['user_id']);
                            if ($ret) {
                                if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
				        } else {
				            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'weibo_open';
                            $third->openid  = $json['uid'];
                            $third->access_token  = $post['loginData']['authResult']['access_token'];
                            $third->expires_in  = $json['expire_in'];
                            $third->logintime  = $json['create_at'];
                            $third->expiretime  = $json['create_at'] + $json['expire_in'];
                            // 判斷當前是否登錄
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自動完成
                                $this->success('正常にバインド', [
                                    'binding' => 1
                                ]);
                            } else {
                                $third->save();
                                // 通知客戶端綁定
                                $this->success('ユーザーはまだバインドされていません', [
                                    'binding' => 0,
                                    'third_id' => $third->id
                                ]);
                            }
				        }
				    }else{
				        $this->error(__('違法なリクエスト，機械情報が提出されました'));
				    }
					break; 
					
				// 小米App登錄
				case 'app_xiaomi':
					
					break;
					
				// 蘋果登錄
				case 'apple':
					// 後續版本上線
					break; 
				default:
					$this->error('このログイン方法は現在サポートされていません');
			}
		}
		$this->error(__('10086異常リクエスト'));
    }

    /**
	 * 進一步完善資料
	 * @ApiMethod   (POST)
	 */
	public function perfect()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $post = $this->request->post();
		    // 判斷third_id沒有綁定
		    $third = model('app\api\model\wanlshop\Third')->get($post['third_id']);
		        // 當user_id 不為空可以綁定
    		    if($third['user_id'] == 0 && $third){
    		        $username = $post['nickName'];
    		        $mobile = '';
    		        $gender = $post['gender'];
        		    $avatar = $post['avatarUrl'];
        		    $result = $this->auth->register('u_'.Random::alnum(6), Random::alnum(), '', $mobile, [
        		        'gender' => $gender, 
        		        'nickname' => $username, 
        		        'avatar' => $avatar
        		    ]);
        			if ($result) {
        				$data = [
        					'userinfo' => $this->auth->getUserinfo(),
        					'statistics' => $this->statistics()
        				];
        				// 更新第三方登錄
        				$third->save([
        			        'user_id' => $this->auth->id,
        			        'openname' => $username
        			    ]);
        				$this->success(__('Sign up successful'), $data);
        			} else {
        				$this->error($this->auth->getError());
        			}
    		    }else{
    		        $this->error(__('違法なリクエスト，機械情報が提出されました'));
    		    }
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 刷新用戶中心
	 * @ApiMethod   (POST)
	 */
	public function refresh()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$this->success(__('正常に更新'), $this->statistics());
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 數據統計 - 內部使用，開發者不要調用
	 */
	public function statistics()
	{
		$user_id = $this->auth->id;
		// 查詢訂單
		$order = model('app\api\model\wanlshop\Order')
			->where('user_id', $user_id)
			->select();
		$orderCount = array_count_values(array_column($order,'state'));
		// 物流列表
		$logistics = [];
		foreach ($order as $value)
		{
			if($value['state'] >=3 && $value['state'] <=6){
				//需要查詢的訂單
			}
		}
		// 查詢動態 、收藏夾、關註店鋪、足跡、紅包卡券
		$data = [
			'dynamic' => [
				'collection' => model('app\api\model\wanlshop\GoodsFollow')->where('user_id', $user_id)->count(),
				'concern' => model('app\api\model\wanlshop\ShopFollow')->where('user_id', $user_id)->count(),
				'footprint' => model('app\api\model\wanlshop\Record')->where('user_id', $user_id)->count(),
				'coupon' => model('app\api\model\wanlshop\CouponReceive')->where(['user_id' => $user_id, 'state' => '1'])->count(),
				'accountbank' => model('app\api\model\wanlshop\PayAccount')->where('user_id', $user_id)->count()
			],
			'order' => [
				'pay' => isset($orderCount[1]) ? $orderCount[1] : 0,
				'delive' => isset($orderCount[2]) ? $orderCount[2] : 0,
				'receiving' => isset($orderCount[3]) ? $orderCount[3] : 0,
				'evaluate' => isset($orderCount[4]) ? $orderCount[4] : 0,
				'customer' => model('app\api\model\wanlshop\Refund')->where(['state' => ['in','1,2,3,6'], 'user_id' => $this->auth->id])->count()
			],
			'logistics' => $logistics
		];
	    return $data;
	}
	
	/**
	 * 獲取評論列表
	 *
	 * @ApiSummary  (WanlShop 獲取我的所有評論)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $list_rows  每頁數量
	 * @param string $page  當前頁
	 */
	public function comment()
	{
		$list = model('app\api\model\wanlshop\GoodsComment')
			->where('user_id', $this->auth->id)
			->field('id,images,score,goods_id,order_goods_id,state,content,createtime')
			->order('createtime desc')
			->paginate()
			->each(function($data, $key){
				$data['order_goods'] = $data->order_goods ? $data->order_goods->visible(['id','title','image','price']):'';
				return $data;
			});
		$this->success('成功を返す', $list);
	}
	
	/**
	 * 獲取積分明細
	 */
	public function scoreLog()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\common\model\ScoreLog')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('違法なリクエスト'));
	}
	
}