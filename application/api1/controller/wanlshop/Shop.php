<?php

namespace app\api1\controller\wanlshop;

use app\common\controller\Api;

use addons\wanlshop\library\WanlChat\WanlChat;
use fast\Tree;
/**
 * WanlShop店铺接口
 */
class Shop extends Api
{
    protected $noNeedLogin = ['page'];
    protected $noNeedRight = ['*'];

	

	public function _initialize()

	{

	    parent::_initialize();

		$this->wanlchat = new WanlChat();

	}
    
	/**
	 * 查询店铺信息 1.0.2升级
	 *
	 * @ApiSummary  (WanlShop 查询店铺信息)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 店铺ID
	 */
	public function shop()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {

			$id = $this->request->post('id');

			// 1.0.2升级 判断来源

			$type = $this->request->post('type');

			$id ? $id : ($this->error(__('非正常访问')));
			$row = model('app\api1\model\wanlshop\Shop')
				->where(['id' => $id])
				->field('id,user_id,shopname,avatar,state,level,city,like,isself,createtime')
				->find();
			if($row){

				if($type == 'chat'){

					if(!$this->wanlchat->isWsStart()){

						$this->error('请启动IM即时通讯服务');

					}else{

						// 查询是否发送离线消息

						$shop_config = model('app\api1\model\wanlshop\ShopConfig')

							->where(['shop_id' => $row['id']])

							->find();

						// 查询是否存在聊天记录，如果不存在则发送欢迎消息

						if($shop_config['welcome']){

							$count = model('app\api1\model\wanlshop\Chat')->where("((form_uid={$row['user_id']} and to_id={$this->auth->id}) or (form_uid={$this->auth->id} and to_id={$row['user_id']})) and type='chat'")->count();

							if($count == 0){

								$this->wanlchat->send($this->auth->id, [

									'id' => $count + 1,

									'to_id' => $this->auth->id,

									'type' => 'chat',

									'form' => [

										'id' => $row['user_id'],

										'shop_id' => $row['id'],

										'name' => $row['shopname'],

										'avatar' => $row['avatar']

									],

									'message' => [

										'type' => 'text',

										'content' => [

											'text' => $shop_config['welcome']

										]

									],

									'createtime' => time()

								]);

							}

						}

						// 查询商家是否在线

						$row['isOnline'] = $this->wanlchat->isOnline($row['user_id']);

					}

				}

				$this->success('返回成功', $row);
			}

			if($type == 'chat'){

				$this->error(__('对方不是商家，禁止操作'));

			}
		}
		$this->error(__('非正常访问'));
	}
	
    /**
     * 获取自定义页面
     *
     * @ApiSummary  (WanlShop 获取商家数据)
     * @ApiMethod   (POST)
     *
     * @param string $id 页面ID
     */
    public function page()
    {
		//设置过滤方法
		$this->request->filter(['strip_tags']);
        $id = $this->request->request('id');
		$id?'':($this->error(__('Invalid parameters')));
		// 查询店铺
        $shop = model('app\api1\model\wanlshop\Shop')
			->where(['id' => $id])
			// ->field('id,service_ids,avatar,shopname,like')
			->find();
		// 查询是否关注
		if ($this->auth->isLogin()) {
			$shop['follow'] = model('app\api1\model\wanlshop\ShopFollow')->where(['user_id'=>$this->auth->id, 'shop_id'=>$id])->count() == 0?false:true; //关注
		}else{
			$shop['follow'] = false;
		}
		$tree = Tree::instance();
		$tree->init(model('app\api1\model\wanlshop\ShopSort')->where(['shop_id' => $id])->field('id, pid, name, image')->order('weigh asc')->select());
		$category = $tree->getTreeArray(0);
		$result = [
			'shop' => $shop,
			'category' => $category,
			'page' => model('app\api1\model\wanlshop\Page')
				->where(['shop_id' => $id, 'type' => 'shop'])
				->field('id,name,page,item')
				->find()
		];
        $this->success('返回成功', $result);
    }
	
	/**
	 * 商家入驻
	 *
	 * @ApiSummary  (WanlShop 店铺接口商家入驻)
	 * @ApiMethod   (POST)
	 */
	public function apply()

	{

		//设置过滤方法

		$this->request->filter(['strip_tags']);

		$row = model('app\api1\model\wanlshop\Auth')

			->where(['user_id' => $this->auth->id])

			->find();

		if ($this->request->isPost()) {

			$params = $this->request->post();

			$data = [

				'name' => $params['name'],

				'user_id' => $this->auth->id,

				'number' => $params['number'],

				'image' => $params['image'],

				'trademark' => $params['trademark'],

				'wechat' => $params['wechat'],

				'mobile' => $params['mobile'],

				'state' => 1

			];

			if($row){

				$row->save($data);

			}else{

				model('app\api1\model\wanlshop\Auth')->data($data)->save();

			}

			$this->success('返回成功', $params);

		}

		$this->success('返回成功', $row);

	}
	
	
	/**
	 * 关注店铺
	 *
	 * @ApiSummary  (WanlShop 关注或取消店铺)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 店铺ID
	 */
	public function follow()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('id');
			$id ? $id : ($this->error(__('非正常访问')));
			$where['shop_id'] = $id;
			$where['user_id'] = $this->auth->id;
			if(model('app\api1\model\wanlshop\ShopFollow')->where($where)->count() == 0){
				model('app\api1\model\wanlshop\ShopFollow')->save($where);
				model('app\api1\model\wanlshop\Shop')->where(['id'=>$id])->setInc('like'); //喜欢+1
				$this->success('返回成功', true);
			}else{
				model('app\api1\model\wanlshop\ShopFollow')->where($where)->delete();
				model('app\api1\model\wanlshop\Shop')->where(['id'=>$id])->setDec('like'); //喜欢-1
				$this->success('返回成功', false);
			}
		}
		$this->error(__('非正常访问'));
	}
	
	
	/**
	 * 关注店铺列表
	 */
	public function followList()
	{
		$goods = model('app\api1\model\wanlshop\ShopFollow')
			->where(['user_id' => $this->auth->id])
			->field('shop_id')
			->paginate()
			->each(function($data, $key){
				$data['shop'] = $data->shop->visible(['shopname','avatar','state','level','city','like']);
				return $data;
			});
			
	    $this->success('返回成功', $goods);
	}
}