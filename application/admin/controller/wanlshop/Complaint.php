<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Db;
/**
 * 举报管理
 *
 * @icon fa fa-circle-o
 */
class Complaint extends Backend
{
    
    /**
     * Complaint模型对象
     * @var \app\admin\model\wanlshop\Complaint
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Complaint;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("reasonList", $this->model->getReasonList());
        $this->view->assign("stateList", $this->model->getStateList());
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
                    ->with(['user','goods','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','goods','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                
                $row->getRelation('user')->visible(['username','nickname']);
				$row->getRelation('goods')->visible(['title']);
				$row->getRelation('shop')->visible(['shopname']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
	
	
	/**
	 * 退款详情
	 */
	public function detail($ids = null)
	{
	    $row = $this->model->get($ids);
	    if (!$row) {
	        $this->error(__('No Results were found'));
	    }
		if ($this->request->isPost()) {
		    $params = $this->request->post("row/a");
		    if ($params) {
		        $params = $this->preExcludeFields($params);
		        $result = false;
		        Db::startTrans();
		        try {
		            //是否采用模型验证
		            if ($this->modelValidate) {
		                $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
		                $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
		                $row->validateFailException(true)->validate($validate);
		            }
					$params['state'] = 'hidden';
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
		            $this->error(__('No rows were updated'));
		        }
		    }
		    $this->error(__('Parameter %s can not be empty', ''));
		}
	    $this->view->assign("row", $row);
		return $this->view->fetch();
	}
}
