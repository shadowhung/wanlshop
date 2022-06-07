<?php



namespace app\index\controller\wanlshop;



use app\common\controller\Wanlshop;

use think\Db;

/**

 * 卡券管理

 *

 * @icon fa fa-circle-o

 */

class Coupon extends Wanlshop

{

    protected $noNeedLogin = '';

    protected $noNeedRight = '*';



    public function _initialize()

    {

        parent::_initialize();

        $this->model = new \app\index\model\wanlshop\Coupon;

        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("usertypeList", $this->model->getUsertypeList());
        $this->view->assign("rangetypeList", $this->model->getRangetypeList());
        $this->view->assign("pretypeList", $this->model->getPretypeList());

    }

	

    /**

     * 查看

     */

    public function index()

    {

        //設置過濾方法

        $this->request->filter(['strip_tags']);

        if ($this->request->isAjax()) {

            //如果發送的來源是Selectpage，則轉發到Selectpage

            if ($this->request->request('keyField')) {

                return $this->selectpage();

            }

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

     * 回收站

     */

    public function recyclebin()

    {

        //設置過濾方法

        $this->request->filter(['strip_tags']);

        if ($this->request->isAjax()) {

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model

                ->onlyTrashed()

                ->where($where)

                ->order($sort, $order)

                ->count();

    

            $list = $this->model

                ->onlyTrashed()

                ->where($where)

                ->order($sort, $order)

                ->limit($offset, $limit)

                ->select();

    

            $result = array("total" => $total, "rows" => $list);

    

            return json($result);

        }

        return $this->view->fetch();

    }

    

    /**

     * 添加

     */

    public function add()

    {

    	//設置過濾方法

    	$this->request->filter(['strip_tags', 'trim']);

        if ($this->request->isPost()) {

            $params = $this->request->post("row/a");

            if ($params) {

                $params['shop_id'] = $this->shop->id;

                $result = false;

                Db::startTrans();

                try {

					

					

					

					

					

					

					$params['surplus'] = $params['grant'] == '-1' ? 9999 : $params['grant'];

					

					

					

                    $result = $this->model->allowField(true)->save($params);

                    Db::commit();

                } catch (ValidateException $e) {

                    Db::rollback();

                    $this->error($e->getMessage());

                } catch (PDOException $e) {

                    Db::rollback();

                    $this->error($e->getMessage());

                } catch (Exception $e) {

                    Db::rollback();

                    $this->error($e->getMessage());

                }

                if ($result !== false) {

                    $this->success();

                } else {

                    $this->error(__('No rows were inserted'));

                }

            }

            $this->error(__('Parameter %s can not be empty', ''));

        }

        return $this->view->fetch();

    }

    

    /**

     * 編輯

     */

    public function edit($ids = null)

    {

        $row = $this->model->get($ids);

        if (!$row) {

            $this->error(__('No Results were found'));

        }

        if ($row['shop_id'] !=$this->shop->id) {

            $this->error(__('You have no permission'));

        }

        if ($this->request->isPost()) {

            $params = $this->request->post("row/a");

            if ($params) {

                $result = false;

                Db::startTrans();

                try {

					$params['surplus'] = $params['grant'] == '-1' ? 9999 : $params['grant'];

                    $result = $row->allowField(true)->save($params);

                    Db::commit();

                } catch (ValidateException $e) {

                    Db::rollback();

                    $this->error($e->getMessage());

                } catch (PDOException $e) {

                    Db::rollback();

                    $this->error($e->getMessage());

                } catch (Exception $e) {

                    Db::rollback();

                    $this->error($e->getMessage());

                }

                if ($result !== false) {

                    $this->success();

                } else {

                    $this->error(__('No rows were inserted'));

                }

            }

            $this->error(__('Parameter %s can not be empty', ''));

        }

		$this->assignconfig("row", $row);

        $this->view->assign("row", $row);

        return $this->view->fetch();

    }

	

	

	/**

	 * 刪除

	 */

	public function del($ids = "")

	{

	    if ($ids) {

	        $pk = $this->model->getPk();

	        $this->model->where('shop_id', '=', $this->shop->id);

	        $list = $this->model->where($pk, 'in', $ids)->select();

	

	        $count = 0;

	        Db::startTrans();

	        try {

	            foreach ($list as $k => $v) {

	                $count += $v->delete();

	            }

	            Db::commit();

	        } catch (PDOException $e) {

	            Db::rollback();

	            $this->error($e->getMessage());

	        } catch (Exception $e) {

	            Db::rollback();

	            $this->error($e->getMessage());

	        }

	        if ($count) {

	            $this->success();

	        } else {

	            $this->error(__('No rows were deleted'));

	        }

	    }

	    $this->error(__('Parameter %s can not be empty', 'ids'));

	}

	

	

	

	/**

	 * 還原

	 */

	public function restore($ids = "")

	{

	    $pk = $this->model->getPk();

	    $this->model->where('shop_id', '=', $this->shop->id);

	    if ($ids) {

	        $this->model->where($pk, 'in', $ids);

	    }

	    $count = 0;

	    Db::startTrans();

	    try {

	        $list = $this->model->onlyTrashed()->select();

	        foreach ($list as $index => $item) {

	            $count += $item->restore();

	        }

	        Db::commit();

	    } catch (PDOException $e) {

	        Db::rollback();

	        $this->error($e->getMessage());

	    } catch (Exception $e) {

	        Db::rollback();

	        $this->error($e->getMessage());

	    }

	    if ($count) {

	        $this->success();

	    }

	    $this->error(__('No rows were updated'));

	}

	

	

	

	

	

	

	

}

