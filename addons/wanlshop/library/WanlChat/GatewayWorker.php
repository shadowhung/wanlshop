<?php
/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);
namespace addons\wanlshop\library\WanlChat;
use GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class GatewayWorker
{
	// 当有客户端连接时，将client_id返回，让mvc框架判断当前uid并执行绑定
	public static function onConnect($client_id)
	{
		Gateway::sendToClient($client_id, json_encode(array(
			'type'      => 'init',
			'client_id' => $client_id
		)));
	}
	// GatewayWorker建议不做任何业务逻辑，onMessage留空即可
	public static function onMessage($client_id, $message){
		
	}
}