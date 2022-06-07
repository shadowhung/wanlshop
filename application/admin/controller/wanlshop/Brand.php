<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 品牌管理
 *
 * @icon fa fa-circle-o
 */
class Brand extends Backend
{
    
    /**
     * Brand模型对象
     * @var \app\admin\model\wanlshop\Brand
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Brand;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("stateList", $this->model->getStateList());
    }
	
	/**
	 * 查看
	 */
	public function index()
	{
	    //当前是否为关联查询
	    $this->relationSearch = true;
	    //设置过滤方法
	    $this->request->filter(['strip_tags', 'trim']);
	    if ($this->request->isAjax())
	    {
	        //如果发送的来源是Selectpage，则转发到Selectpage
	        if ($this->request->request('keyField'))
	        {
	            return $this->selectpage();
	        }
	        list($where, $sort, $order, $offset, $limit) = $this->buildparams();
	        $total = $this->model
	                ->with(['category'])
	                ->where($where)
	                ->order($sort, $order)
	                ->count();
	
	        $list = $this->model
	                ->with(['category'])
	                ->where($where)
	                ->order($sort, $order)
	                ->limit($offset, $limit)
	                ->select();
	
	        foreach ($list as $row) {
	            
	            $row->getRelation('category')->visible(['name']);
	        }
	        $list = collection($list)->toArray();
	        $result = array("total" => $total, "rows" => $list);
	
	        return json($result);
	    }
	    return $this->view->fetch();
	}
	
	/**
	 * 审核品牌
	 */
	public function examine($ids = null)
	{
		$row = $this->model->get($ids);
		if (!$row) {
		    $this->error(__('No Results were found'));
		}
		if ($this->request->isPost()) {
		   $result = $row->allowField(true)->save(['state' => 1]);
		   $result ? $this->success(__('审核成功')) : $this->error(__('审核失败'));
		}
	}
	
	
	
	
	
}
