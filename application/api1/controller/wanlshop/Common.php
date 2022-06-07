<?php
// 2020年2月18日18:16:41
// 修改 2020年7月26日06:55:45

// 修改 2020年11月22日18:36:01
namespace app\api1\controller\wanlshop;

use app\common\controller\Api;
use OSS\Core\OssException;
use OSS\OssClient;
use fast\Random;

use fast\Tree;
use think\Config;
use think\Db;
use think\Hook;

/**
 * WanlShop公共接口
 */
class Common extends Api
{
    protected $noNeedLogin = ['init','search','update','adverts','searchList','setSearch','about'];
	protected $noNeedRight = ['*'];
    
	/**
	 * 一次性加载App
	 *
	 * @ApiSummary  (WanlShop 获取首页、购物车、类目数据)
	 * @ApiMethod   (GET)
	 *
	 */
    public function init()
    {
		// 首页
		$homeList = model('app\api1\model\wanlshop\Page')
			->where('type','index')
			->field('page, item')
			->find();			
		if(!$homeList){
			$this->error(__('尚未添加首页，请到后台【页面管理】添加首页'));
		}
		// 类目
		$tree = Tree::instance();
		$tree->init(model('app\api1\model\wanlshop\Category')->where(['type' => 'goods', 'isnav' => 1])->field('id, pid, name, image')->order('weigh asc')->select());
		// 搜索关键字
		$searchList = model('app\api1\model\wanlshop\Search')
			->where(['flag' => 'index'])
			->field('keywords')
			->order('views desc')
			->limit(10)
		    ->select();
		// 获取配置
		$config = get_addon_config('wanlshop');
		// 一次性获取模块
		$modulesData  = [
			"homeModules" => $homeList,
			"categoryModules" => $tree->getTreeArray(0),
			"searchModules" => $searchList
		];
		// 追加h5地址用于分享二维码等
		$config['config']['domain'] = $config['h5']['domain'].($config['h5']['router_mode'] == 'hash' ? '/#':'');
		// 输出
		$this->success('返回成功', [
			"modulesData" => $modulesData,
			"appStyle" => $config['style'],
			"appConfig" => $config['config'],
			"serviceVersion" => '202006183294701'  //数据版本号必须是整数
		]);
    }
	
	/**
	 * APP热更新 1.0.3升级
	 *
	 * @ApiSummary  (WanlShop APP热更新)
	 * @ApiMethod   (GET)
	 *
	 */
	public function update()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		$row = model('app\api1\model\wanlshop\Version')
			->order('versionCode desc')
			->find();

		$this->success('返回成功', $row);	
	}
	
	
	
	/**
	 * 加载广告
	 *
	 * @ApiSummary  (WanlShop 加载广告)
	 * @ApiMethod   (GET)
	 *
	 */
	public function adverts()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		$data = [
			'openAdverts' => [],
			'pageAdverts' => [],
			'categoryAdverts' => [],
			'firstAdverts' => [],
			'otherAdverts' => []
		];
		$list = model('app\api1\model\wanlshop\Advert')
			->field('id,category_id,media,module,type,url')
			->select();
		foreach ($list as $value) {
			$category_id = $value['category_id'];
			unset($value['category_id']);
			if($value['module'] == 'open'){
				$openData[] = $value;
				$data['openAdverts'] = $openData[array_rand($openData,1)];
			}
			if($value['module'] == 'page'){
				$data['pageAdverts'][] = $value;
			}
			if($value['module'] == 'category'){
				$data['categoryAdverts'][$category_id][] = $value;
			}
			if($value['module'] == 'first'){
				$data['firstAdverts'][] = $value;
			}
			if($value['module'] == 'other'){
				$data['otherAdverts'][] = $value;
			}
		}
		// 通过大版本号查询，对应数据，未来版本升级开发
		$version = $this->request->request("version", '');
		$this->success('返回成功', ['data' => $data,'version' => $version]);	
	}
	
	/**
	 * 热门搜索
	 *
	 * @ApiSummary  (WanlShop 搜索关键词列表)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function searchList()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		$list = model('app\api1\model\wanlshop\Search')
			->field('id,keywords,flag')
			->order('views desc')
			->limit(20)
		    ->select();
		$this->success('返回成功', $list);	
	}
	
	/**
	 * 提交搜索关键字给系统
	 *
	 * @ApiSummary  (WanlShop 搜索关键词列表)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $keywords 关键字
	 */
	public function setSearch()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		$keywords = $this->request->request("keywords", '');
		$model = model('app\api1\model\wanlshop\Search');
		if($model->where('keywords',$keywords)->count() > 0){
			$model->where('keywords',$keywords)->setInc('views');
		}else{
			$model->save(['keywords'=>$keywords]);
		}
		$this->success('返回成功');	
	}
	
	
	
    /**
     * 实时搜索类目&相关类目
     *
     * @ApiSummary  (WanlShop 搜索关键词列表)
     * @ApiMethod   (GET)
     * 
	 * @param string $search 搜索内容
     */
    public function search()
    {
    	//设置过滤方法
    	$this->request->filter(['strip_tags']);
		$search = $this->request->request('search', '');
		if($search){
			// 查询相关类目
			$categoryList = model('app\api1\model\wanlshop\Category')
			    ->where('name','like','%'.$search.'%')
				->field('id,name')
				->limit(20)
			    ->select();
				
			// 查询搜索数据
			$searchList = model('app\api1\model\wanlshop\Search')
			    ->where('keywords','like','%'.$search.'%')
				->field('keywords')
				->limit(20)
			    ->select();
			$result = array("categoryList" => $categoryList, "searchList" => $searchList);
			$this->success('返回成功', $result);	
		}else{
			$this->success('请输入关键字');
		}
    }
    
	
	
	/**
	 * 二维码配置
	 *
	 * @ApiSummary  (WanlShop 查询二维码配置)
	 * @ApiMethod   (POST)
	 *
	 */
	public function qrcode()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api1\model\wanlshop\Qrcode')
				->field('id,name,template,canvas_width,canvas_height,thumbnail_width,thumbnail_url,background_url,logo_src,checked,status')
				->order('weigh desc')
				->select();
			$this->success('返回成功', $list);	
		}
		$this->error(__('非正常访问'));
	}

	

	

	/**

	 * 关于系统

	 *

	 * @ApiSummary  (WanlShop 关于系统)

	 * @ApiMethod   (GET)

	 *

	 */

	public function about()

	{

		$config = get_addon_config('wanlshop');

		$this->success('返回成功', [

			'name' => $config['ini']['name'],

			'logo' => $config['ini']['logo'],

			'copyright' => $config['ini']['copyright']

		]);	

	}

	

	/**

	 * 获取上传配置 1.0.2升级

	 *

	 * @ApiSummary  (WanlShop 上传配置)

	 * @ApiMethod   (GET)

	 *

	 */

	public function uploadData()

	{

		//配置信息

		$upload = Config::get('upload');

		//如果非服务端中转模式需要修改为中转

		if ($upload['storage'] != 'local' && isset($upload['uploadmode']) && $upload['uploadmode'] != 'server') {

		    //临时修改上传模式为服务端中转

		    set_addon_config($upload['storage'], ["uploadmode" => "server"], false);

		

		    $upload = \app\common\model\Config::upload();

		    // 上传信息配置后

		    Hook::listen("upload_config_init", $upload);

		

		    $upload = Config::set('upload', array_merge(Config::get('upload'), $upload));

		}

		$upload['cdnurl'] = $upload['cdnurl'] ? $upload['cdnurl'] : cdnurl('', true);

		$upload['uploadurl'] = preg_match("/^((?:[a-z]+:)?\/\/)(.*)/i", $upload['uploadurl']) ? $upload['uploadurl'] : url($upload['storage'] == 'local' ? '/api/common/upload' : $upload['uploadurl'], '', false, true);

		$this->success('返回成功', $upload);

	}
}
