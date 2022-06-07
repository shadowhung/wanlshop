<?php
// 2020年2月17日21:41:27
namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Db;
use Exception;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 商品评论
 *
 * @icon fa fa-circle-o
 */
class Commentfront extends Backend
{
    
    /**
     * GoodsComment模型对象
     */
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\GoodsComment;
        $this->shopid = -1;
        
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 查看
     */
    public function index()
    {
        //var_dump('dd');exit;
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['user','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->getRelation('user')->visible(['username','nickname']);
                $row->getRelation('goods')->visible(['title']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
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

		if ($row['shop_id'] !=$this->shopid) {

		    $this->error(__('You have no permission'));

		}

    	$this->view->assign("row", $row);

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

	

	

	
}
