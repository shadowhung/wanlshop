<?php
// 2020年2月17日22:04:56
namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 物流管理
 *
 * @icon fa fa-circle-o
 */
class Logistics extends Backend
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\ShopFreight;
        $this->view->assign("deliveryList", $this->model->getDeliveryList());
        $this->view->assign("isdeliveryList", $this->model->getIsdeliveryList());
        $this->view->assign("valuationList", $this->model->getValuationList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 发货
     */
    public function deliver()
    {
        $this->view->assign("stateList", ['2' => __('待发货订单'), '3' => __('发货中订单')]);
        return $this->view->fetch('wanlshop/wholeorder/index');
    }
    
    /**
     * 运费模板
     */
    public function template()
    {
        return $this->view->fetch('wanlshop/freightfront/index');
    }
}
