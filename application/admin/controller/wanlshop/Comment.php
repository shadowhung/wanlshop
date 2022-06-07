<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Db;
/**
 * 商品评论
 *
 * @icon fa fa-circle-o
 */
class Comment extends Backend
{
    
    /**
     * Comment模型对象
     * @var \app\admin\model\wanlshop\Comment
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Comment;
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
                    ->with(['user','shop','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','shop','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                
                $row->getRelation('user')->visible(['username','nickname']);
				$row->getRelation('shop')->visible(['shopname']);
				$row->getRelation('goods')->visible(['title']);
            }
            $list = collection($list)->toArray();
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
       
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                model('app\api\model\wanlshop\Goods')->where(['id' => $params['goods_id']])->setInc('comment');
                if($params['state'] == 0){
					model('app\api\model\wanlshop\Goods')->where(['id' => $params['goods_id']])->setInc('praise');
				}else if($params['state'] == 1){
					model('app\api\model\wanlshop\Goods')->where(['id' => $params['goods_id']])->setInc('moderate');
				}else if($params['state'] == 2){
					model('app\api\model\wanlshop\Goods')->where(['id' => $params['goods_id']])->setInc('negative');
				}
                //var_dump($params['shop_id']);
                //var_dump($params['goods_id']);
                //exit;
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

	 * 评论详情

	 */

	public function detail($ids = null, $type = 0)

	{

		if($type == 1){

			$row = $this->model->get(['order_id' => $ids]);

		}else{

			$row = $this->model->get($ids);

		}

	    if (!$row) {

	        $this->error(__('No Results were found'));

	    }

		$row['images'] = explode(',', $row['images']);

		$this->view->assign("row", $row);

	    return $this->view->fetch();

	}

	
}
