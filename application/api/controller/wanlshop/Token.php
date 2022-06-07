<?php

namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use fast\Random;
/**
 * WanlShop Token接口
 */
class Token extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    
    /**
     * 檢測Token是否過期
     *
     */
    public function check()
    {
        $token = $this->auth->getToken();
        $tokenInfo = \app\common\library\Token::get($token);
        $this->success('', ['token' => $tokenInfo['token'], 'expires_in' => $tokenInfo['expires_in']]);
    }

    /**
     * 刷新Token
     *
     */
    public function refresh()
    {
        //刪除源Token
        $token = $this->auth->getToken();
        \app\common\library\Token::delete($token);
        //創建新Token
        $token = Random::uuid();
        \app\common\library\Token::set($token, $this->auth->id, 2592000);
        $tokenInfo = \app\common\library\Token::get($token);
        $this->success('', ['token' => $tokenInfo['token'], 'expires_in' => $tokenInfo['expires_in']]);
    }
}
