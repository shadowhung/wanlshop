<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 搜索管理
 *
 * @icon fa fa-circle-o
 */
class Search extends Backend
{
    
    /**
     * Search模型对象
     * @var \app\admin\model\wanlshop\Search
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Search;
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
}
