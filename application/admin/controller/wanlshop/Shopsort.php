<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use fast\Tree;
/**
 * 商家自定义分类
 *
 * @icon fa fa-circle-o
 */
class Shopsort extends Backend
{
    
    /**
     * Shopsort模型对象
     * @var \app\admin\model\wanlshop\Shopsort
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\ShopSort;

		$tree = Tree::instance();

		$tree->init(collection($this->model->order('weigh desc,id desc')->select())->toArray(), 'pid');

		$this->channelList = $tree->getTreeList($tree->getTreeArray(0), 'name');

		$this->view->assign("channelList", $this->channelList);

        $this->view->assign("flagList", $this->model->getFlagList());
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

                    ->with(['shop'])

                    ->where($where)

                    ->order($sort, $order)

                    ->count();

    

            $list = $this->model

                    ->with(['shop'])

                    ->where($where)

                    ->order($sort, $order)

                    ->limit($offset, $limit)

                    ->select();

    

            foreach ($list as $row) {

                

                $row->getRelation('shop')->visible(['shopname']);

            }

            $list = collection($list)->toArray();

			

			$tree = Tree::instance();

			$tree->init($list, 'pid');

            $result = array("total" => $total, "rows" => $tree->getTreeList($tree->getTreeArray(0), 'name'));

    

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
