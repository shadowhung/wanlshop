<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 广告管理
 *
 * @icon fa fa-circle-o
 */
class Advert extends Backend
{
    
    /**
     * Advert模型对象
     * @var \app\admin\model\wanlshop\Advert
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Advert;
        $this->view->assign("moduleList", $this->model->getModuleList());
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("statusList", $this->model->getStatusList());
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
