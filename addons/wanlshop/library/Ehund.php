<?php
namespace addons\wanlshop\library;

final class Ehund
{

    private $secretKey;
	private $callbackUrl;

    public function __construct($secretKey ,$callbackUrl = '')
    {
        $this->secretKey = $secretKey;
		$this->callbackUrl = $callbackUrl;
    }
	
	/**
	 * 生成加密串
	 * @param {Object} $number 快递号
	 */
    public function sign($number)
    {
        return md5(hash_hmac('sha1', $number, $this->secretKey, true));
    }
	
	/**
	 * 订阅快递
	 * @param {Object} $data 快递数组
	 */
	public function subScribe($company = '' ,$number = 0)
	{
		//参数设置
	    $param = array (
			'company' => $company,//快递公司编码
			'number' => $number,//快递单号
			'key' => $this->secretKey, 
			'parameters' => array (
				'callbackurl' => $this->callbackUrl,//回调地址
				'salt' => $this->sign($number),
				'resultv2' => '1',//行政区域解析
				'autoCom' => '0'//单号智能识别
			)
		);
		//请求参数
	    $post_data = array();
	    $post_data["schema"] = 'json';
	    $post_data["param"] = json_encode($param);
		$params = "";
	    foreach ($post_data as $k=>$v) {
	        $params .= "$k=".urlencode($v)."&";	//默认UTF-8编码格式
	    }
	    $post_data = substr($params, 0, -1);
		// 请求数据
		$result = $this->curlPost('http://poll.kuaidi100.com/poll', $post_data);
		$data = str_replace("\"", '"', $result );
		$data = json_decode($data, true); 
		return $data;
	}
	
	/**
	 * POST请求
	 * @param {Object} $post_url
	 * @param {Object} $post_data
	 */
	public function curlPost($post_url, $post_data)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_URL, $post_url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    return curl_exec($ch);
	}
	
	
}
