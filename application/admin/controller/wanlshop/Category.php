<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use fast\Tree;
/**
 * 商品、文章类目管理
 *
 * @icon fa fa-circle-o
 */
class Category extends Backend
{
    
    /**
     * Category模型对象
     * @var \app\admin\model\wanlshop\Category
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Category;
		$tree = Tree::instance();
		$type = $this->request->request("type");
		if($type){
			$tree->init(collection($this->model->where('type', $type)->order('weigh desc,id desc')->select())->toArray(), 'pid');
		}else{
			$tree->init(collection($this->model->order('weigh desc,id desc')->select())->toArray(), 'pid');
		}
		$this->channelList = $tree->getTreeList($tree->getTreeArray(0), 'name');
		$this->view->assign("type", $type);
		$this->view->assign("channelList", $this->channelList);
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 查看
     */
	public function index()
	{
	    if ($this->request->isAjax()) {
			$list = $this->channelList;
	        $list = array_values($list);
	        $total = count($list);
	        $result = array("total" => $total, "rows" => $list);
	        return json($result);
	    }
	    return $this->view->fetch();
	}
	
	
	
	// 商品
	public function goods()
	{
	    if ($this->request->isAjax()) {
	        $list = [];
	        foreach ($this->channelList as $item) {
	            if ($item['type'] == 'goods') {
	                $list[] = $item;
	            }
	        }
	        $list = array_values($list);
	        $total = count($list);
	        $result = array("total" => $total, "rows" => $list);
	        return json($result);
	    }
	    return $this->view->fetch();
	}
	
	/**
	 * 选择链接
	 */
	public function select()
	{
	    if ($this->request->isAjax()) {
	        return $this->goods();
	    }
	    return $this->view->fetch();
	}
	
	
	// 文章
	public function article()
	{
	    if ($this->request->isAjax()) {
	        $list = [];
	        foreach ($this->channelList as $item) {
	            if ($item['type'] == 'article') {
	                $list[] = $item;
	            }
	        }
	        $list = array_values($list);
	        $total = count($list);
	        $result = array("total" => $total, "rows" => $list);
	        return json($result);
	    }
	    return $this->view->fetch();
	}
	
	/**
	 * 生成菜单
	 *
	 * @internal
	 */
	public function create()
	{
		if ($this->request->isPost()) {
			$params = $this->request->post("row/a");
			$list = [];
			foreach(explode("\r\n", $params['name']) as $name){
				$list[] = [
					'pid' => $params['pid'],
					'type' => 'goods',
					'isnav' => 1,
					'name' => $name,
					'image' => '/uploads/category/category_'.\fast\Pinyin::get($name).'3x.jpg'
				];
			}
			// 生成菜单
			if ($this->model->saveAll($list) !== false) {
			    $this->success('一键批量生成类目成功！');
			} else {
			    $this->error(__('No rows were inserted'));
			}
		}
		return $this->view->fetch();
	}
	
	
	/**
	 * Selectpage搜索
	 *
	 * @internal
	 */
	public function selectpage()
	{
	    return parent::selectpage();
	}
}