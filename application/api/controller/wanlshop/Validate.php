<?php

namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use app\common\model\User;

/**
 * WanlShop驗證接口
 */
class Validate extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    protected $layout = '';
    protected $error = null;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 檢測郵箱
     *
     * @param string $email 郵箱
     * @param string $id    排除會員ID
     */
    public function check_email_available()
    {
        $email = $this->request->request('email');
        $id = (int)$this->request->request('id');
        $count = User::where('email', '=', $email)->where('id', '<>', $id)->count();
        if ($count > 0) {
            $this->error(__('メールボックスはすでに占有されています'));
        }
        $this->success();
    }

    /**
     * 檢測用戶名
     *
     * @param string $username 用戶名
     * @param string $id       排除會員ID
     */
    public function check_username_available()
    {
        $email = $this->request->request('username');
        $id = (int)$this->request->request('id');
        $count = User::where('username', '=', $email)->where('id', '<>', $id)->count();
        if ($count > 0) {
            $this->error(__('ユーザー名は既に使われています'));
        }
        $this->success();
    }

    /**
     * 檢測手機
     *
     * @param string $mobile 手機號
     * @param string $id     排除會員ID
     */
    public function check_mobile_available()
    {
        $mobile = $this->request->request('mobile');
        $id = (int)$this->request->request('id');
        $count = User::where('mobile', '=', $mobile)->where('id', '<>', $id)->count();
        if ($count > 0) {
            $this->error(__('電話番号はすでに使用されています'));
        }
        $this->success();
    }

    /**
     * 檢測手機
     *
     * @param string $mobile 手機號
     */
    public function check_mobile_exist()
    {
        $mobile = $this->request->request('mobile');
        $count = User::where('mobile', '=', $mobile)->count();
        if (!$count) {
            $this->error(__('電話番号が存在しません'));
        }
        $this->success();
    }

    /**
     * 檢測郵箱
     *
     * @param string $mobile 郵箱
     */
    public function check_email_exist()
    {
        $email = $this->request->request('email');
        $count = User::where('email', '=', $email)->count();
        if (!$count) {
            $this->error(__('メールは存在しません'));
        }
        $this->success();
    }

    /**
     * 檢測手機驗證碼
     *
     * @param string $mobile  手機號
     * @param string $captcha 驗證碼
     * @param string $event   事件
     */
    public function check_sms_correct()
    {
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        $event = $this->request->request('event');
        if (!\app\common\library\Sms::check($mobile, $captcha, $event)) {
            $this->error(__('不正な確認コード'));
        }
        $this->success();
    }

    /**
     * 檢測郵箱驗證碼
     *
     * @param string $email   郵箱
     * @param string $captcha 驗證碼
     * @param string $event   事件
     */
    public function check_ems_correct()
    {
        $email = $this->request->request('email');
        $captcha = $this->request->request('captcha');
        $event = $this->request->request('event');
        if (!\app\common\library\Ems::check($email, $captcha, $event)) {
            $this->error(__('不正な確認コード'));
        }
        $this->success();
    }
}
