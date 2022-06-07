<?php

namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;

/**
 * 圖標管理
 *
 * @icon fa fa-circle-o
 */
class Icon extends Wanlshop
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    /**
     * Icon模型對象
     * @var \app\admin\model\wanlshop\Icon
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\Icon;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 查看
     */
    public function index()
    {
        //當前是否為關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();
    
            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
                
            $list = collection($list)->toArray();
            
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }
    
    /**
     * 選擇鏈接
     */
    public function select()
    {
        if ($this->request->isAjax()) {
            return $this->index();
        }
        return $this->view->fetch();
    }
}
