<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 二维码配置管理
 *
 * @icon fa fa-circle-o
 */
class Qrcode extends Backend
{
    
    /**
     * Qrcode模型对象
     * @var \app\admin\model\wanlshop\Qrcode
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Qrcode;
        $this->view->assign("templateList", $this->model->getTemplateList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

}
