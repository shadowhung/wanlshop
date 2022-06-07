<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 订单管理
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    
    /**
     * Order模型对象
     * @var \app\admin\model\wanlshop\Order
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Order;
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
                    ->with(['user','shop'])
                    //->with(['user','shop','pay','ordergoods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->getRelation('user')->visible(['username','mobile','nickname','isshua']);
                $user_id = $row->getRelation('shop')->user_id;
                $row->puserid =  model('app\common\model\User')->where(['id' =>$user_id])->find();
                //$row->getRelation('shop')->visible(['shopname']);
                //$row->getRelation('pay')->visible(['pay_no','price','order_price','freight_price','discount_price','actual_payment']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

	

	/**

	 * 详情

	 */

	public function detail($id = null)

	{

		$row = $this->model->get($id);

		if (!$row) {

			$this->error(__('No Results were found'));

		}

		$row['address'] = model('app\api\model\wanlshop\OrderAddress')

			->where(['order_id' => $id])

			->order('isaddress desc')

			->field('id,name,mobile,address,address_name')

			->find();

			

		// 查询快递状态

		switch ($row['state']) {

			case 1:

				$express = [

					'context' => '付款后，即可将商品发出',

					'status' => '尚未付款',

					'time' => date('Y-m-d H:i:s', $row['createtime'])

				];

				break;

			case 2:

				$express = [

					'context' => '商家正在处理订单',

					'status' => '已付款',

					'time' => date('Y-m-d H:i:s', $row['paymenttime'])

				];

				break;

			default: // 获取物流

				$eData = model('app\api\model\wanlshop\KuaidiSub')

					->where(['express_no' => $row['express_no']])

					->find();

				$ybData = json_decode($eData['data'], true);

				if($ybData){

					$express = $ybData[0];

				}else{

					$express = [

						'status' => '已发货',
						
						'context' => '包裹已發貨，請耐心等待收貨~',
						//'context' => '包裹正在等待快递小哥揽收~',

						'time' => date('Y-m-d H:i:s', $row['delivertime'])

					];

				}

		}

		$this->view->assign("kuaidi", $express);

		$this->view->assign("row", $row);

		return $this->view->fetch();

	}

	

	/**

	 * 快递查询

	 */

	public function relative($id = null)

	{

		$row = $this->model->get($id);

		if (!$row) {

			$this->error(__('No Results were found'));

		}

		$data = model('app\api\model\wanlshop\KuaidiSub')

			->where(['express_no' => $row['express_no']])

			->find();

		$data = json_decode($data['data'], true);

		$list = [];

		$week = array(

		    "0"=>"星期日",

		    "1"=>"星期一",

		    "2"=>"星期二",

		    "3"=>"星期三",

		    "4"=>"星期四",

		    "5"=>"星期五",

		    "6"=>"星期六"

		);

		if($data){

			foreach($data as $vo){

				$list[] = [

					'time' => strtotime($vo['time']),

					'status' => $vo['status'],

					'context' => $vo['context'],

					'week' => $week[date('w', strtotime($vo['time']))]

				];

			}

		}

		$this->view->assign("week", $week);

		$this->view->assign("list", $list);

		$this->view->assign("row", $row);

		return $this->view->fetch();

	}

}
