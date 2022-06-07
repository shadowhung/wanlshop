<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop 投訴舉報接口
 */
class Complaint extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new \app\api\model\wanlshop\Complaint;
	}
	
	/**
	 * 投訴舉報列表
	 */
	public function lists()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$list = $this->model
			->where('user_id', $this->auth->id)
			->order('createtime desc')
			->paginate();
		foreach ($list as $row) {
			if($row['type'] == 1){
				$row->goods->visible(['id','title','image','price']);
			}
		}
		$this->success('ok',$list);
	}
    
    /**
     * 舉報新增、讀取
     */
    public function add()
    {
    	//設置過濾方法
    	$this->request->filter(['strip_tags']);
    	if ($this->request->isPost()) {
    		$params = $this->request->post();
    		$params['user_id'] = $this->auth->id;
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
