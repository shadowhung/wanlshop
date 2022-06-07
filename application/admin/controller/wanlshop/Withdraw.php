<?php



namespace app\admin\controller\wanlshop;



use app\common\controller\Backend;

use think\Db;



/**

 * 提現管理

 *

 * @icon fa fa-circle-o

 */

class Withdraw extends Backend

{

    

    /**

     * Withdraw模型對象

     * @var \app\admin\model\wanlshop\Withdraw

     */

    protected $model = null;



    public function _initialize()

    {

        parent::_initialize();

        $this->model = new \app\admin\model\wanlshop\Withdraw;

        $this->view->assign("statusList", $this->model->getStatusList());

    }



    /**

     * 詳情

     */

    public function detail($ids = null)

    {

    	$row = $this->model->get($ids);

    	if (!$row) {

    	    $this->error(__('No Results were found'));

    	}

    	$this->view->assign("row", $row);

    	return $this->view->fetch();

    }

    

    /**

     * 同意

     */

    public function agree($ids = null)

    {

    	$row = $this->model->get($ids);

    	if (!$row) {

    	    $this->error(__('No Results were found'));

    	}

    	$adminIds = $this->getDataLimitAdminIds();

    	if (is_array($adminIds)) {

    	    if (!in_array($row[$this->dataLimitField], $adminIds)) {

    	        $this->error(__('You have no permission'));

    	    }

    	}

    	if ($row['status'] == 'successed') {

    	    $this->error(__('已審核過本店鋪，請不要重復審核！'));

    	}

    	if ($this->request->isPost()) {

    		$result = false;

    		Db::startTrans();

    		try {

    		    //是否采用模型驗證

    		    if ($this->modelValidate) {

    		        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));

    		        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;

    		        $row->validateFailException(true)->validate($validate);

    		    }

    			// 審核通過

    		    $result = $row->allowField(true)->save([

					'status' => 'successed',

					'transfertime' => time()

				]);

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

    	$this->view->assign("row", $row);

    	return $this->view->fetch();

    }

    

    /**

     * 拒絕

     */

    public function refuse($ids = null)

    {

    	$row = $this->model->get($ids);

    	if (!$row) {

    	    $this->error(__('No Results were found'));

    	}

    	$adminIds = $this->getDataLimitAdminIds();

    	if (is_array($adminIds)) {

    	    if (!in_array($row[$this->dataLimitField], $adminIds)) {

    	        $this->error(__('You have no permission'));

    	    }

    	}

    	if ($this->request->isPost()) {

    	    $params = $this->request->post("row/a");

    	    if ($params) {

    	        $params = $this->preExcludeFields($params);

    	        $result = false;

    	        Db::startTrans();

    	        try {

    	            //是否采用模型驗證

    	            if ($this->modelValidate) {

    	                $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));

    	                $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;

    	                $row->validateFailException(true)->validate($validate);

    	            }

    				$params['status'] = 'rejected';

    	            $result = $row->allowField(true)->save($params);

					// 更新用戶金額

					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+($row['money']+$row['handingfee']), $row['user_id'], '提現失敗返回余額', 'withdraw', $row['id']);

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

