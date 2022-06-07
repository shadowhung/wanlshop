<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop 發現接口
 */
class Find extends Api
{
    protected $noNeedLogin = ['find','menu','details','lists','shop','comments'];
	protected $noNeedRight = ['*'];
    
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new \app\api\model\wanlshop\Find;
	}
	
	/**
	 * 發現列表
	 */
	public function menu($device = null)
	{
	    $menu = [];
	    // 獲取配置
		$config = get_addon_config('wanlshop');
		$tpl = [
		    'id' => '',
		    'name' => '',
		    'data' => [],
		    'current_page' => 1,
		    'last_page' => 1,
		    'triggered' => false,
		    '_freshing' => false,
		    'status' => 'loading',
		    'contentText' => [
		        'contentdown' => '',
		        'contentrefresh' => '読み込み中',
		        'contentnomore' => '- 収益があります -'
		    ]
		];
		$tplname = [
		    'all' => '注意',
		    'new' => '最新',
			'live' => '生放送',
			'want' => '草を植える',
			'activity' => 'アクティビティ',
			'show' => 'バイヤーショー'
		];
		if($device == 'app'){
		    foreach($config['find']['app_switch'] as $value){
		        $tpl['id'] = $value;
		        $tpl['name'] = $tplname[$value];
                $menu[] = $tpl;
            }
		}else if($device == 'mp'){
		    foreach($config['find']['mp_switch'] as $value){
                $tpl['id'] = $value;
                $tpl['name'] = $tplname[$value];
                $menu[] = $tpl;
            }
		}else if($device == 'h5'){
		    foreach($config['find']['h5_switch'] as $value){
		        $tpl['id'] = $value;
		        $tpl['name'] = $tplname[$value];
                $menu[] = $tpl;
            }
		}
		$this->success('ok', $menu);
	}
	
	/**
	 * 發現列表
	 */
	public function find()
	{
		$this->request->filter(['strip_tags']);
		$type = $this->request->request('type');
		$user_id = $this->auth->id;
		// 查詢所有關註
		$follow = model('app\api\model\wanlshop\ShopFollow')
			->where(['user_id' => $user_id])
			->select();
		$followShop = [];
		foreach ($follow as $value) {
		    $followShop[] = $value['shop_id'];
		}
		
		//查詢方法 關註 + 猜妳喜歡店鋪
		switch ($type)
		{
			case 'all':
				$where = ['shop_id' => ['in', $followShop]];
				break;  
			// case 'new':
			// 	$where = ['shop_id' => ['in', $followShop], 'type' => $type];
			// 	break;
			default:
				$where = ['type' => $type];
		}
		
		//查詢列表
		$list = $this->model
			->where($where)
			->order('createtime desc')
			->paginate();
		// 插入其他數據	
		if($type == 'all'){
			
			
			
			
			
		}
		foreach ($list as $row) {
		    $row->shop->visible(['id','avatar','shopname']);
			// 查詢直播詳情
			if($row['type'] == 'live'){
				$row->live->visible(['id','goods_ids','like','state','views']);
			}
			$row->isFollow = in_array($row['shop_id'], $followShop);
			$row->isShopBut = in_array($row['shop_id'], $followShop); 
			
			$row->isLike = model('app\api\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $user_id])->find() ? true : false; 
			$row->isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
			
			// 關聯商品
			$row->goods = model('app\api\model\wanlshop\Goods')
				->where('id','in',$row['goods_ids'])
				->field('id,title,image,price')
				->select();
			// 統計新品
			$row->newGoods = model('app\api\model\wanlshop\Goods')
				->where('shop_id', $row['shop_id'])
				->whereTime('createtime', 'w') // 查詢本周
				->count();
		}
		$this->success('ok',$list);
	}
	
	/**
	 * 我的點贊列表
	 *
	 * @ApiSummary  (WanlShop 我的點贊列表)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function follow()
	{
		$this->request->filter(['strip_tags']);
		$user_id = $this->auth->id;
		$find_id = [];
		// 獲取妳喜歡find
		$follow = model('app\api\model\wanlshop\FindFollow')
			->where(['user_id' => $user_id])
			->field('find_id')
			->select();
		foreach ($follow as $vo)
		{
			$find_id[] = $vo['find_id'];
		}
		// 獲取Find
		$list = $this->model
			->where('id', 'in', $find_id)
			->order('createtime desc')
			->paginate();
		foreach ($list as $row) {
		    $row->shop->visible(['id','avatar','shopname']);
			// 查詢直播詳情
			if($row['type'] == 'live'){
				$row->live->visible(['id','goods_ids','like','state','views']);
			}
			$row->isLike = model('app\api\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $user_id])->find() ? true : false; 
			$row->isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
			// 關聯商品
			$row->goods = model('app\api\model\wanlshop\Goods')
				->where('id','in',$row['goods_ids'])
				->field('id,title,image,price')
				->select();
			// 統計新品
			$row->newGoods = model('app\api\model\wanlshop\Goods')
				->where('shop_id', $row['shop_id'])
				->whereTime('createtime', 'w') // 查詢本周
				->count();
		}
		$this->success('ok',$list);
	}
	
	
	
	/**
	 * 獲取發現詳情&列表
	 *
	 * @ApiSummary  (WanlShop 關註或取消動態)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 發現ID
	 */
	public function details($id = null)
	{
		$row = $this->model->get($id);
		$row ? $row : ($this->error(__('検出ページが見つかりませんでした')));
		// 獲取其他數據
		$row->shop->visible(['id','avatar','shopname']);
		$follow = 0;
		$isLike = 0;
		$isLive = '';
		// 判斷是否登錄
		if($this->auth->isLogin()){
			$user_id = $this->auth->id;
			$follow = model('app\api\model\wanlshop\ShopFollow')->where(['user_id' => $user_id, 'shop_id' => $row['shop_id']])->count();
			$isLike = model('app\api\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $user_id])->count();
			$isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
		}
		$row->isFollow = $follow == 0 ? false : true;
		$row->isShopBut = $follow == 0 ? false : true;
		$row->isLike = $isLike == 0 ? false : true;
		$row->isLive = $isLive ? $isLive : '';
		$row->current = 0;
		// 關聯商品
		$row->goods = model('app\api\model\wanlshop\Goods')
			->where('id','in',$row['goods_ids'])
			->field('id,title,image,price')
			->select();
		// 閱讀量 +1
		$row->setInc('views');
		$this->success('ok',$row);
	}
	
	
	/**
	 * 獲取發現商家列表
	 *
	 * @ApiSummary  (WanlShop 關註或取消動態)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 發現ID
	 */
	public function lists($shop_id = null, $id)
	{
		$list = $list = $this->model
			->order('createtime desc')
			->where('id','neq',$id)
			->where('type','neq','live')
			->where('shop_id','in',$shop_id)
			->paginate();
		foreach ($list as $row) {
			$row->goods = model('app\api\model\wanlshop\Goods')
				->where('id','in',$row['goods_ids'])
				->field('id,title,image,price')
				->select();
			$isLike = 0;
			// 判斷是否登錄
			if($this->auth->isLogin()){
				$isLike = model('app\api\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $this->auth->id])->count();
			}
			$row->isLike = $isLike == 0 ? false : true;
			$row->current = 0;
		}
		$this->success('ok',$list);
	}
	
	
	/**
	 * 獲取商家列表
	 *
	 * @ApiSummary  (WanlShop 關註或取消動態)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 發現ID
	 */
	public function shop($shop_id = null)
	{
		$list = $list = $this->model
			->order('createtime desc')
			->where('shop_id','in',$shop_id)
			->paginate();
		foreach ($list as $row) {
			
		}
		$this->success('ok',$list);
	}
	
	/**
	 * 發現評論列表
	 *
	 * @ApiSummary  (WanlShop 發現評論列表)
	 * @ApiMethod   (get)
	 * 
	 * @param string $id 發現ID
	 */
	public function comments($find_id = null)
	{
		$list = model('app\api\model\wanlshop\FindComments')
			->where(['find_id' => $find_id])
			->select();
		foreach ($list as $row) {
			$row->user->visible(['id','avatar','nickname']);
		}
		$this->success('ok',$list);
	}
	
	/**
	 * 發現頁發表評論
	 *
	 * @ApiSummary  (WanlShop 發現評論列表)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 發現ID
	 */
	public function addComments()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$find_id = $this->request->post('find_id');
			$find_id ? $find_id : ($this->error(__('違法なリクエスト')));
			$content = $this->request->post('content');
			
			$comments = model('app\api\model\wanlshop\FindComments');
			$comments->data([
			    'find_id'  => $find_id,
				'user_id'  => $this->auth->id,
			    'content' => $content
			]);
			if($comments->save()){
				// 評論+1
				model('app\api\model\wanlshop\Find')->where(['id' => $find_id])->setInc('comments');
				$this->success('ok');
			}else{
				$this->error(__('コメントに失敗しました'));
			}
		}
		$this->error(__('違法なリクエスト'));
	}
	
	/**
	 * 點贊評論列表
	 *
	 * @ApiSummary  (WanlShop 發現評論列表)
	 * @ApiMethod   (get)
	 * 
	 * @param string $id 發現ID
	 */
	public function commentsLike($id = null, $state = null)
	{
		$like = model('app\api\model\wanlshop\FindComments')->get($id);
		if($state == 'true'){
			$like->setInc('like');
		}else if($state == 'false'){
			$like->setDec('like');
		}
		$this->success('ok');
	}
	
	/**
	 * 關註或取消動態
	 *
	 * @ApiSummary  (WanlShop 關註或取消動態)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 發現ID
	 */
	public function setFollow()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('id');
			$id ? $id : ($this->error(__('異常な訪問')));
			$where['find_id'] = $id;
			$where['user_id'] = $this->auth->id;
			if(model('app\api\model\wanlshop\FindFollow')->where($where)->count() == 0){
				model('app\api\model\wanlshop\FindFollow')->save($where);
				$this->model->where(['id'=>$id])->setInc('like'); //喜歡+1
				$this->success('成功を返す', true);
			}else{
				model('app\api\model\wanlshop\FindFollow')->where($where)->delete();
				$this->model->where(['id'=>$id])->setDec('like'); //喜歡-1
				$this->success('成功を返す', false);
			}
		}
		$this->error(__('異常な訪問'));
	}
	
    
}



