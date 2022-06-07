<?php

namespace addons\wanlshop\library\WanlChat;

use addons\wanlshop\library\WanlChat\GatewayClient;



/**

 * WanlChat 即时通讯

 * @author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * @link http://www.wanlshop.com

 * 

 * @careful 即时通讯作未经版权所有权人书面许可，不得自行复制到第三方系统使用、二次开发、分支、复制和商业使用！

 * @creationtime  2019年10月10日16:22:51

 * @lasttime 2020年6月10日22:56:14

 * @version V0.0.1 http://doc2.workerman.net/326118

 **/

class WanlChat

{

	/**

	 * 这里填写Register服务的ip和Register端口

	 * 这里假设GatewayClient和Register服务都在一台服务器上，ip填写127.0.0.1。

	 * 如果不在一台服务器则填写真实的Register服务的内网ip(或者外网ip)

	 */

	protected $register = "127.0.0.1:1239";

	

	public function __construct() 

	{

		GatewayClient::$registerAddress = $this->register;

	}

	

	/**

	 * 判断服务器是否启动 即时通讯

	 */

	public function isWsStart()

    {

        try {

            $client = stream_socket_client('tcp://' . $this->register, $errno, $errmsg, 3);

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }

	

	/**

	 * 将 client_id 与 uid 绑定

	 *

	 * @param string $client_id 

	 */

	public function bind($client_id='', $uid= 0)

	{

		return GatewayClient::bindUid($client_id, $uid);

	}

	

	/**

	 * 将 client_id 与 uid 解除绑定

	 *

	 * @param int        $client_id

	 * @param int|string $uid

	 * @return void

	 */

	public function unbind($client_id='', $uid= 0)

	{

		return GatewayClient::unbindUid($client_id, $uid);

	}

	

	/**

	 * 获取与 uid 绑定的 client_id 列表

	 *

	 * @param string $uid

	 * @return array

	 */

	public static function getUidToClientId($uid)

	{

		return GatewayClient::getClientIdByUid($uid);

	}

	

	/**

	 * 判断某个uid是否在线

	 *

	 * @param string $uid

	 * @return int 0|1

	 */

	public static function isOnline($uid)

	{

		return GatewayClient::isUidOnline($uid);

	}

	

	/**

	 * 向 uid 发送

	 *

	 * @param int|string|array $uid

	 * @param array $message

	 *

	 * @return void

	 */

	public static function send($uid = 0, $message = [])

    {

        GatewayClient::sendToUid($uid, json_encode($message));

    }

	

	/**

	 * 向 group 发送

	 *

	 * @param int|string|array $group             组（不允许是 0 '0' false null array()等为空的值）

	 * @param string           $message           消息

	 * @param array            $exclude_client_id 不给这些client_id发

	 * @param bool             $raw               发送原始数据（即不调用gateway的协议的encode方法）

	 *

	 * @return void

	 */

	public static function sendGroup($group, $message)

	{

		return GatewayClient::sendToGroup($group, json_encode($message), $exclude_client_id = null, $raw = false);

	}

	

	/**

	 * 获取所有在线的群组id

	 *

	 * @return array

	 */

	public static function getAllGroupIdList()

	{

		return GatewayClient::getAllGroupIdList();

	}

	

	/**

	 * 获取所有在线分组的uid数量，也就是每个分组的在线用户数

	 *

	 * @return array

	 */

	public static function getAllGroupUidCount()

	{

		return GatewayClient::getAllGroupUidCount();

	}

	

	/**

     * 获取某个群组在线uid列表

     *

     * @param string $group

     * @return array

     */

    public static function getUidListByGroup($group)

	{

		return GatewayClient::getUidListByGroup($group);

	}



	/**

     * 获取某个群组在线uid数

     *

     * @param string $group

     * @return int

     */

    public static function getUidCountByGroup($group)

	{

		return GatewayClient::getUidCountByGroup($group);

	}

	

	/**

     * 将 client_id 加入组

     *

     * @param int        $client_id

     * @param int|string $group

     * @return void

     */

    public static function joinGroup($client_id, $group)

	{

		return GatewayClient::joinGroup($client_id, $group);

	}



	/**

     * 将 client_id 离开组

     *

     * @param int        $client_id

     * @param int|string $group

     *

     * @return void

     */

    public static function leaveGroup($client_id, $group)

	{

		return GatewayClient::leaveGroup($client_id, $group);

	}



	/**

     * 取消分组

     *

     * @param int|string $group

     *

     * @return void

     */

    public static function ungroup($group)

	{

		return GatewayClient::ungroup($group);

	}

	

	/**

	 * 踢掉某个客户端并直接立即销毁相关连接

	 *

	 * @param int $client_id

	 * @return bool

	 */

	public static function destoryClient($client_id)

	{

	    return GatewayClient::destoryClient($client_id);

	}

	

	/**

	 * 踢掉某个客户端，并以$message通知被踢掉客户端

	 *

	 * @param int $client_id

	 * @param string $message

	 * @return void

	 */

	public static function closeClient($client_id, $message = null)

	{

	    return GatewayClient::closeClient($client_id, $message = null);

	}

}