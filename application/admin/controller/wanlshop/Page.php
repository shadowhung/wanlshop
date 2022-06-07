<?php
namespace app\admin\controller\wanlshop;
use app\common\controller\Backend;
use think\Db;
use fast\Tree; 
use fast\Random;
/**
 * 自定义页面
 *
 * @icon fa fa-circle-o
 */
class Page extends Backend
{
	/**
	 * Page模型对象
	 * @var \app\admin\model\bak\Page
	 */
	protected $model = null;
	
	public function _initialize()
	{
	    parent::_initialize();
	    $this->model = new \app\admin\model\wanlshop\Page;
		$this->view->assign("typeList", $this->model->getTypeList());
		$this->view->assign("statusList", $this->model->getStatusList());
		$tree = Tree::instance();
		$category = new \app\admin\model\wanlshop\Category;// 类目
		$tree->init(collection($category->where(['type' => 'goods'])->order('weigh desc,id desc')->field('id,pid,type,name,name_spacer')->select())->toArray(), 'pid');
		$this->assignconfig('pageCategory', $tree->getTreeList($tree->getTreeArray(0), 'name_spacer'));
	}
	
	/**
	 * 编辑
	 */
	public function edit($ids = null)
	{
	    if ($this->request->isPost()) {
	        $params = $this->request->post();
	        if ($params) {
				if(!array_key_exists("item",$params)){
					$this->error('请编辑页面后再发布');
				}
				$this->model->shop_id = $params['shop_id'];
				$this->model->name = $params['name'];
				$this->model->page_token = $params['page_token'];
				$this->model->type = $params['type'];
				$this->model->page = json_encode($params['page']);
				$this->model->item = json_encode($params['item']);
				$this->model->save();
				$page_token = $this->model->page_token;
				$id = $this->model->id;
				// 把除此之外的数据全部扔进回收站
				$list = $this->model->where(['page_token' => $page_token])->select();
				foreach($list as $vo){
					if($vo->id != $id){
						$this->model->destroy($vo->id);
					}
				}
				// 查询最新历史状态
				$recover = $this->model->onlyTrashed()->where(['page_token'=> $page_token])->select();
				$this->success("发布并保存成功", "url", $recover);
	        }
	        $this->error(__('Parameter %s can not be empty', ''));
	    }
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
		$this->assignconfig('page', $row);
		$recover = $this->model->onlyTrashed()->where(['page_token' => $row['page_token']])->select();
		$this->assignconfig('pageRecover', $recover);
	    return $this->view->fetch();
	}
	
	/**
	 * 添加
	 */
	public function add()
	{
	    if ($this->request->isPost()) {
	        $params = $this->request->post("row/a");
	        if ($params) {
	            $params = $this->preExcludeFields($params);
	
	            if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
	                $params[$this->dataLimitField] = $this->auth->id;
	            }
	            $result = false;
	            Db::startTrans();
	            try {
	                //是否采用模型验证
	                if ($this->modelValidate) {
	                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
	                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
	                    $this->model->validateFailException(true)->validate($validate);
	                }
					
					if($params['type'] == 'index'){
						if($this->model->where(['type' => 'index'])->count() > 0){
							$this->error('APP首页已经存在');
						}
					}
					$params['page_token'] = Random::alnum(16);
					$params['page'] = '{"params":{"navigationBarTitleText":"\u6807\u9898","share_title":"\u5206\u4eab\u6807\u9898"},"style":{"navigationBarTextStyle":"#000000","navigationBarBackgroundColor":"#f5f5f5","navigationBarBackgroundImage":"","pageBackgroundColor":"#ffffff","pageBackgroundImage":""}}';
					$params['item'] = '[]';
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
	 * 恢复历史
	 */
	public function recover($id = null){
		if ($this->request->isPost()) {
			$row = $this->model
				->onlyTrashed()
				->where('id',$id)
				->find();
			if (!$row) {
			    $this->error(__('No Results were found'));
			}
			$this->success("拉取历史数据成功", "url", $row);
		}
	}
	
	
	/**
	 * 分类样式
	 */
	public function style(){
		$config = get_addon_config('wanlshop');
		$this->view->assign("row", $config['style']);
		$this->assignconfig('category_style', $config['style']['category_style']);
		return $this->view->fetch();
	}
}