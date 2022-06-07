<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 店铺管理
 *
 * @icon fa fa-circle-o
 */
class Shop extends Backend
{
    
    /**
     * Shop模型对象
     * @var \app\admin\model\wanlshop\Shop
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Shop;
        $this->view->assign("stateList", $this->model->getStateList());
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

                    ->with(['user','auth1'])
                    
                    ->where('`shop`.`id`!=-1')

                    ->where($where)

                    ->order($sort, $order)

                    ->count();

    

            $list = $this->model

                    ->with(['user','auth1'])
                    
                    ->where('`shop`.`id`!=-1')

                    ->where($where)

                    ->order($sort, $order)

                    ->limit($offset, $limit)

                    ->select();

    

            foreach ($list as $row) {
                $invitation  = model('app\admin\model\wanlshop\Auth')->where(['invitation' =>$row->user_id])->column('user_id');
                
                $shopname1   = model('app\admin\model\wanlshop\Auth')->where(['invitation' =>$row->user_id])->column('shopname');
                $mobile      = model('app\admin\model\wanlshop\Auth')->where(['invitation' =>$row->user_id])->column('mobile');
                $row->invitation = implode($invitation,"\r\n");
                $row->shopname1  = implode($shopname1,"\r\n");
                $row->mobile  = implode($mobile,"\r\n");
                
                
                $row->getRelation('user')->visible(['id','username']);
            }

            $list = collection($list)->toArray();

            $result = array("total" => $total, "rows" => $list);

    

            return json($result);

        }

        return $this->view->fetch();

    }
}
