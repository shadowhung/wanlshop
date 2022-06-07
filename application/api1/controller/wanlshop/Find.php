<?php
namespace app\api1\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop 发现接口
 */
class Find extends Api
{
    protected $noNeedLogin = ['find','menu','details','lists','shop','comments'];
	protected $noNeedRight = ['*'];
    
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new \app\api1\model\wanlshop\Find;
	}
	
	/**
	 * 发现列表
	 */
	public function menu($device = null)
	{
	    $menu = [];
	    // 获取配置
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
		        'contentrefresh' => '加载中',
		        'contentnomore' => '- 我是有底线的 -'
		    ]
		];
		$tplname = [
		    'all' => '关注',
		    'new' => '上新',
			'live' => '直播',
			'want' => '种草',
			'activity' => '活动',
			'show' => '买家秀'
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
	 * 发现列表
	 */
	public function find()
	{
		$this->request->filter(['strip_tags']);
		$type = $this->request->request('type');
		$user_id = $this->auth->id;
		// 查询所有关注
		$follow = model('app\api1\model\wanlshop\ShopFollow')
			->where(['user_id' => $user_id])
			->select();
		$followShop = [];
		foreach ($follow as $value) {
		    $followShop[] = $value['shop_id'];
		}
		
		//查询方法 关注 + 猜你喜欢店铺
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
		
		//查询列表
		$list = $this->model
			->where($where)
			->order('createtime desc')
			->paginate();
		// 插入其他数据	
		if($type == 'all'){
			
			
			
			
			
		}
		foreach ($list as $row) {
		    $row->shop->visible(['id','avatar','shopname']);
			// 查询直播详情
			if($row['type'] == 'live'){
				$row->live->visible(['id','goods_ids','like','state','views']);
			}
			$row->isFollow = in_array($row['shop_id'], $followShop);
			$row->isShopBut = in_array($row['shop_id'], $followShop); 
			
			$row->isLike = model('app\api1\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $user_id])->find() ? true : false; 
			$row->isLive = model('app\api1\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
			
			// 关联商品
			$row->goods = model('app\api1\model\wanlshop\Goods')
				->where('id','in',$row['goods_ids'])
				->field('id,title,image,price')
				->select();
			// 统计新品
			$row->newGoods = model('app\api1\model\wanlshop\Goods')
				->where('shop_id', $row['shop_id'])
				->whereTime('createtime', 'w') // 查询本周
				->count();
		}
		$this->success('ok',$list);
	}
	
	/**
	 * 我的点赞列表
	 *
	 * @ApiSummary  (WanlShop 我的点赞列表)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function follow()
	{
		$this->request->filter(['strip_tags']);
		$user_id = $this->auth->id;
		$find_id = [];
		// 获取你喜欢find
		$follow = model('app\api1\model\wanlshop\FindFollow')
			->where(['user_id' => $user_id])
			->field('find_id')
			->select();
		foreach ($follow as $vo)
		{
			$find_id[] = $vo['find_id'];
		}
		// 获取Find
		$list = $this->model
			->where('id', 'in', $find_id)
			->order('createtime desc')
			->paginate();
		foreach ($list as $row) {
		    $row->shop->visible(['id','avatar','shopname']);
			// 查询直播详情
			if($row['type'] == 'live'){
				$row->live->visible(['id','goods_ids','like','state','views']);
			}
			$row->isLike = model('app\api1\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $user_id])->find() ? true : false; 
			$row->isLive = model('app\api1\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
			// 关联商品
			$row->goods = model('app\api1\model\wanlshop\Goods')
				->where('id','in',$row['goods_ids'])
				->field('id,title,image,price')
				->select();
			// 统计新品
			$row->newGoods = model('app\api1\model\wanlshop\Goods')
				->where('shop_id', $row['shop_id'])
				->whereTime('createtime', 'w') // 查询本周
				->count();
		}
		$this->success('ok',$list);
	}
	
	
	
	/**
	 * 获取发现详情&列表
	 *
	 * @ApiSummary  (WanlShop 关注或取消动态)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 发现ID
	 */
	public function details($id = null)
	{
		$row = $this->model->get($id);
		$row ? $row : ($this->error(__('没有找到这个发现页')));
		// 获取其他数据
		$row->shop->visible(['id','avatar','shopname']);
		$follow = 0;
		$isLike = 0;
		$isLive = '';
		// 判断是否登录
		if($this->auth->isLogin()){
			$user_id = $this->auth->id;
			$follow = model('app\api1\model\wanlshop\ShopFollow')->where(['user_id' => $user_id, 'shop_id' => $row['shop_id']])->count();
			$isLike = model('app\api1\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $user_id])->count();
			$isLive = model('app\api1\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();
		}
		$row->isFollow = $follow == 0 ? false : true;
		$row->isShopBut = $follow == 0 ? false : true;
		$row->isLike = $isLike == 0 ? false : true;
		$row->isLive = $isLive ? $isLive : '';
		$row->current = 0;
		// 关联商品
		$row->goods = model('app\api1\model\wanlshop\Goods')
			->where('id','in',$row['goods_ids'])
			->field('id,title,image,price')
			->select();
		// 阅读量 +1
		$row->setInc('views');
		$this->success('ok',$row);
	}
	
	
	/**
	 * 获取发现商家列表
	 *
	 * @ApiSummary  (WanlShop 关注或取消动态)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 发现ID
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
			$row->goods = model('app\api1\model\wanlshop\Goods')
				->where('id','in',$row['goods_ids'])
				->field('id,title,image,price')
				->select();
			$isLike = 0;
			// 判断是否登录
			if($this->auth->isLogin()){
				$isLike = model('app\api1\model\wanlshop\FindFollow')->where(['find_id' => $row['id'], 'user_id' => $this->auth->id])->count();
			}
			$row->isLike = $isLike == 0 ? false : true;
			$row->current = 0;
		}
		$this->success('ok',$list);
	}
	
	
	/**
	 * 获取商家列表
	 *
	 * @ApiSummary  (WanlShop 关注或取消动态)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 发现ID
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
	 * 发现评论列表
	 *
	 * @ApiSummary  (WanlShop 发现评论列表)
	 * @ApiMethod   (get)
	 * 
	 * @param string $id 发现ID
	 */
	public function comments($find_id = null)
	{
		$list = model('app\api1\model\wanlshop\FindComments')
			->where(['find_id' => $find_id])
			->select();
		foreach ($list as $row) {
			$row->user->visible(['id','avatar','nickname']);
		}
		$this->success('ok',$list);
	}
	
	/**
	 * 发现页发表评论
	 *
	 * @ApiSummary  (WanlShop 发现评论列表)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 发现ID
	 */
	public function addComments()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$find_id = $this->request->post('find_id');
			$find_id ? $find_id : ($this->error(__('非法请求')));
			$content = $this->request->post('content');
			
			$comments = model('app\api1\model\wanlshop\FindComments');
			$comments->data([
			    'find_id'  => $find_id,
				'user_id'  => $this->auth->id,
			    'content' => $content
			]);
			if($comments->save()){
				// 评论+1
				model('app\api1\model\wanlshop\Find')->where(['id' => $find_id])->setInc('comments');
				$this->success('ok');
			}else{
				$this->error(__('评论失败'));
			}
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 点赞评论列表
	 *
	 * @ApiSummary  (WanlShop 发现评论列表)
	 * @ApiMethod   (get)
	 * 
	 * @param string $id 发现ID
	 */
	public function commentsLike($id = null, $state = null)
	{
		$like = model('app\api1\model\wanlshop\FindComments')->get($id);
		if($state == 'true'){
			$like->setInc('like');
		}else if($state == 'false'){
			$like->setDec('like');
		}
		$this->success('ok');
	}
	
	/**
	 * 关注或取消动态
	 *
	 * @ApiSummary  (WanlShop 关注或取消动态)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 发现ID
	 */
	public function setFollow()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('id');
			$id ? $id : ($this->error(__('非正常访问')));
			$where['find_id'] = $id;
			$where['user_id'] = $this->auth->id;
			if(model('app\api1\model\wanlshop\FindFollow')->where($where)->count() == 0){
				model('app\api1\model\wanlshop\FindFollow')->save($where);
				$this->model->where(['id'=>$id])->setInc('like'); //喜欢+1
				$this->success('返回成功', true);
			}else{
				model('app\api1\model\wanlshop\FindFollow')->where($where)->delete();
				$this->model->where(['id'=>$id])->setDec('like'); //喜欢-1
				$this->success('返回成功', false);
			}
		}
		$this->error(__('非正常访问'));
	}
	
    
}



