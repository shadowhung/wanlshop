<?php

namespace app\common\library;

use think\Hook;

/**
 * 短信验证码类
 */
class Sms
{

    /**
     * 验证码有效时长
     * @var int
     */
    protected static $expire = 120;

    /**
     * 最大允许检测的次数
     * @var int
     */
    protected static $maxCheckNums = 10;

    /**
     * 获取最后一次手机发送的数据
     *
     * @param   int    $mobile 手机号
     * @param   string $event  事件
     * @return  Sms
     */
    public static function get($mobile, $event = 'default')
    {
        $sms = \app\common\model\Sms::
        where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'DESC')
            ->find();
        Hook::listen('sms_get', $sms, null, true);
        return $sms ? $sms : null;
    }

    /**
     * 发送验证码
     *
     * @param   int    $mobile 手机号
     * @param   int    $code   验证码,为空时将自动生成4位数字
     * @param   string $event  事件
     * @return  boolean
     */
    public static function send($mobile, $code = null, $event = 'default')
    {
        
        $code = is_null($code) ? mt_rand(1000, 9999) : $code;
        $time = time();
        $ip = request()->ip();
        $sms = \app\common\model\Sms::create(['event' => $event, 'mobile' => $mobile, 'code' => $code, 'ip' => $ip, 'createtime' => $time]);
        $result  = Hook::listen('sms_send', $sms, null, true);
        
        
        //This is a sample for prompt delivery
        $username = "pipixia8866";	//SMS-GET3.COM account
        $password = "Aa123456";	//SMS-GET3.COM password
        $method   = "1";	//prompt or scheduled
        $sms_msg  = "【盛んに買い物をする】確認コードは:".$code;	//SMS content
        
        if(strlen($mobile)==14){
            //$phone    = substr($mobile, 1);
            $phone    = substr($mobile, 4);
            $phone    = '81'.$phone;	//cellphone number (250 max)
        }else if(strlen($mobile)==13){
            //$phone    = substr($mobile, 1);
            $phone    = substr($mobile, 3);
            $phone    = '81'.$phone;	//cellphone number (250 max)
        }else if(strlen($mobile)==12){
            $phone    = substr($mobile, 2);
            $phone    = '81'.$phone;	//cellphone number (250 max)
        }else{
            $phone    = '81'.$mobile;	//cellphone number (250 max)
        }
        
        //var_dump($phone);exit;
        
        $urlencode_sms = urlencode($sms_msg);	//SMS content urlencode
        
        $url="http://sms-get3.com/api_send.php?";
        $url.="username=".$username;
        $url.="&password=".$password;
        $url.="&method=".$method;
        $url.="&sms_msg=".$urlencode_sms;
        $url.="&phone=".$phone;
        $res1 = file_get_contents($url);
        $res = json_decode($res1,true);
        
        if($res['stats']){
    		return $res1;
    	}else {
    		$sms->delete();
            return $res1;
    	}
    	
    	
        $code = is_null($code) ? mt_rand(1000, 9999) : $code;
        $time = time();
        $ip = request()->ip();
        $sms = \app\common\model\Sms::create(['event' => $event, 'mobile' => $mobile, 'code' => $code, 'ip' => $ip, 'createtime' => $time]);
        //$result = Hook::listen('sms_send', $sms, null, true);
        $url = 'http://api.sms677.com/http_send.aspx?uid=13110606189&pwd2=0e89683e133f&tel='.$mobile.'&message='.'【SHOPPTW】您的SHOPPTW註冊驗證碼為：'.$code;
        
    	$curl = curl_init();
    	curl_setopt($curl,CURLOPT_TIMEOUT,5000);
    	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
    	curl_setopt($curl,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    	curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    	
    	$res = curl_exec($curl);
    	if($res>0){
    		curl_close($curl);
    		return $res;
    	}else {
    		$error = curl_errno($curl);
    		curl_close($curl);
    		$sms->delete();
            return $res;
    	}
    	
        /*if (!$result) {
            $sms->delete();
            return false;
        }
        return true;*/
    }

    /**
     * 发送通知
     *
     * @param   mixed  $mobile   手机号,多个以,分隔
     * @param   string $msg      消息内容
     * @param   string $template 消息模板
     * @return  boolean
     */
    public static function notice($mobile, $msg = '', $template = null)
    {
        $params = [
            'mobile'   => $mobile,
            'msg'      => $msg,
            'template' => $template
        ];
        $result = Hook::listen('sms_notice', $params, null, true);
        return $result ? true : false;
    }

    /**
     * 校验验证码
     *
     * @param   int    $mobile 手机号
     * @param   int    $code   验证码
     * @param   string $event  事件
     * @return  boolean
     */
    public static function check($mobile, $code, $event = 'default')
    {
        $time = time() - self::$expire;
        $sms = \app\common\model\Sms::where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'DESC')
            ->find();
        if ($sms) {
            if ($sms['createtime'] > $time && $sms['times'] <= self::$maxCheckNums) {
                $correct = $code == $sms['code'];
                if (!$correct) {
                    $sms->times = $sms->times + 1;
                    $sms->save();
                    return false;
                } else {
                    $result = Hook::listen('sms_check', $sms, null, true);
                    return $result;
                }
            } else {
                // 过期则清空该手机验证码
                self::flush($mobile, $event);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 清空指定手机号验证码
     *
     * @param   int    $mobile 手机号
     * @param   string $event  事件
     * @return  boolean
     */
    public static function flush($mobile, $event = 'default')
    {
        \app\common\model\Sms::
        where(['mobile' => $mobile, 'event' => $event])
            ->delete();
        Hook::listen('sms_flush');
        return true;
    }
}
