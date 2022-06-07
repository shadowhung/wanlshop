<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 地址管理
 *
 * @icon fa fa-circle-o
 */
class Address extends Backend
{
    
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Address;
        $this->view->assign("defaultList", $this->model->getDefaultList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
}
