<?php
namespace addons\wanlshop\library\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

use Workerman\Worker;
use GatewayWorker\Register;

use Workerman\WebServer;
use GatewayWorker\Gateway;
use GatewayWorker\BusinessWorker;
use Workerman\Autoloader;

// 自动加载类
require_once ADDON_PATH . 'wanlshop' . DS . 'library' . DS . 'GatewayWorker' . DS . 'vendor' . DS . 'autoload.php';

class Chat extends Command
{
    protected function configure()
    {
        $this->setName('wanlshop:chat')
			->addArgument('action', Argument::OPTIONAL, "start|stop|restart|reload|status|connections", 'start')
			->addOption('deploy', null, Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY, 'Distributed Deployment', null)
			->addOption('daemon', 'd', Option::VALUE_NONE, 'Run the workerman server in daemon mode.')
			->setDescription('Wanlshop im instant messaging system');
    }

    protected function execute(Input $input, Output $output)
    {
		
		$action = $input->getArgument('action');
		if (DIRECTORY_SEPARATOR !== '\\') {
		    if (!in_array($action, ['start', 'stop', 'reload', 'restart', 'status', 'connections'])) {
		        $output->writeln("<error>Invalid argument action:{$action}, Expected start|stop|restart|reload|status|connections .</error>");
		        return false;
		    }
		    global $argv;
		    array_shift($argv);
		    array_shift($argv);
		    array_unshift($argv, 'think', $action);
		} elseif ('start' != $action) {
		    $output->writeln("<error>Not Support action:{$action} on Windows.</error>");
		    return false;
		}
		
		if ('start' == $action) {
		    $output->writeln('Starting GatewayWorker server...');
		}
		
		if ($this->getDeployOption('register')) {
		    // 分布式部署的时候其它服务器可以关闭register服务
		    // 注意需要设置不同的lanIp
		    $this->register();
		}
		
		// 启动businessWorker
		if ($this->getDeployOption('business')) {
		    $this->businessWorker();
		}
		
		// 启动gateway
		if ($this->getDeployOption('gateway')) {
		    $this->gateway();
		}
		
		Worker::runAll();
    }
	
	/**
	 * 启动register
	 * @access public
	 * @return void
	 */
	public function register()
	{
	    // 初始化register
	    new Register('text://0.0.0.0:1239');
	}
	
	// 初始化 bussinessWorker 进程
	public function businessWorker()
	{
		// bussinessWorker 进程
		$worker = new BusinessWorker();
		// worker名称
		$worker->name = 'WanlBusinessWorker';
		// bussinessWorker进程数量
		$worker->count = 4;
		// 服务注册地址
		$worker->registerAddress = '127.0.0.1:1239';
		// 需要将eventHandler的默认值Events修改成Event就可以了
		$worker->eventHandler = 'addons\\wanlshop\\library\\WanlChat\\GatewayWorker';
	}
	
	// 初始化 gateway 进程
	public function gateway()
	{
		// wss服务证书
		// $context = array(
		//     'ssl' => array(
		//         // 请使用绝对路径
		//         'local_cert'	=> '/www/wwwroot/wanlshop/addons/wanlshop/library/GatewayWorker/ssl/chat.pem', // 也可以是crt文件
		//         'local_pk'		=> '/www/wwwroot/wanlshop/addons/wanlshop/library/GatewayWorker/ssl/chat.key',
		//         'verify_peer'	=> false,
		//         // 'allow_self_signed' => true, //如果是自签名证书需要开启此选项
		//     )
		// );
		// websocket协议(端口任意，只要没有被其它程序占用就行)
		// $gateway = new Gateway("websocket://0.0.0.0:8282", $context);
		$gateway = new Gateway("websocket://0.0.0.0:8282");
		// 开启SSL，websocket+SSL 即wss
		// $gateway->transport = 'ssl';
		// gateway名称，status方便查看
		$gateway->name = 'WanlGateway';
		// gateway进程数
		$gateway->count = 4;
		// 本机ip，分布式部署时使用内网ip
		$gateway->lanIp = '127.0.0.1';
		// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
		// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口 
		$gateway->startPort = 2900;
		// 服务注册地址
		$gateway->registerAddress = '127.0.0.1:1239';
		// 心跳间隔
		$gateway->pingInterval = 10;
		// 心跳数据
		$gateway->pingData = '{"type":"ping"}';
		
		// 全局静态属性
		if($this->input->hasOption('daemon')){
			// 以daemon(守护进程)方式运行
			Worker::$daemonize = true;
		}
		Worker::$pidFile = '/var/run/wanlchat.pid';
	}
	
	protected function getDeployOption($name){
	    if ($this->input->hasOption('deploy')) {
	        $deployList =  $this->input->getOption('deploy');
	        return in_array($name,$deployList) ? true : false;
	    }
	    return true;  //默认全部
	}
}