<?php

namespace addons\wanlshop;

use app\common\library\Menu;
use think\Addons;
use think\Request;
use think\Console;
use think\Loader;

/**
 * 插件
 */
class Wanlshop extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
		$menu = include ADDON_PATH . 'wanlshop' . DS . 'data' . DS . 'menu.php';
        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete("wanlshop");
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable("wanlshop");
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable("wanlshop");
        return true;
    }
    
	/**
	 * 插件升级方法
	 */
	public function upgrade()
	{
	    $menu = include ADDON_PATH . 'wanlshop' . DS . 'data' . DS . 'menu.php';
	    Menu::upgrade('wanlshop', $menu);
	}
	
	
    /**
     * 添加命令行扩展
     */
    public function appInit()
    {
		Console::addDefaultCommands([
		    'addons\\wanlshop\\library\\command\\Chat',
		    'addons\\wanlshop\\library\\command\\Order',
		]);
		// 添加第三方支付
		Loader::addNamespace('WanlPay\Yansongda', ADDON_PATH . 'wanlshop' . DS . 'library' . DS . 'WanlPay' . DS . 'Yansongda' . DS);
		Loader::addNamespace('WanlPay\Supports', ADDON_PATH . 'wanlshop' . DS . 'library' . DS . 'WanlPay' . DS . 'Supports' . DS);
    }
    
    /**
     * 会员中心边栏后
     * @return mixed
     * @throws \Exception
     */
    public function userSidenavAfter()
    {
        $request = Request::instance();
        $actionname = strtolower($request->action());
        $data = [
            'actionname' => $actionname
        ];
        return $this->fetch('view/hook/user_sidenav_after', $data);
    }
}
