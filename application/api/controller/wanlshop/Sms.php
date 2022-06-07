<?php

namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use app\common\library\Sms as Smslib;
use app\common\model\User;
use think\Hook;

/**
 * 手機短信接口
 */
class Sms extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    /**
     * 發送驗證碼
     *
     * @param string $mobile 手機號
     * @param string $event 事件名稱
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
        $ret = Smslib::send($mobile, mt_rand(100000, 999999), $event);
        $ret = json_decode($ret,true);
        
        if($ret['stats']){
    		$this->success(__('正常に送信されました'));
    	}else {
    	    switch ($ret['error_code']) {
    	        case '000': $this->error(__('成功'));break;
    	        case '001': $this->error(__('パラメータエラー'));break;
    	        case '002': $this->error(__('予約時間パラメータが間違っています'));break;
    	        case '003': $this->error(__('予約期限が切れました'));break;
    	        case '004': $this->error(__('メッセージの長さが長すぎます'));break;
    	        case '005': $this->error(__('アカウントのパスワードが正しくありません'));break;
    	        case '006': $this->error(__('IP アクセスできません'));break;
    	        case '007': $this->error(__('受信者の数は 0'));break;
    	        case '008': $this->error(__('受信者が超過 250 人'));break;
    	        case '009': $this->error(__('不十分なポイント'));break;
    	        /*case '-21': $this->error(__('権限エラーアカウント、パスワードエラーの1つ'));break;
    	        case '-22': $this->error(__('権限エラーアカウントが無効または無効になっています'));break;
    	        case '-23': $this->error(__('telに送信できる携帯電話番号がないか、telが空です'));break;
    	        case '-27': $this->error(__('メッセージのテキストに不適切なテキストが含まれているようです。再送してください'));break;
    	        case '-29': $this->error(__('メッセージの内容が長すぎます'));break;
    	        case '-30': $this->error(__('sendtime時間フォーマットエラー'));break;
    	        case '-31': $this->error(__('SMSクレジット残高が不足しています'));break;
    	        case '-36': $this->error(__('台湾番号を送信する許可がありません'));break;
    	        case '-37': $this->error(__('大陸番号を送信する許可がありません'));break;
    	        case '-38': $this->error(__('国際番号を送信する許可がありません'));break;
    	        case '-40': $this->error(__('間違ったユーザーアカウントまたはAPIチャネル暗号化キーが正しくありません（pwd2エラー）'));break;
    	        case '-41': $this->error(__('API制限付きIPロケーション'));break;
    	        case '-42': $this->error(__('APIIPの場所がカスタム設定と一致しません'));break;
    	        case '-43': $this->error(__('APIが有効になっていないか、このアカウントが見つかりません'));break;
    	        case '-44': $this->error(__('API送信頻度が制限を超えており、各トランザクション間の間隔は100ミリ秒（0.1秒）より長くする必要があります'));break;
    	        case '-51': $this->error(__('重要なパラメータが不完全または空です'));break;
    	        case '-99': $this->error(__('システムメンテナンス、お待ちください'));break;
    	        case '-100': $this->error(__('その他のエラー'));break;*/
    	        default:break;
    	    }
            $this->error(__('送信に失敗しました。SMSの設定が正しいかどうかを確認してください'));
    	}
    }

    /**
     * 檢測驗證碼
     *
     * @param string $mobile 手機號
     * @param string $event 事件名稱
     * @param string $captcha 驗證碼
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