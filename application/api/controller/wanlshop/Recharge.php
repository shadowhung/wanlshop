<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop 反饋接口
 */
class Recharge extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new \app\api\model\wanlshop\Recharge;
	}
	
	/**
	 * 反饋列表
	 */
	public function lists()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$list = $this->model
			->where('user_id', $this->auth->id)
			->order('createtime desc')
			->paginate();
		$this->success('ok',$list);
	}
	
    /**
     * 反饋新增、讀取
     */
    public function add()
    {
    	//設置過濾方法
    	$this->request->filter(['strip_tags']);
    	if ($this->request->isPost()) {
    			$params = $this->request->post();
    		$user  = $this->auth->getUser(); 
    		$params['user_id'] = $this->auth->id;
    		$params['name'] = $user['nickname'];
    		$params['mobile'] = $user['mobile'];
    		$data = $this->model->allowField(true)->save($params);
    		$data? $this->success('ok',$data) : $this->error(__('サーバーがビジーです'));
    	}
    	$list = $this->model
    		->where('user_id', $this->auth->id)
    		->order('createtime desc')
    		->paginate();
    	$this->success('ok',$list);
    }
    
    
}
