<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop購物車接口
 */
class Cart extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    

	public function _initialize()

	{

	    parent::_initialize();

	    $this->model = new \app\api\model\wanlshop\Cart;

	}

	

	/**
	 * 獲取或合並購物車
	 *
	 * @ApiSummary  (WanlShop 購物車接口獲取或合並購物車)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $cart 本地購物車數據
	 */
	public function synchro()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
			$user_id = $this->auth->id;
			// 如果存在合並購物車，返回；否則獲取購物車
			if($post['cart']){
			    $newlist = [];
				foreach($post['cart'] as $row){
					$where = [
						'goods_id' => $row['goods_id'],
						'shop_id' => $row['shop_id'],
						'sku_id' => $row['sku_id'],
						'user_id' => $user_id
					];
					$cart = $this->model->where($where)->find();
					if(!$cart){

						// 局部寫入 1.0.2升級

						$where['number'] = $row['number'];
					    $newlist[] = $where;

					}
				}
				if(count($newlist) > 0){
				    $this->model->saveAll($newlist, false);
				}
			}

			// 查詢購物車最新商品詳情 1.0.2升級
			$list = [];

			foreach ($this->model->where('user_id', $user_id)->select() as $vo) {

				$sku = $vo->suk; //1.0.3升級 很詭異的問題命名sku和會產生沖突

				// 查詢是否還有庫存

				if($sku['stock'] > 0){

					$shop = $vo->shop;

					$goods = $vo->goods;

					$list[] = [

						'shop_id' => $shop['id'],

						'shop_name' => $shop['shopname'],

						'goods_id' => $goods['id'],

						'title' => $goods['title'],

						'image' => $goods['image'],

						'number' => $vo['number'],

						'sku_id' => $vo['sku_id'],

						'sku' => $sku,

						'sum' => bcmul($sku['price'], $vo['number'], 2),

						'checked' => false,

						

					];

				}

			}	

			$this->success('成功を返す', $list);
		}
		$this->error(__('異常なリクエスト'));
	}
	
	/**
	 * 操作購物車數據庫
	 *
	 * @ApiSummary  (WanlShop 購物車接口操作購物車數據庫)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $type 操作方式
	 * @param string $data 改變數據
	 */
	public function storage()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
			$user_id = $this->auth->id;
			$return = '';
			// 清空購物車
			if($post['type'] == 'empty'){
			    $this->model->where(['user_id' => $this->auth->id])->delete();
			// 新增購物車
			}else if($post['type'] == 'add'){
			    $row = $post['data'];
			    $where = [
					'goods_id' => $row['goods_id'],
					'shop_id' => $row['shop_id'],
					'sku_id' => $row['sku_id'],
					'user_id' => $user_id
				];
				// 查詢是否已存在，如果已存在只改變數量和總價
				$cart = $this->model->where($where)->find();
			    if($cart){
			        $number = $cart['number'] + $row['number'];
    				$params = [
    					'number' => $number,
    					'sum' => bcmul($cart['sku']['price'], $number)
    				];
    				$cart->save($params);
				}else{

					// 只新增ID，1.0.2升級

					$where['number'] = $row['number'];

				    $this->model->save($where, false);
				}
			// 新增購物車
			}else if($post['type'] == 'bcsub' || $post['type'] == 'bcadd'){	
			    $where = [
					'goods_id' => $post['goods_id'],
					'sku_id' => $post['sku_id'],
					'user_id' => $user_id
				];
				$cart = $this->model->where($where)->find();
				$cart->save(['number' => $post['number'], 'sum' => $post['sum']]);
			// 批量刪除
			}else if($post['type'] == 'del'){	
				foreach ($post['data'] as $row) {
		            $where = [
    					'goods_id' => $row['goods_id'],
    					'sku_id' => $row['sku_id'],
    					'user_id' => $user_id
    				];
                    $this->model->where($where)->delete();
                }
			// 先將傳來的批量寫進關註表，在刪除這些
			}else if($post['type'] == 'follow'){
			    $follow = [];
				foreach ($post['data'] as $row) {
		            $where = [
    					'goods_id' => $row['goods_id'],
    					'sku_id' => $row['sku_id'],
    					'user_id' => $user_id
    				];
    				$follow[] = [
    				    'user_id' => $user_id,
    				    'goods_id' => $row['goods_id']
    				];
                    $this->model->where($where)->delete();
                }
                $follow = array_unique($follow, SORT_REGULAR);
                $return = model('app\api\model\wanlshop\GoodsFollow')->saveAll($follow, false);
                $return = count($return);
			}else{
			    $this->error(__('ビジーネットワーク'));
			}
			$this->success('ショッピングカートの更新が完了しました。', $return);
		}
		$this->error(__('異常なリクエスト'));
	}

}
