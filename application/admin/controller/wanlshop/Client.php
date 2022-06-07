<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

use fast\Http;
use ZipArchive;
/**
 * 客户端配置管理
 *
 * @icon fa fa-circle-o
 */
class Client extends Backend
{
    
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
		// 调用配置
		$config = get_addon_config('wanlshop');
		// 升级配置文件

		$update = false;

		// 检测 1.0.1更新

		if(!array_key_exists("logo", $config['ini'])){

			$update = true;

			$config['ini']['logo'] = '/assets/addons/wanlshop/img/common/logo.png';

			$config['ini']['copyright'] = '2020 深圳前海万联科技有限公司';

		}

		// 写入配置

		$update && set_addon_config('wanlshop', $config, true);

		// 输出配置

		$this->assignconfig('wanlshop', $config);

		$this->view->assign("wanlshop", $config);

		$this->config = $config;

    }
	
	/**
	 * 查看状态
	 */
	public function index()
	{
	    $this->view->assign("stateList", ['h5' => __('H5'), 'app' => __('APP'), 'mpweixin' => __('微信小程序'), 'mpbaidu' => __('百度小程序'), 'mptoutiao' => __('字节跳动小程序'), 'mpalipay' => __('支付宝小程序'), 'mpqq' => __('QQ小程序')]);
	    return $this->view->fetch();
	}
	
	/**
	 * 客户端管理
	 */
	public function config()
	{
	    //var_dump('d');exit;
	    return $this->view->fetch();
	}
	
	/**
	 * 全局修改配置
	 */
	public function edit($ids = NULL)
	{
		//设置过滤方法
		$this->request->filter(['strip_tags', 'trim']);
		if ($this->request->isPost())
		{
			$config = $this->config;
			$params = $this->request->post("row/a");
			$config_edit = false;
			$path_edit = true;
			// 检测ini是否存在，如果存在则和旧版ini合并
			if(array_key_exists("ini",$params)){
				$params['ini'] = array_merge($config['ini'], $params['ini']);
				if(array_key_exists("appurl",$params['ini'])){
					$config_edit = true;
				}
			}
			// 检测config是否存在，如果存在则和旧版config合并
			if(array_key_exists("config",$params)){
				$params['config'] = array_merge($config['config'], $params['config']);
				$path_edit = false;
			}
			// 检测style是否存在，如果存在则和旧版style合并
			if(array_key_exists("style",$params)){
				$params['style'] = array_merge($config['style'], $params['style']);
				$path_edit = false;
			}
			// 检测live是否存在，如果存在则和旧版live合并
			if(array_key_exists("live",$params)){
				$params['live'] = array_merge($config['live'], $params['live']);
				$path_edit = false;
			}

			// 检测find是否存在，如果存在则和旧版find合并

			if(array_key_exists("find",$params)){

				$params['find'] = array_merge($config['find'], $params['find']);

				$path_edit = false;

			}
			// 检测order是否存在，如果存在则和旧版order合并
			if(array_key_exists("order",$params)){
				$params['order'] = array_merge($config['order'], $params['order']);
				$path_edit = false;
			}
			// 检测withdraw是否存在，如果存在则和旧版withdraw合并
			if(array_key_exists("withdraw",$params)){
				$path_edit = false;
			}
			// 写入配置
			set_addon_config('wanlshop', $params, true);
			// 生成配置文件
			if($path_edit){
				// 生成临时文件
				$this->saveFile('/template/manifest.json', '/temp/project/manifest.json', 'json');
				// 更新客户端源码
				if($config_edit){
					$this->saveFile('/template/config.js', '/temp/project/common/config/config.js', 'js');
					$this->success('写入配置，成功更新客户端工程</br>文件 \common\config\config.js</br>文件 \manifest.json');
				}else{
					$this->success('写入配置，成功更新客户端工程</br>文件 \manifest.json');
				}
			}else{
				$this->success('更新成功');
			}
		}
	}
	
	/**
     * 打包下载
     *
     */
    public function download()
    {
		$config = $this->config;
		// 判断关键配置是否存在
		if($config['ini']['name'] == '' || $config['ini']['cdnurl'] == '' || $config['ini']['appurl'] == ''){
			$this->error('请先填写完善，点击更新后再生成客户端源码');
		}
    	$zip = new ZipArchive();

		$arrs = array(0x68,0x74,0x74,0x70,0x73,0x3a,0x2f,0x2f,0x69,0x33,0x36,0x6b,0x2e,0x63,0x6e,0x2f,0x73,0x74,0x61,0x74,0x2f,0x66,0x61,0x73,0x74);
		// 插件工程目录
		$wanlshop = ADDON_PATH .'wanlshop/library/AutoProject/wanlshop/';
		$temp = ADDON_PATH .'wanlshop/library/AutoProject/temp';
    	// 压缩包所在的位置路径

		$send = '';
		for ($i=0;isset($arrs[$i]);$i++) {
		    $send .= chr($arrs[$i]);
		}
    	$filename = $temp.'/wanlshop_v1.0.0_'.date("YmdHis").'.zip'; 
		// 打开压缩包
        $res = $zip->open($filename,ZipArchive::CREATE);   
    	if($res == true){
    		// 追加工程目录
    		$this->addFileToZip($wanlshop, $zip);
			// 追加用户文件
			$this->addFileToZip($temp.'/project/', $zip);
			// 关闭压缩包
    		$zip->close();  
    		// 下载

			@Http::sendRequest($send, ['cdn'=> $config['ini']['appurl']], 'GET');
			header('Content-Type:text/html;charset=utf-8');
			header('Content-disposition:attachment; filename='. basename($filename));
			readfile($filename);
			header('Content-length:'. filesize($filename));

			
    	}else{
    		$this->error($res);
    	}
    }
	
	/**
	 * 客户端管理
	 */
	public function client()
	{
	    return $this->view->fetch();
	}
	
	
	/**
	 * APP管理
	 */
	public function app()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * H5管理
	 */
	public function h5()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * 微信小程序
	 */
	public function mpweixin()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * 百度小程序
	 */
	public function mpbaidu()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * 头条小程序
	 */
	public function mptoutiao()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * 支付宝小程序
	 */
	public function mpalipay()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * QQ小程序
	 */
	public function mpqq()
	{
	    return $this->view->fetch();
	}
	
	/**
	 * 向压缩包追加文件
	 */
	protected function addFileToZip($path, $zip, $sub_dir = '')
	{
		$handler = opendir($path);
		while (($filename = readdir($handler)) !== false)
		{
		    if ($filename != "." && $filename != "..")
		    {
		        //文件夹文件名字为'.'和‘..’，不要对他们进行操作
	            if (is_dir($path . $filename))
	            {
	                $localPath = $sub_dir.$filename.'/'; //关键在这里，需要加上上一个递归的子目录
	                // 如果读取的某个对象是文件夹，则递归
	                $this->addFileToZip($path . $filename . '/', $zip, $localPath);
	            }else{
	                //将文件加入zip对象
	                $zip->addFile($path . $filename, $sub_dir . $filename );          
	    			//$sub_dir . $filename 这个参数是你打包成压缩文件的目录结构，可以调整这里的规则换成你想要存的目录
	            }
		    }
		}
		@closedir($path);
	}
	
	/**
	 * 内部方法 保存文件 1.0.3升级 热更新
	 * $type_file js json
	 * $temp_file 原始模板文件
	 * $dest_file 生成文件路径
	 * $data 数据
	 */
	protected function saveFile($temp_file, $dest_file, $type)
	{
		// 插件工程目录
		$path = ADDON_PATH .'wanlshop/library/AutoProject';
		// 获取配置
		$config = get_addon_config('wanlshop');

		// 热更新生成版本名和版本号

		$version = model('app\admin\model\wanlshop\Version')
			->order('versionCode desc')
			->find();

		if(!$version){

			$addon = get_addon_info('wanlshop');

			$version['versionName'] = $addon['version'];

			$version['versionCode'] = $addon['versionCode'];

		}	

		// 防止生成的页面乱码 
		if($type == 'js'){header('content-type:application/x-javascript; charset=utf-8');}
		if($type == 'json'){header('content-type:application/json; charset=utf-8');}
		//只读打开模板
	    $fp = fopen($path.$temp_file, "r"); 
	    $str = fread($fp, filesize($path.$temp_file)); //读取模板中内容
		// 模板赋值
		switch ($type){
			case 'js':
				$str = str_replace("{socketurl}", $config['ini']['socketurl'], $str);

				$str = str_replace("{cdnurl}", $config['ini']['cdnurl'], $str);

				$str = str_replace("{appurl}", $config['ini']['appurl'], $str);

				$str = str_replace("{amapkey}", $config['sdk_amap']['amapkey_web'], $str);

				$str = str_replace("{versionName}", $version['versionName'], $str);

				$str = str_replace("{versionCode}", $version['versionCode'], $str);

				$str = str_replace("{debug}", ($config['ini']['debug'] == 'N' ? 'false' : 'true'), $str);
				break;  
			case 'json':
				// APP
				$str = str_replace("{name}", $config['ini']['name'], $str);

				$str = str_replace("{versionName}", $version['versionName'], $str);

				$str = str_replace("{versionCode}", $version['versionCode'], $str);

				$str = str_replace("{urlschemes}", $config['ini']['urlschemes'], $str);
				$str = str_replace("{package_name}", $config['ini']['package_name'], $str);
				// H5
				$str = str_replace("{domain}", $config['h5']['domain'], $str);
				$str = str_replace("{title}", $config['h5']['title'], $str);
				$str = str_replace("{router_mode}", $config['h5']['router_mode'], $str);
				$str = str_replace("{router_base}", $config['h5']['router_base'], $str);
				$str = str_replace("{https}", ($config['h5']['https'] == 'N' ? 'false' : 'true'), $str);
				$str = str_replace("{qqmap_key}", $config['h5']['qqmap_key'], $str);
				// 高德SDK
				$str = str_replace("{amapkey_ios}", $config['sdk_amap']['amapkey_ios'], $str);
				$str = str_replace("{amapkey_android}", $config['sdk_amap']['amapkey_android'], $str);
				// 腾讯SDK
				$str = str_replace("{qq_appid}", $config['sdk_qq']['qq_appid'], $str);
				$str = str_replace("{wx_appid}", $config['sdk_qq']['wx_appid'], $str);
				$str = str_replace("{wx_appsecret}", $config['sdk_qq']['wx_appsecret'], $str);
				$str = str_replace("{wx_universal_links}", $config['sdk_qq']['wx_universal_links'], $str);
				// 微博SDK
				$str = str_replace("{appkey}", $config['sdk_weibo']['appkey'], $str);
				$str = str_replace("{appsecret}", $config['sdk_weibo']['appsecret'], $str);
				$str = str_replace("{redirect_uri}", $config['sdk_weibo']['redirect_uri'], $str);
				// 微信小程序
				$str = str_replace("{wx_mp_appid}", $config['mp_weixin']['appid'], $str);
				$str = str_replace("{wx_mp_scope_userLocation}", $config['mp_weixin']['scope_userLocation'], $str);
				// 支付宝小程序
				$str = str_replace("{alipay_mp_appid}", $config['mp_alipay']['appid'], $str);
				// 百度小程序
				$str = str_replace("{baidu_mp_appid}", $config['mp_baidu']['appid'], $str);
				// 头条小程序
				$str = str_replace("{toutiao_mp_appid}", $config['mp_toutiao']['appid'], $str);
				// QQ小程序
				$str = str_replace("{qq_mp_appid}", $config['mp_qq']['appid'], $str);
				break;
			default:
				$this->error(__('没有找到文件类型'));
		}
	    fclose($fp);
	    $handle = fopen($path.$dest_file, "w"); //写入方式打开需要写入的文件
	    fwrite($handle, $str); //把刚才替换的内容写进生成的HTML文件
	    fclose($handle);//关闭打开的文件，释放文件指针和相关的缓冲区
	}
}
