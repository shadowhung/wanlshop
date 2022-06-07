<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 图标管理
 *
 * @icon fa fa-circle-o
 */
class Icon extends Backend
{
    
    /**
     * Icon模型对象
     * @var \app\admin\model\wanlshop\Icon
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Icon;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
	/**
	 * 选择链接
	 */
	public function select()
	{
	    if ($this->request->isAjax()) {
	        return $this->index();
	    }
	    return $this->view->fetch();
	}

}
