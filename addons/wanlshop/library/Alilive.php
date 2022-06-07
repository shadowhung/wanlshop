<?php
namespace addons\wanlshop\library;

final class Alilive
{

    private $liveDomain; // 播域名
	private $pushDomain; // 推域名
	private $builderTime; // 有效时间
	private $pushKey; // 推秘钥
	private $liveKey; // 播秘钥
	private $appName; // 直播项目
	private $streamName;  //流名
	private $shopId;  //商家ID
	private $transTemplate; // 转码模板
	

    public function __construct($liveDomain, $pushDomain, $builderTime, $pushKey, $liveKey, $appName, $streamName, $shopId, $transTemplate = '')
    {
        $this->liveDomain = $liveDomain;
		$this->pushDomain = $pushDomain;
		$this->builderTime = time() + 60 * $builderTime;
		$this->pushKey = $pushKey;
		$this->liveKey = $liveKey;
		$this->appName = $appName;
		$this->streamName = $streamName;
		$this->shopId = $shopId ? $shopId : 0;
		$this->transTemplate = $transTemplate ? '_'.$transTemplate : '';
    }
	
	public function urlBuilder()
	{
		return [
			'pushurl' => "rtmp://$this->pushDomain/$this->appName/$this->streamName?auth_key=$this->builderTime-$this->shopId-0-".$this->auth_key('pushurl'),
			'rtmpurl' => "rtmp://$this->liveDomain/$this->appName/$this->streamName$this->transTemplate?auth_key=$this->builderTime-$this->shopId-0-".$this->auth_key('rtmpurl'),
			'm3u8url' => "https://$this->liveDomain/$this->appName/$this->streamName$this->transTemplate.m3u8?auth_key=$this->builderTime-$this->shopId-0-".$this->auth_key('m3u8url')
		];
	}
	
	/**
	 * 生成加密串
	 * @param {Object}
	 */
	public function auth_key($type)
	{
	    switch ($type)
		{
			case 'pushurl':
				return md5("/$this->appName/$this->streamName-$this->builderTime-$this->shopId-0-$this->pushKey");
				break;  
			case 'rtmpurl':
				return md5("/$this->appName/$this->streamName$this->transTemplate-$this->builderTime-$this->shopId-0-$this->liveKey");
				break;
			case 'm3u8url':
				return md5("/$this->appName/$this->streamName$this->transTemplate.m3u8-$this->builderTime-$this->shopId-0-$this->liveKey");
				break;
	    }
	}
}
