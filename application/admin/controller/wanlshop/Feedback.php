<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Db;
/**
 * 意见反馈表 
 *
 * @icon fa fa-circle-o
 */
class Feedback extends Backend
{
    
    /**
     * Feedback模型对象
     * @var \app\admin\model\wanlshop\Feedback
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Feedback;
        $this->view->assign("statusList", $this->model->getStatusList());
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
					$params['status'] = 'hidden';
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
