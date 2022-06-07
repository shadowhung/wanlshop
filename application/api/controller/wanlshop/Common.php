<?php
// 2020年2月18日18:16:41
// 修改 2020年7月26日06:55:45

// 修改 2020年11月22日18:36:01
namespace app\api\controller\wanlshop;

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
	 * 壹次性加載App
	 *
	 * @ApiSummary  (WanlShop 獲取首頁、購物車、類目數據)
	 * @ApiMethod   (GET)
	 *
	 */
    public function init()
    {
		// 首頁
		$homeList = model('app\api\model\wanlshop\Page')
			->where('type','index')
			->field('page, item')
			->find();			
		if(!$homeList){
			$this->error(__('ホームページが追加されていません。バックグラウンド[ページ管理]に移動してホームページを追加してください'));
		}
		// 類目
		$tree = Tree::instance();
		$tree->init(model('app\api\model\wanlshop\Category')->where(['type' => 'goods', 'isnav' => 1])->field('id, pid, name, image')->order('weigh asc')->select());
		// 搜索關鍵字
		$searchList = model('app\api\model\wanlshop\Search')
			->where(['flag' => 'index'])
			->field('keywords')
			->order('views desc')
			->limit(10)
		    ->select();
		// 獲取配置
		$config = get_addon_config('wanlshop');
		// 壹次性獲取模塊
		$modulesData  = [
			"homeModules" => $homeList,
			"categoryModules" => $tree->getTreeArray(0),
			"searchModules" => $searchList
		];
		// 追加h5地址用於分享二維碼等
		$config['config']['domain'] = $config['h5']['domain'].($config['h5']['router_mode'] == 'hash' ? '/#':'');
		// 輸出
		$this->success('成功を返す', [
			"modulesData" => $modulesData,
			"appStyle" => $config['style'],
			"appConfig" => $config['config'],
			"serviceVersion" => '202006183294701'  //數據版本號必須是整數
		]);
    }
	
	/**
	 * APP熱更新 1.0.3升級
	 *
	 * @ApiSummary  (WanlShop APP熱更新)
	 * @ApiMethod   (GET)
	 *
	 */
	public function update()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$row = model('app\api\model\wanlshop\Version')
			->order('versionCode desc')
			->find();

		$this->success('成功を返す', $row);	
	}
	
	
	
	/**
	 * 加載廣告
	 *
	 * @ApiSummary  (WanlShop 加載廣告)
	 * @ApiMethod   (GET)
	 *
	 */
	public function adverts()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$data = [
			'openAdverts' => [],
			'pageAdverts' => [],
			'categoryAdverts' => [],
			'firstAdverts' => [],
			'otherAdverts' => []
		];
		$list = model('app\api\model\wanlshop\Advert')
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
		// 通過大版本號查詢，對應數據，未來版本升級開發
		$version = $this->request->request("version", '');
		$this->success('成功を返す', ['data' => $data,'version' => $version]);	
	}
	
	/**
	 * 熱門搜索
	 *
	 * @ApiSummary  (WanlShop 搜索關鍵詞列表)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function searchList()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$list = model('app\api\model\wanlshop\Search')
			->field('id,keywords,flag')
			->order('views desc')
			->limit(20)
		    ->select();
		$this->success('成功を返す', $list);	
	}
	
	/**
	 * 提交搜索關鍵字給系統
	 *
	 * @ApiSummary  (WanlShop 搜索關鍵詞列表)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $keywords 關鍵字
	 */
	public function setSearch()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$keywords = $this->request->request("keywords", '');
		$model = model('app\api\model\wanlshop\Search');
		if($model->where('keywords',$keywords)->count() > 0){
			$model->where('keywords',$keywords)->setInc('views');
		}else{
			$model->save(['keywords'=>$keywords]);
		}
		$this->success('成功を返す');	
	}
	
	
	
    /**
     * 實時搜索類目&相關類目
     *
     * @ApiSummary  (WanlShop 搜索關鍵詞列表)
     * @ApiMethod   (GET)
     * 
	 * @param string $search 搜索內容
     */
    public function search()
    {
    	//設置過濾方法
    	$this->request->filter(['strip_tags']);
		$search = $this->request->request('search', '');
		if($search){
			// 查詢相關類目
			$categoryList = model('app\api\model\wanlshop\Category')
			    ->where('name','like','%'.$search.'%')
				->field('id,name')
				->limit(20)
			    ->select();
				
			// 查詢搜索數據
			$searchList = model('app\api\model\wanlshop\Search')
			    ->where('keywords','like','%'.$search.'%')
				->field('keywords')
				->limit(20)
			    ->select();
			$result = array("categoryList" => $categoryList, "searchList" => $searchList);
			$this->success('成功を返す', $result);	
		}else{
			$this->success('キーワードを入力してください');
		}
    }
    
	
	
	/**
	 * 二維碼配置
	 *
	 * @ApiSummary  (WanlShop 查詢二維碼配置)
	 * @ApiMethod   (POST)
	 *
	 */
	public function qrcode()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Qrcode')
				->field('id,name,template,canvas_width,canvas_height,thumbnail_width,thumbnail_url,background_url,logo_src,checked,status')
				->order('weigh desc')
				->select();
		    $list[0]['luodiurl'] = Config::get('site.luodiurl');
			$this->success('成功を返す', $list);	
		}
		$this->error(__('異常な訪問'));
	}

	

	

	/**

	 * 關於系統

	 *

	 * @ApiSummary  (WanlShop 關於系統)

	 * @ApiMethod   (GET)

	 *

	 */

	public function about()

	{

		$config = get_addon_config('wanlshop');

		$this->success('成功を返す', [

			'name' => $config['ini']['name'],

			'logo' => $config['ini']['logo'],

			'copyright' => $config['ini']['copyright']

		]);	

	}

	

	/**

	 * 獲取上傳配置 1.0.2升級

	 *

	 * @ApiSummary  (WanlShop 上傳配置)

	 * @ApiMethod   (GET)

	 *

	 */

	public function uploadData()

	{

		//配置信息

		$upload = Config::get('upload');

		//如果非服務端中轉模式需要修改為中轉

		if ($upload['storage'] != 'local' && isset($upload['uploadmode']) && $upload['uploadmode'] != 'server') {

		    //臨時修改上傳模式為服務端中轉

		    set_addon_config($upload['storage'], ["uploadmode" => "server"], false);

		

		    $upload = \app\common\model\Config::upload();

		    // 上傳信息配置後

		    Hook::listen("upload_config_init", $upload);

		

		    $upload = Config::set('upload', array_merge(Config::get('upload'), $upload));

		}

		$upload['cdnurl'] = $upload['cdnurl'] ? $upload['cdnurl'] : cdnurl('', true);

		$upload['uploadurl'] = preg_match("/^((?:[a-z]+:)?\/\/)(.*)/i", $upload['uploadurl']) ? $upload['uploadurl'] : url($upload['storage'] == 'local' ? '/api/common/upload' : $upload['uploadurl'], '', false, true);

		$this->success('成功を返す', $upload);

	}
}
