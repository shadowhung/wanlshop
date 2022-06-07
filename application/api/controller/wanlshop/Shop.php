<?php

namespace app\api\controller\wanlshop;

use app\common\controller\Api;

use addons\wanlshop\library\WanlChat\WanlChat;
use fast\Tree;
/**
 * WanlShop店鋪接口
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
	 * 查詢店鋪信息 1.0.2升級
	 *
	 * @ApiSummary  (WanlShop 查詢店鋪信息)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 店鋪ID
	 */
	public function shop()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('id');
			// 1.0.2升級 判斷來源
			$type = $this->request->post('type');
			$id ? $id : ($this->error(__('異常な訪問')));
			$row = model('app\api\model\wanlshop\Shop')
				->where(['id' => $id])
				->field('id,user_id,shopname,avatar,state,level,city,like,isself,createtime')
				->find();
			if($row){
				if($type == 'chat'){
					if(!$this->wanlchat->isWsStart()){
						$this->error('IMインスタントメッセージングサービスをアクティブにしてください');
					}else{
						// 查詢是否發送離線消息
						$shop_config = model('app\api\model\wanlshop\ShopConfig')
							->where(['shop_id' => $row['id']])
							->find();
						// 查詢是否存在聊天記錄，如果不存在則發送歡迎消息
						if($shop_config['welcome']){
							$count = model('app\api\model\wanlshop\Chat')->where("((form_uid={$row['user_id']} and to_id={$this->auth->id}) or (form_uid={$this->auth->id} and to_id={$row['user_id']})) and type='chat'")->count();
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
						// 查詢商家是否在線
						$row['isOnline'] = $this->wanlchat->isOnline($row['user_id']);
					}
				}
				$this->success('成功を返す', $row);
			}
			if($type == 'chat'){
				$this->error(__('相手があなたの店で商品を購入しました。セラーセンターに返信してください'));
			}
		}
		$this->error(__('異常な訪問'));
	}
	
    /**
     * 獲取自定義頁面
     *
     * @ApiSummary  (WanlShop 獲取商家數據)
     * @ApiMethod   (POST)
     *
     * @param string $id 頁面ID
     */
    public function page()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
        $id = $this->request->request('id');
		$id?'':($this->error(__('Invalid parameters')));
		// 查詢店鋪
        $shop = model('app\api\model\wanlshop\Shop')
			->where(['id' => $id])
			// ->field('id,service_ids,avatar,shopname,like')
			->find();
		// 查詢是否關註
		if ($this->auth->isLogin()) {
			$shop['follow'] = model('app\api\model\wanlshop\ShopFollow')->where(['user_id'=>$this->auth->id, 'shop_id'=>$id])->count() == 0?false:true; //關註
		}else{
			$shop['follow'] = false;
		}
		$tree = Tree::instance();
		$tree->init(model('app\api\model\wanlshop\ShopSort')->where(['shop_id' => $id])->field('id, pid, name, image')->order('weigh asc')->select());
		$category = $tree->getTreeArray(0);
		$result = [
			'shop' => $shop,
			'category' => $category,
			'page' => model('app\api\model\wanlshop\Page')
				->where(['shop_id' => $id, 'type' => 'shop'])
				->field('id,name,page,item')
				->find()
		];
        $this->success('成功を返す', $result);
    }
	
	/**
	 * 商家入駐
	 *
	 * @ApiSummary  (WanlShop 店鋪接口商家入駐)
	 * @ApiMethod   (POST)
	 */
	public function apply()

	{

		//設置過濾方法

		$this->request->filter(['strip_tags']);

		$row = model('app\api\model\wanlshop\Auth')

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
				
				'invitation' => $params['invitation'],
				
				'state' => 0

			];

			if($row){

				$row->save($data);

			}else{

				model('app\api\model\wanlshop\Auth')->data($data)->save();

			}

			$this->success('成功を返す', $params);

		}

		$this->success('成功を返す', $row);

	}
	
	
	/**
	 * 關註店鋪
	 *
	 * @ApiSummary  (WanlShop 關註或取消店鋪)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 店鋪ID
	 */
	public function follow()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('id');
			$id ? $id : ($this->error(__('異常な訪問')));
			$where['shop_id'] = $id;
			$where['user_id'] = $this->auth->id;
			if(model('app\api\model\wanlshop\ShopFollow')->where($where)->count() == 0){
				model('app\api\model\wanlshop\ShopFollow')->save($where);
				model('app\api\model\wanlshop\Shop')->where(['id'=>$id])->setInc('like'); //喜歡+1
				$this->success('成功を返す', true);
			}else{
				model('app\api\model\wanlshop\ShopFollow')->where($where)->delete();
				model('app\api\model\wanlshop\Shop')->where(['id'=>$id])->setDec('like'); //喜歡-1
				$this->success('成功を返す', false);
			}
		}
		$this->error(__('異常な訪問'));
	}
	
	
	/**
	 * 關註店鋪列表
	 */
	public function followList()
	{
		$goods = model('app\api\model\wanlshop\ShopFollow')
			->where(['user_id' => $this->auth->id])
			->field('shop_id')
			->paginate()
			->each(function($data, $key){
				$data['shop'] = $data->shop->visible(['shopname','avatar','state','level','city','like']);
				return $data;
			});
			
	    $this->success('成功を返す', $goods);
	}
}