<?php
namespace app\api1\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop 投诉举报接口
 */
class Complaint extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new \app\api1\model\wanlshop\Complaint;
	}
	
	/**
	 * 投诉举报列表
	 */
	public function lists()
	{
		//设置过滤方法
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
     * 举报新增、读取
     */
    public function add()
    {
    	//设置过滤方法
    	$this->request->filter(['strip_tags']);
    	if ($this->request->isPost()) {
    		$params = $this->request->post();
    		$params['user_id'] = $this->auth->id;
    		$data = $this->model->allowField(true)->save($params);
    		$data? $this->success('ok',$data) : $this->error(__('服务器繁忙'));
    	}
    	$list = $this->model
    		->where('user_id', $this->auth->id)
    		->order('createtime desc')
    		->paginate();
    	$this->success('ok',$list);
    }
    
    
    
}
