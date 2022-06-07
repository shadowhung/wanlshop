<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use fast\Tree;
/**
 * WanlShop產品接口
 */
class Product extends Api
{
	protected $noNeedLogin = ['lists','lists1','lists2', 'goods', 'drawer', 'comment', 'likes', 'stock'];
	protected $noNeedRight = ['*'];
    
	protected $excludeFields = "";
	

	
    /**
     * 獲取商品列表 1.0.3升級 隱藏查詢結果 1.0.4升級 錯誤查詢
     *
     * @ApiSummary  (WanlShop 產品接口獲取商品列表)
     * @ApiMethod   (GET)
	 * 
	 */
    public function lists()

    {

    	//設置過濾方法

    	$this->request->filter(['strip_tags']);

    	// 生成搜索條件

    	list($where, $sort, $order) = $this->buildparams('title,category.name,shop.shopname',false); // 查詢標題 和類目字段  ！！！！！！排除已下架//-------------------------------------------

    	// 查詢數據

    	$list = model('app\api\model\wanlshop\Goods')

    		->with(['shop','category'])

    	    ->where($where)

			->where('goods.status', 'normal')

    	    ->order($sort, $order)

    	    ->paginate();
    	    
    	$goodsModel = model('app\api\model\wanlshop\Goods');

    	foreach ($list as $row) {
    		// 查詢商品
    		/*$goods = $goodsModel
    			->where(['id' => $row->id])
    			->field('id,category_id,shop_category_id,brand_id,brand,freight_id,shop_id,title,image,images,flag,content,category_attribute,activity,price,sales,payment,comment,praise,moderate,negative,like,views,status')
    			->find();
    		// 瀏覽+1 & 報錯
    		if($goods && $goods['status'] == 'normal'){
    			// 查詢SKU
        		$row->sku = $goods->sku;
        		// 查詢SPU
        		$row->spu = $goods->spu;
    	
    		}*/
    	
    		

    	    $row->getRelation('shop')->visible(['city', 'shopname', 'state', 'isself']);

    		$row->getRelation('category')->visible(['id','pid','name']);

    		$row->isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();

    	}	

    	$this->success('成功を返す', $list);

    }
    
    /**
     * 獲取商品列表 1.0.3升級 隱藏查詢結果 1.0.4升級 錯誤查詢
     *
     * @ApiSummary  (WanlShop 產品接口獲取商品列表)
     * @ApiMethod   (GET)
	 * 
	 */
    public function lists1()

    {

    	//設置過濾方法

    	$this->request->filter(['strip_tags']);

    	// 生成搜索條件

    	list($where, $sort, $order) = $this->buildparams('title,category.name',false); // 查詢標題 和類目字段  ！！！！！！排除已下架//-------------------------------------------

    	// 查詢數據

    	$list = model('app\api\model\wanlshop\Goods')

    		->with(['shop','category'])

    	    ->where($where)

			->where('goods.status', 'normal')
			
			->where('goods.wholesale_id!=0')

    	    ->order($sort, $order)

    	    ->paginate();
    	    
    	$goodsModel = model('app\api\model\wanlshop\Goods');

    	foreach ($list as $row) {
    		// 查詢商品
    		$goods = $goodsModel
    			->where(['id' => $row->id])
    			->field('id,category_id,shop_category_id,brand_id,brand,freight_id,shop_id,title,image,images,flag,content,category_attribute,activity,price,sales,payment,comment,praise,moderate,negative,like,views,status')
    			->find();
    		// 瀏覽+1 & 報錯
    		if($goods && $goods['status'] == 'normal'){
    			// 查詢SKU
        		$row->sku = $goods->sku;
        		// 查詢SPU
        		$row->spu = $goods->spu;
    	
    		}

    	    $row->getRelation('shop')->visible(['city', 'shopname', 'state', 'isself']);

    		$row->getRelation('category')->visible(['id','pid','name']);

    		$row->isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();

    	}	

    	$this->success('成功を返す', $list);

    }
    
     /**
     * 獲取商品列表 1.0.3升級 隱藏查詢結果 1.0.4升級 錯誤查詢
     *
     * @ApiSummary  (WanlShop 產品接口獲取商品列表)
     * @ApiMethod   (GET)
	 * 
	 */
    public function lists2()

    {

    	//設置過濾方法

    	$this->request->filter(['strip_tags']);

    	// 生成搜索條件

    	list($where, $sort, $order) = $this->buildparams('title,category.name',false); // 查詢標題 和類目字段  ！！！！！！排除已下架//-------------------------------------------

    	// 查詢數據

    	$list = model('app\api\model\wanlshop\Shop')
    	
    	    ->where('verify', 3)

			->where('status', 'normal')

    	    ->order($sort, $order)

    	    ->paginate();

        
    	$goodsModel = model('app\api\model\wanlshop\Goods');
    	foreach ($list as $row) {
    		$row->goodsnum = $goodsModel->where(['shop_id' => $row->id, 'status' => 'normal'])->where('wholesale_id!=0')->count();
    	}	

    	$this->success('成功を返す', $list);

    }
    
	/**
	 * 獲取品牌列表
	 *
	 * @ApiSummary  (WanlShop 產品接口獲取品牌列表)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function drawer()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$search = $this->request->request("search"); // 查詢商品品牌
		$category_id = $this->request->request("category_id"); // 查詢類目品牌
		// 通過商品類目查詢
		if($search){
			// 生成搜索條件 笨辦法，查詢第壹個產品類目，列出品牌列表和類目屬性
			list($where, $sort, $order) = $this->buildparams('title,category.name',false);
			// 查詢數據
			$goods = model('app\api\model\wanlshop\Goods')
				->with(['category'])
			    ->where($where)
			    ->order($sort, $order)
			    ->find();
			if($goods){
				$brand = model('app\api\model\wanlshop\Brand')
				    ->where(['category_id'=> $goods['category_id'],'status'=> 'normal'])
					->field('name')
					->select();
				$attribute = model('app\api\model\wanlshop\Attribute')
				    ->where(['category_id'=> $goods['category_id'],'status'=> 'normal'])
					->field('name,value')
					->select();
				$result = array("brand" => $brand, "attribute" => $attribute);
			}else{
				$result = array("brand" => '', "attribute" => '');
			}
		}
		// 直接查詢類目
		if($category_id){
			$brand = model('app\api\model\wanlshop\Brand')
			    ->where(['category_id'=> $category_id,'status'=> 'normal'])
				->field('id,name')
				->select();
			$attribute = model('app\api\model\wanlshop\Attribute')
			    ->where(['category_id'=> $category_id,'status'=> 'normal'])
				->field('name,value')
				->select();
			$result = array("brand" => $brand, "attribute" => $attribute);
		}
		$this->success('成功を返す', $result);
	}
	
    /**
     * 獲取商品詳情
     *
     * @ApiSummary  (WanlShop 產品接口、瀏覽+1、獲取UUID生成訪問記錄)
     * @ApiMethod   (GET)
     * 
     * @param string $id 商品ID
     */
    public function goods()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$id = $this->request->request("id"); 
		// 是否傳入商品ID
		$id ? $id : ($this->error(__('異常な訪問')));
		// 加載商品模型
		$goodsModel = model('app\api\model\wanlshop\Goods');
		// 查詢商品
		$goods = $goodsModel
			->where(['id' => $id])
			->field('id,category_id,shop_category_id,brand_id,brand,freight_id,shop_id,title,image,images,flag,content,category_attribute,activity,price,sales,payment,comment,praise,moderate,negative,like,views,status')
			->find();
		// 瀏覽+1 & 報錯
		if($goods && $goods['status'] == 'normal'){
			$goods->setInc('views'); // 瀏覽+1
			$this->addbrowse($goods); // 寫入訪問日誌
		}else{
			$this->error(__('お探しの商品はまだご利用いただけません'));
		}
		// 查詢類目
		$goods->category->visible(['id','pid','name']);
		// 查詢優惠券
		// $goods['coupon'] = controller('api/wanlshop/coupon')->query($goods['id'], $goods['shop_id'], $goods['shop_category_id'], $goods['price'], true);
		$goods['coupon'] = $this->queryCoupon($goods['id'], $goods['shop_id'], $goods['shop_category_id'], $goods['price']);

		// 查詢是否關註
		$goods['follow'] = $this->isfollow($id);
		// 查詢品牌
		$goods['brand'] = 
		[
            'name'  => $goods['brand'],
        ];
		//'{name: "'.$goods['brand'].'"}';
		
		//$goods['brand']['name'] = $goods['brand'];
		//$goods->brand->visible(['name']);
		// 查詢SKU
		$goods['sku'] = $goods->sku;
		// 查詢SPU
		$goods['spu'] = $goods->spu;
		// 查詢直播狀態
		$goods['isLive'] = model('app\api\model\wanlshop\Live')->where(['shop_id' => $goods['shop_id'], 'state' => 1])->field('id')->find();
		
	    //var_dump($goods->comment_list['data']);exit;
		//foreach ($goods->comment_list['data'] as $k=>$v) {
			//var_dump($goods->comment_list['data'][$k]);exit; 
			//$goods->comment_list['data'][$k]->content =  'dd';
		//}
		//var_dump($dd);exit;
		// 查詢評論
		$goods['comment_list'] = $goods->comment_list;
		// 獲取店鋪詳情
		$goods->shop->visible(['shopname','service_ids','avatar','city','like','score_describe','score_service','score_logistics']);
		// 查詢快遞 運費ID 商品重量 郵遞城市 商品數量
		$goods['freight'] = $this->freight($goods['freight_id']);
		// 查詢促銷
		$goods['promotion'] = $id; //--下個版本更新--
		// 店鋪推薦
		$goods['shop_recommend'] = $goodsModel
			->where(['shop_id' => $goods['shop_id'], 'status' => 'normal']) //還可以使用 , 'flag' => 'recommend'
			->field('id,title,image,price')
			->limit(3)
			->select();
		$this->success('成功を返す', $goods);
    }
	
	/**
	 * 實時查詢庫存
	 *
	 * @ApiSummary  (WanlShop 保存瀏覽記錄)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $sku_id  SKU
	 */
	public function stock($sku_id = '')
	{
	    $this->success('検索に成功', model('app\api\model\wanlshop\GoodsSku')->get($sku_id));
	}
	
	/**
	 * 是否關註商品
	 *
	 * @ApiSummary  (WanlShop 保存瀏覽記錄)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $goods  商品數據
	 */
	public function isfollow($goods_id ='')
	{
		$data = false;
		if ($this->auth->isLogin()) {
			$follow = model('app\api\model\wanlshop\GoodsFollow')->where(['user_id'=>$this->auth->id, 'goods_id'=>$goods_id])->count();
			$data = $follow == 0 ? false : true; //關註
		}
		return $data;
	}
	
	/**
	 * 保存瀏覽記錄
	 *
	 * @ApiSummary  (WanlShop 保存瀏覽記錄)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $goods  商品數據
	 */
	public function addbrowse($goods =[])
	{
		//保存瀏覽記錄
		$uuid = $this->request->server('HTTP_UUID');
		if(!isset($uuid)){
			$charid = strtoupper(md5($this->request->header('user-agent').$this->request->ip()));
			$uuid = substr($charid, 0, 8).chr(45).substr($charid, 8, 4).chr(45).substr($charid,12, 4).chr(45).substr($charid,16, 4).chr(45).substr($charid,20,12);
		}
		$record = model('app\api\model\wanlshop\Record');
		$where = [
			'uuid' => $uuid,
			'goods_id' => $goods['id']
		];
		if($record->where($where)->count() == 0){
			if ($this->auth->isLogin()) {
				$record->user_id = $this->auth->id;
			}
			$record->uuid = $uuid;
			$record->goods_id = $goods['id'];
			$record->shop_id = $goods['shop_id'];
			$record->category_id = $goods['category']['id'];
			$record->category_pid = $goods['category']['pid'];
			$record->ip = $this->request->ip();
			$record->save();
		}else{
			$record->where($where)->setInc('views'); //訪問+1
		}
	}
	
	/**
	 * 關註商品
	 *
	 * @ApiSummary  (WanlShop 關註或取消商品)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 商品ID
	 */
	public function follow()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post("id");
			// 是否傳入商品ID
			$id ? $id : ($this->error(__('異常な訪問')));
			// 加載商品模型
			$goodsModel = model('app\api\model\wanlshop\Goods');
			$goodsFollowModel = model('app\api\model\wanlshop\GoodsFollow');
			$data = [
				'user_id' => $this->auth->id, 
				'goods_id' => $id
			];
			if($goodsFollowModel->where($data)->count() == 0){
				$goodsFollowModel->save($data);
				$goodsModel->where(['id' => $id])->setInc('like'); //喜歡+1
				$follow = true;
			}else{
				$goodsFollowModel->where($data)->delete();
				$goodsModel->where(['id' => $id])->setDec('like'); //喜歡-1
				$follow = false;
			}
			$this->success('成功を返す', $follow);
		}
		$this->error(__('異常な訪問'));
	}
	
	/**
	 * 收藏夾列表
	 */
	public function collect()
	{
		$goods = model('app\api\model\wanlshop\GoodsFollow')
			->where(['user_id' => $this->auth->id])
			->field('goods_id')
			->paginate()
			->each(function($data, $key){
				$data['goods'] = $data->goods ? $data->goods->visible(['shop_id','title','image','views','price','sales','payment','like']) : [];
				return $data;
			});
	    $this->success('成功を返す', $goods);
	}
	
	/**
	 * 足跡列表
	 */
	public function footprint()
	{
		$list = model('app\api\model\wanlshop\Record')
			->where(['user_id' => $this->auth->id])
			->field('goods_id, createtime')
			->order('createtime', 'desc')
			->paginate()
			->each(function($data, $key){
				$data['goods'] = $data->goods ? $data->goods->visible(['image','title','price','payment']) : [];
				return $data;
			});
		$this->success('成功を返す', $list);
	}

	

	/**

	 * 查詢用戶指定店鋪瀏覽記錄 

	 *

	 * @ApiSummary  (查詢用戶指定店鋪瀏覽記錄 1.0.2升級)

	 * @ApiMethod   (POST)

	 *

	 * @param string $shop_id 店鋪ID

	 */

	public function getBrowsingToShop()

	{

		//設置過濾方法

		$this->request->filter(['strip_tags']);

		if($this->request->isPost()){

			$shop_id = $this->request->post('shop_id');

			$shop_id ? '':($this->error(__('Invalid parameters')));

			$list = model('app\api\model\wanlshop\Record')

				->where(['shop_id' => $shop_id, 'user_id' => $this->auth->id])

				->group('goods_id')

				->field('goods_id, createtime')

				->select();

			foreach ($list as $row) {

				$row->goods->visible(['id', 'image', 'title', 'price']);

			}

			$this->success(__('正常に送信されました'), $list);

		}

		$this->error(__('違法なリクエスト'));

	}

	
	/**
	 * 獲取商品評論
	 *
	 * @ApiSummary  (WanlShop 獲取商品下所有評論)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $tag 評論分類
	 * @param string $id  商品ID
	 * @param string $list_rows  每頁數量
	 * @param string $page  當前頁
	 */
	public function comment()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$id = $this->request->request("id"); 
		$tag = $this->request->request('tag');
		// 是否傳入商品ID
		$id ? $id : ($this->error(__('異常な訪問')));
		// 加載商品模型
		$goodsCommentModel = model('app\api\model\wanlshop\GoodsComment')->order('createtime desc');
		//查詢tag 評價:0=好評,1=中評,2=差評
		if($tag){
			if($tag == 'good'){
				$where['state'] = 0;
			}else if($tag == 'pertinent'){
				$where['state'] = 1;
			}else if($tag == 'poor'){
				$where['state'] = 2;
			}else if($tag == 'figure'){
				$where['images'] = ['neq', ''];//有圖
			}else{
				$where['tag'] = $tag;
			}
		}
		$where['goods_id'] = $id;
		$comment['comment'] = $goodsCommentModel
			->with(['user'])
			->where($where)
			->paginate();
		// $comment['tag'] = array_count_values($goodsCommentModel->where(['goods_id'=>$id])->limit(100)->column('tag')); //統計熱詞
		foreach ($comment['comment'] as $row) {
			$row->getRelation('user')->visible(['username','nickname','avatar']);
			$row->content = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", " ", strip_tags($row->content));
		}
		$goods = model('app\api\model\wanlshop\Goods')
			->where(['id' => $id])
			->find();
		$comment['statistics'] = [
			'rate'     => $goods['comment'] == 0 ? '0' : bcmul(bcdiv($goods['praise'], $goods['comment'], 2), 100, 2),
			'total'    => $goods['comment'], 
			'good'     => $goods['praise'],
			'pertinent'=> $goods['moderate'],     
			'poor'     => $goods['negative'],
			'figure'   => $goodsCommentModel->where(['goods_id' => $id])->where('images','neq', '')->count()
		];
		$this->success('成功を返す', $comment);
	}

	
	/**
	 * 猜妳喜歡
	 *
	 * @ApiSummary  (WanlShop 猜妳喜歡)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $pages 頁面ID
	 * @param string $category_id 類目ID
	 */
	public function likes()
	{
		$pages = $this->request->request('pages'); //不同頁面不同排序,goods只獲得與當前產品相同類目,index獲得排名靠前的,user隨意獲取
		$category_id = $this->request->request('cid');
		
		
		$page1 = $this->request->request('page');
		
		// 判斷來源
		if($pages == 'index'){
			//$sort = 'payment';
			$sort = 'sales';
		}else if($pages == 'user'){
			$sort = 'comment';
		}else if($pages == 'cart'){
			$sort = 'views';
		}else if($pages == 'goods'){
			$sort = 'weigh';
		}else{
			$sort = 'like';
		}
		$uuid = $this->request->server('HTTP_UUID');
		if(!isset($uuid)){
			$charid = strtoupper(md5($this->request->header('user-agent').$this->request->ip()));
			$uuid = substr($charid, 0, 8).chr(45).substr($charid, 8, 4).chr(45).substr($charid,12, 4).chr(45).substr($charid,16, 4).chr(45).substr($charid,20,12);
		}
		// 統計
		$record = model('app\api\model\wanlshop\Record')->where(['uuid'=>$uuid]);

		//獲取沒在活動中的產品
		$where['activity'] = 'false'; 

		// 獲取上架商品 1.0.3升級

		$where['status'] = 'normal'; 

		//如果沒有
		if($record->count() == 0||$pages == 'index'){
			if($category_id){
				$category_pid = model('app\api\model\wanlshop\Category')->get($category_id);
				$array = model('app\api\model\wanlshop\Category')
					->where(['pid' => $category_pid['pid']])
					->select();
				$cid = [];
				foreach ($array as $value) {
					$cid[] = $value['id'];
				}
				$where['category_id'] = ['in',$cid];
			}
			if($pages == 'index'||$page1== 'index'){
    			$goods = model('app\api\model\wanlshop\Goods')
				->where($where)
				//->orderRaw('rand()')
				->field('id,shop_id,title,image,flag,price,views,sales,comment,praise,like')
				->order('sales desc')
				->paginate();
    		}else{
    		    $goods = model('app\api\model\wanlshop\Goods')
				->where($where)
				->orderRaw('rand()')
				->field('id,shop_id,title,image,flag,price,views,sales,comment,praise,like')
				->paginate();
    		}
			
		}else{
			$like_cat = array_count_values($record->column('category_pid')); //喜歡的類目
			$like_goods_cat = array($record->order('views', 'desc')->find()['category_pid']); //喜歡產品的類目
			arsort($like_cat); //排序
			$like_cat_top = array_slice(array_keys($like_cat),0,5); //排名前5
			$category_pid = array_intersect($like_cat_top,$like_goods_cat); //是否包含喜歡的產品類目
			// 如果包含輸入產品類目,如果不包含輸出排名第壹的
			if($category_pid){
				$category_pid = array_slice($category_pid,0,1)[0];
			}else{
				$category_pid = $like_cat_top[0];
			}
			// 查詢指定
			if($category_id){
				$category_pid = model('app\api\model\wanlshop\Category')->get($category_id)['pid'];
			}
			//查詢下級類目
			$array = model('app\api\model\wanlshop\Category')
				->where(['pid'=>$category_pid])
				->select();
			$cid = [];
			foreach ($array as $value) {
				$cid[] = $value['id'];
			}
			$where['category_id'] = ['in',$cid];
			// 查詢父ID下所有商品
			//var_dump($pages);exit;
			if($pages == 'index'||$page1== 'index'){
    			$goods = model('app\api\model\wanlshop\Goods')
    				->where($where)
    				//->orderRaw('rand()')
    				->field('id,shop_id,title,image,flag,price,views,sales,comment,praise,like')
    				->order('sales desc')
    				->paginate();
			}else{
			    $goods = model('app\api\model\wanlshop\Goods')
    				->where($where)
    				->orderRaw('rand()')
    				->field('id,shop_id,title,image,flag,price,views,sales,comment,praise,like')
    				//->order('sales desc')
    				->paginate();
			}
		}
		foreach ($goods as $row) {

			$row->shop->visible(['state','shopname']);
			$row->isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
		}
		$this->success('成功を返す', $goods);
	}
	
	/**
	 * 獲取運費模板和子類 內部方法 -----下個版本完善------
	 * @param string $id  運費ID
	 * @param string $weigh  商品重量
	 * @param string $city  郵遞城市
	 * @param string $number  商品數量
	 */
	private function freight($id = null, $weigh = 0, $city = '北京', $number = 1)
	{
		// 運費模板
		$data = model('app\api\model\wanlshop\ShopFreight')->where('id', $id)->field('id,delivery,isdelivery,name,valuation')->find();
		$data['price'] = 0;
		// 是否包郵:0=自定義運費,1=賣家包郵
		if(isset($data['isdelivery'])&&$data['isdelivery'] == 0){
			// 獲取地址編碼
			$area = model('app\common\model\Area')->where('name',$city)->find();
			$list = model('app\api\model\wanlshop\ShopFreightData')
				->where('citys','like','%'.$area['id'].'%')
				->where('freight_id',$id)
				->find();
			// 查詢是否存在運費模板數據
			if(!$list){
				$list = model('app\api\model\wanlshop\ShopFreightData')
					->where('freight_id',$id)
					->find();
			}
			// 計價方式:0=按件數,1=按重量,2=按體積
			if($data['valuation'] == 0){
				if($number <= $list['first']){
					$price = $list['first_fee'];
				}else{
					$price = ceil(($number - $list['first']) / $list['additional']) * $list['additional_fee'] + $list['first_fee'];
				}
			}else{
				$weigh = $weigh * $number; // 訂單總重量
				if($weigh <= $list['first']){ // 如果重量小於等首重，則首重價格
					$price = $list['first_fee'];
				}else{
					$price = ceil(($weigh - $list['first']) / $list['additional']) * $list['additional_fee'] + $list['first_fee'];
				}
			}
			$data['price'] = $price;
		}
		return $data;
	}
	
	/**

	 * 查詢我的優惠券 內部方法 (跨段存在登錄問題，無法解決，暫時復制進來這個方法)

	 *

	 * @param string $goods_id 商品ID

	 * @param string $shop_id 店鋪ID

	 * @param string $shop_category_id 分類ID

	 * @param string $price 價格 

	 */

	private function queryCoupon($goods_id = null, $shop_id = null, $shop_category_id = null, $price = null)

	{

		$user_coupon = [];

		if ($this->auth->isLogin()) {

			foreach (model('app\api\model\wanlshop\CouponReceive')->where([

				'user_id' => $this->auth->id, 

				'shop_id' => $shop_id,

				'limit' => ['<=', intval($price)],

				'state' => '1'

			])->select() as $row) {

				$user_coupon[$row['coupon_id']] = $row;

			}

		}

		// 開始查詢 方案壹

		$list = [];

		$goods_id = explode(",",$goods_id);

		$shop_category_id = explode(",",$shop_category_id);

		//要追加壹個排序 選出壹個性價比最高的

		foreach (model('app\api\model\wanlshop\Coupon')->where([

			'shop_id' => $shop_id,

			'limit' => ['<=', intval($price)]

		])->select() as $row) { 

			// 篩選出還未開始的

			if(!($row['pretype'] == 'fixed' && (strtotime($row['startdate']) >= time() || strtotime($row['enddate']) < time()))){

				//追加字段

				$row['choice'] = false;

				// 檢查指定的鍵名是否存在於數組中

				if(array_key_exists($row['id'], $user_coupon)){

					$row['invalid'] = 0; // 強制轉換優惠券狀態

					$row['id'] = $user_coupon[$row['id']]['id'];

					$row['state'] = true;

				}else{

					$row['state'] = false;

				}

				// 排除失效優惠券

				if($row['invalid'] == 0){

					// 高級查詢，比較數組，返回交集如果和原數據數目相同則加入

					if($row['rangetype'] == 'all'){

						$list[] = $row;

					}

					if($row['rangetype'] == 'goods' && count($goods_id) == count(array_intersect($goods_id, explode(",",$row['range'])))){

						$list[] = $row;

					}

					if($row['rangetype'] == 'category' && count($shop_category_id) == count(array_intersect($shop_category_id, explode(",",$row['range'])))){

						$list[] = $row;

					}

				}

			}

		}

		return $list;

	}

	

	

	
	/**
	 * 生成查詢所需要的條件,排序方式
	 * @param mixed   $searchfields   快速查詢的字段
	 * @param boolean $relationSearch 是否關聯查詢
	 * @return array
	 */
	protected function buildparams($searchfields = null, $relationSearch = null)
	{
	    $searchfields = is_null($searchfields) ? $this->searchFields : $searchfields;
	    $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;
		// 獲取傳參
	    $search = $this->request->get("search", '');
	    $filter = $this->request->get("filter", '');
	    $op = $this->request->get("op", '', 'trim');
	    $sort = $this->request->get("sort", !empty($this->model) && $this->model->getPk() ? $this->model->getPk() : 'id');
	    $order = $this->request->get("order", "DESC");
	    $filter = (array)json_decode($filter, true);
	    $op = (array)json_decode($op, true);
	    $filter = $filter ? $filter : [];
	    $where = [];
	    $tableName = '';
	    if ($relationSearch) {
	        if (!empty($this->model)) {
	            $name = \think\Loader::parseName(basename(str_replace('\\', '/', get_class($this->model))));
	            $name = $this->model->getTable();
	            $tableName = $name . '.';
	        }
	        $sortArr = explode(',', $sort);
	        foreach ($sortArr as $index => & $item) {
	            $item = stripos($item, ".") === false ? $tableName . trim($item) : $item;
	        }
	        unset($item);
	        $sort = implode(',', $sortArr);
	    }
		
		
		// 判斷是否需要驗證權限
		// if (!$this->auth->match($this->noNeedLogin)) {
		//     $where[] = [$tableName . 'user_id', 'in', $this->auth->id];
		// }
		
	    if ($search) {
	        $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);
	        foreach ($searcharr as $k => &$v) {
	            $v = stripos($v, ".") === false ? $tableName . $v : $v;
	        }
	        unset($v);
	        $arrSearch = [];
	        foreach (explode(" ", $search) as $ko) {
	        	$arrSearch[] = '%'.$ko.'%';
	        }
	        $where[] = [implode("|", $searcharr), "LIKE", $arrSearch];
	    }

		// 歷遍所有

		if (array_key_exists('category_id', $filter)) {

			$filter['category_id'] = implode(',', array_column(Tree::instance()->init(model('app\api\model\wanlshop\Category')->all())->getChildren($filter['category_id'], true), 'id'));

		}
	    foreach ($filter as $k => $v) {
	        $sym = isset($op[$k]) ? $op[$k] : '=';
	        if (stripos($k, ".") === false) {
	            $k = $tableName . $k;
	        }
	        $v = !is_array($v) ? trim($v) : $v;
	        $sym = strtoupper(isset($op[$k]) ? $op[$k] : $sym);
	        switch ($sym) {
	            case '=':
	            case '<>':
	                $where[] = [$k, $sym, (string)$v];
	                break;
	            case 'LIKE':
	            case 'NOT LIKE':
	            case 'LIKE %...%':
	            case 'NOT LIKE %...%':
	                $where[] = [$k, trim(str_replace('%...%', '', $sym)), "%{$v}%"];
	                break;
	            case '>':
	            case '>=':
	            case '<':
	            case '<=':
	                $where[] = [$k, $sym, intval($v)];
	                break;
	            case 'FINDIN':
	            case 'FINDINSET':
	            case 'FIND_IN_SET':
	                $where[] = "FIND_IN_SET('{$v}', " . ($relationSearch ? $k : '`' . str_replace('.', '`.`', $k) . '`') . ")";
	                break;
	            case 'IN':
	            case 'IN(...)':
	            case 'NOT IN':
	            case 'NOT IN(...)':
	                $where[] = [$k, str_replace('(...)', '', $sym), is_array($v) ? $v : explode(',', $v)];
	                break;
	            case 'BETWEEN':
	            case 'NOT BETWEEN':
	                $arr = array_slice(explode(',', $v), 0, 2);
	                if (stripos($v, ',') === false || !array_filter($arr)) {
	                    continue 2;
	                }
	                //當出現壹邊為空時改變操作符
	                if ($arr[0] === '') {
	                    $sym = $sym == 'BETWEEN' ? '<=' : '>';
	                    $arr = $arr[1];
	                } elseif ($arr[1] === '') {
	                    $sym = $sym == 'BETWEEN' ? '>=' : '<';
	                    $arr = $arr[0];
	                }
	                $where[] = [$k, $sym, $arr];
	                break;
	            case 'RANGE':
	            case 'NOT RANGE':
	                $v = str_replace(' - ', ',', $v);
	                $arr = array_slice(explode(',', $v), 0, 2);
	                if (stripos($v, ',') === false || !array_filter($arr)) {
	                    continue 2;
	                }
	                //當出現壹邊為空時改變操作符
	                if ($arr[0] === '') {
	                    $sym = $sym == 'RANGE' ? '<=' : '>';
	                    $arr = $arr[1];
	                } elseif ($arr[1] === '') {
	                    $sym = $sym == 'RANGE' ? '>=' : '<';
	                    $arr = $arr[0];
	                }
	                $where[] = [$k, str_replace('RANGE', 'BETWEEN', $sym) . ' time', $arr];
	                break;
	            case 'LIKE':
	            case 'LIKE %...%':
	                $where[] = [$k, 'LIKE', "%{$v}%"];
	                break;
	            case 'NULL':
	            case 'IS NULL':
	            case 'NOT NULL':
	            case 'IS NOT NULL':
	                $where[] = [$k, strtolower(str_replace('IS ', '', $sym))];
	                break;
	            default:
	                break;
	        }
	    }
	    $where = function ($query) use ($where) {
	        foreach ($where as $k => $v) {
	            if (is_array($v)) {
	                call_user_func_array([$query, 'where'], $v);
	            } else {
	                $query->where($v);
	            }
	        }
	    };
	    return [$where, $sort, $order];
	}
	
}
