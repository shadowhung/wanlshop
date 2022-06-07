<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
/**
 * WanlShop地址接口
 */
class Address extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    
    
    /**
     * 獲取地址列表
     *
     * @ApiSummary  (WanlShop 地址接口獲取地址列表)
     * @ApiMethod   (GET)
	 * 
	 */
    public function getaddress()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$list = model('app\api\model\wanlshop\Address')
			->where('user_id', $this->auth->id)
			->field('id,user_id,adcode,address,address_name,city,citycode,country,default,district,formatted_address,location,mobile,name,province')
			->order('updatetime desc')
			->paginate();
		$this->success('成功を返す', $list);
    }
    
    /**
     * 修改/新增地址
     *
     * @ApiSummary  (WanlShop 地址接口修改/新增地址)
     * @ApiMethod   (POST)
	 * 
	 * @param string $user_id 用戶ID
	 */
    public function address()
    {
        if ($this->request->isPost()) {
			//設置過濾方法
			$this->request->filter(['strip_tags']);
        	$request = $this->request->post();
        	$address = new \app\api\model\wanlshop\Address();
        	$data = $request['data'];
        	$data['user_id'] = $this->auth->id;
        	$count = $address->where(['user_id'=>$data['user_id']])->count();
			// 操作        	
        	switch ($request['type']) {
				case "edit": 
					if($count <= 1){
						$data['default'] = 1;
						$address->allowField(true)->save($data,['id' => $data['id']]);
						$this->success('ok','成功（デフォルトを変更できるのは1つだけです）');
					}else{
						// 更新
						$address->allowField(true)->save($data,['id' => $data['id']]);
						// 單獨設置默認，避免非默認消耗資源
						if($data['default'] == 1){
							$list = \app\api\model\wanlshop\Address::all(['user_id'=>$data['user_id']]);
							$list = collection($list)->toArray();
							$itemdata = [];
							foreach($list as $item){
							    if($item['id'] == $data['id']){
							    	$item['default'] = 1;
							    }else{
							    	$item['default'] = 0;
							    }
							    $itemdata[] = $item;
							}
							$address->allowField(true)->saveAll($itemdata);
						}
						$this->success('ok');
					}
					break;
				case "add": 
					if($count == 0){
						// 新增
						$data['default'] = 1;
						$address->data($data);
						$address->save();
						$this->success('アドレスコールバック',$address);
					}else{
						$address->data($data);
						$address->save();
						if($data['default'] == 1){
							$list = \app\api\model\wanlshop\Address::all(['user_id'=>$data['user_id']]);
							$list = collection($list)->toArray();
							$itemdata = [];
							foreach($list as $item){
							    if($item['id'] == $address->id){
							    	$item['default'] = 1;
							    }else{
							    	$item['default'] = 0;
							    }
							    $itemdata[] = $item;
							}
							$address->saveAll($itemdata);
						}
						$this->success('正常に追加されました',[]);		
					}
					break;
			}
		} else {
		    $this->error(__('違法なリクエスト'));
		}
    }
	
    /**
     * 刪除地址
     *
     * @ApiSummary  (WanlShop 地址接口刪除地址)
     * @ApiMethod   (POST)
	 * 
	 * @param string $id 地址ID
	 */
    public function deladdress()
    {
        if ($this->request->isPost()) {
			//設置過濾方法
			$this->request->filter(['strip_tags']);
        	$id = $this->request->post('id');
        	if (!$id) {
	            $this->error(__('Invalid parameters'));
	        }
        	if(model('app\api\model\wanlshop\Address')->where(['id'=>$id,'user_id'=>$this->auth->id])->delete()){
        		$this->success(__('正常に削除されました',[]));
        	}else{
        		$this->error(__('削除に失敗しました'));
        	}
		} else {
		    $this->error(__('違法なリクエスト'));
		}
    }
}
