<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use fast\Tree; 
use think\Db; // 1.0.3升级
/**
 * 链接管理
 *
 * @icon fa fa-circle-o
 */
class Link extends Backend
{
    
    /**
     * Link模型对象
     * @var \app\admin\model\wanlshop\Link
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Link;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
	/**
	 * 查看
	 */
	public function index()
	{
	    //设置过滤方法
	    $this->request->filter(['strip_tags']);
	    if ($this->request->isAjax()) {
			$filter = json_decode($this->request->request('filter'), true);
			$filter = $filter ? $filter['type'] : false;
	        //如果发送的来源是Selectpage，则转发到Selectpage
	        if ($this->request->request('keyField')) {
	            return $this->selectpage();
	        }
	        list($where, $sort, $order, $offset, $limit) = $this->buildparams();
	        $list = $this->model
	            ->where($where)
	            ->order($sort, $order)
	            ->limit($offset, $limit)
	            ->select();
	        $list = collection($list)->toArray();
			// 追加全局子页面
			if(!$filter || $filter == 'page'){
				$page = model('app\admin\model\wanlshop\Page')
					->where(['shop_id' => 0, 'type' => 'page'])
					->limit($offset, $limit)
					->select();
				$pageData = [];
				foreach($page as $vo){
					$pageData[] = [
						'id' => '70000'.$vo['id'],
						'type' => 'page',
						'title' => $vo['name'],
						'route' => '/pages/page/index?id='.$vo['page_token'],
						'createtime' => $vo['createtime'],
						'updatetime' => $vo['updatetime'],
						'status' => 'normal',
						'type_text' => '自定义页面',
						'status_text' => '正常',
						'weigh' => 1
					];
				}
				$list = array_merge($list,$pageData);
			}
			// 追加全局商品
			if(!$filter || $filter == 'product'){
				$product = model('app\admin\model\wanlshop\Goods')
					->limit($offset, $limit)
					->select();
				$productData = [];
				foreach($product as $vo){
					$productData[] = [
						'id' => '80000'.$vo['id'],
						'type' => 'product',
						'title' => $vo['title'],
						'image' => $vo['image'],
						'route' => '/pages/product/goods?id='.$vo['id'],
						'createtime' => $vo['createtime'],
						'updatetime' => $vo['updatetime'],
						'status' => 'normal',
						'type_text' => '商品',
						'status_text' => '正常',
						'weigh' => 1
					];
				}
				$list = array_merge($list,$productData);
			}
			// 输出
	        $result = array("total" => count($list), "rows" => $list);
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

	/**
	 * 编辑
	 */
	public function edit($ids = null)
	{
	    $row = $this->model->get($ids);
	    if (!$row) {
	        $this->error(__('该数据为自动生成，不可修改'));
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
	                //是否采用模型验证
	                if ($this->modelValidate) {
	                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
	                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
	                    $row->validateFailException(true)->validate($validate);
	                }
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

