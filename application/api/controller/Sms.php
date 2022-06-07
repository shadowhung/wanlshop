<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\Sms as Smslib;
use app\common\model\User;
use think\Hook;

/**
 * 手机短信接口
 */
class Sms extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    /**
     * 发送验证码
     *
     * @param string $mobile 手机号
     * @param string $event 事件名称
     */
    public function send()
    {
        $mobile = $this->request->request("mobile");
        $event = $this->request->request("event");
        $event = $event ? $event : 'register';

        if (!$mobile || !\think\Validate::regex($mobile, "^\d{8,15}$")) {
            $this->error(__('間違った電話番号'));
        }
        $last = Smslib::get($mobile, $event);
        if ($last && time() - $last['createtime'] < 60) {
            $this->error(__('頻繁に送信する'));
        }
        $ipSendTotal = \app\common\model\Sms::where(['ip' => $this->request->ip()])->whereTime('createtime', '-1 hours')->count();
        if ($ipSendTotal >= 5) {
            $this->error(__('頻繁に送信する'));
        }
        if ($event) {
            $userinfo = User::getByMobile($mobile);
            if ($event == 'register' && $userinfo) {
                //登録済み
                $this->error(__('登録済み'));
            } elseif (in_array($event, ['changemobile']) && $userinfo) {
                //被占用
                $this->error(__('すでに占領されている'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未登録
                $this->error(__('未登録'));
            }
        }
        if (!Hook::get('sms_send')) {
            $this->error(__('SMS検証プラグインをバックグラウンドプラグイン管理にインストールしてください'));
        }
        $ret = Smslib::send($mobile, null, $event);
        if ($ret) {
            $this->success(__('正常に送信されました'));
        } else {
            $this->error(__('送信に失敗しました。SMSの設定が正しいかどうかを確認してください'));
        }
    }

    /**
     * 检测验证码
     *
     * @param string $mobile 手机号
     * @param string $event 事件名称
     * @param string $captcha 验证码
     */
    public function check()
    {
        $mobile = $this->request->request("mobile");
        $event = $this->request->request("event");
        $event = $event ? $event : 'register';
        $captcha = $this->request->request("captcha");

        if (!$mobile || !\think\Validate::regex($mobile, "^\d{8,15}$")) {
            $this->error(__('間違った電話番号'));
        }
        if ($event) {
            $userinfo = User::getByMobile($mobile);
            if ($event == 'register' && $userinfo) {
                //登録済み
                $this->error(__('登録済み'));
            } elseif (in_array($event, ['changemobile']) && $userinfo) {
                //被占用
                $this->error(__('すでに占領されている'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未登録
                $this->error(__('未登録'));
            }
        }
        $ret = Smslib::check($mobile, $captcha, $event);
        if ($ret) {
            $this->success(__('成功'));
        } else {
            $this->error(__('不正な確認コード'));
        }
    }
}
