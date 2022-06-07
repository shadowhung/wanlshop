<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\Ems as Emslib;
use app\common\model\User;

/**
 * 邮箱验证码接口
 */
class Ems extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
        \think\Hook::add('ems_send', function ($params) {
            $obj = \app\common\library\Email::instance();
            $result = $obj
                ->to($params->email)
                ->subject('検証コード')
                ->message("確認コードは：" . $params->code)
                ->send();
            return $result;
        });
    }

    /**
     * 发送验证码
     *
     * @param string $email 邮箱
     * @param string $event 事件名称
     */
    public function send()
    {
        $email = $this->request->request("email");
        $event = $this->request->request("event");
        $event = $event ? $event : 'register';

        $last = Emslib::get($email, $event);
        if ($last && time() - $last['createtime'] < 60) {
            $this->error(__('頻繁に送信する'));
        }
        if ($event) {
            $userinfo = User::getByEmail($email);
            if ($event == 'register' && $userinfo) {
                //登録済み
                $this->error(__('登録済み'));
            } elseif (in_array($event, ['changeemail']) && $userinfo) {
                //被占用
                $this->error(__('すでに占領されている'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未登録
                $this->error(__('未登録'));
            }
        }
        $ret = Emslib::send($email, null, $event);
        if ($ret) {
            $this->success(__('正常に送信されました'));
        } else {
            $this->error(__('送信に失敗しました'));
        }
    }

    /**
     * 检测验证码
     *
     * @param string $email   邮箱
     * @param string $event   事件名称
     * @param string $captcha 验证码
     */
    public function check()
    {
        $email = $this->request->request("email");
        $event = $this->request->request("event");
        $event = $event ? $event : 'register';
        $captcha = $this->request->request("captcha");

        if ($event) {
            $userinfo = User::getByEmail($email);
            if ($event == 'register' && $userinfo) {
                //登録済み
                $this->error(__('登録済み'));
            } elseif (in_array($event, ['changeemail']) && $userinfo) {
                //被占用
                $this->error(__('すでに占領されている'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未登録
                $this->error(__('未登録'));
            }
        }
        $ret = Emslib::check($email, $captcha, $event);
        if ($ret) {
            $this->success(__('成功'));
        } else {
            $this->error(__('不正な確認コード'));
        }
    }
}
