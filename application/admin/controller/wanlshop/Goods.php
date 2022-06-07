<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 商品管理
 *
 * @icon fa fa-circle-o
 */
class Goods extends Backend
{
    
    /**
     * Goods模型对象
     * @var \app\admin\model\wanlshop\Goods
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Goods;
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("stockList", $this->model->getStockList());
        $this->view->assign("specsList", $this->model->getSpecsList());
        $this->view->assign("distributionList", $this->model->getDistributionList());
        $this->view->assign("activityList", $this->model->getActivityList());
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

                    ->with(['category','shopsort','shop'])

                    ->where($where)

                    ->order($sort, $order)

                    ->count();

    

            $list = $this->model

                    ->with(['category','shopsort','shop'])

                    ->where($where)

                    ->order($sort, $order)

                    ->limit($offset, $limit)

                    ->select();

    

            foreach ($list as $row) {

                $row->getRelation('category')->visible(['name']);

                $row->getRelation('shopsort')->visible(['name']);

                $row->getRelation('shop')->visible(['shopname']);

            }

            $list = collection($list)->toArray();

            $result = array("total" => $total, "rows" => $list);

    

            return json($result);

        }

        return $this->view->fetch();

    }
    
    public function sales($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }

        $sales = $this->request->post('sales/f', 0);
        if ($sales < 0 || $sales - $row['sales'] == 0) {
            $this->error('没有改变');
        }

        $this->model->startTrans();
        try {
            /*CoinPriceLog::create([
                'coin_id' => $row['id'],
                'admin_id' => $this->auth->id,
                'sales' => $sales,
                'direction' => $sales - $row['sales'] > 0 ? 1 : 2
            ]);*/

            $row->sales = $sales;
            $row->save();

            $this->model->commit();
        } catch (Exception $e) {
            $this->model->rollback();
            $this->error('操作失败');
        }
        $this->success('价格修改成功');
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
