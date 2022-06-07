<?php
// 2020年2月17日21:41:27
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use think\Db;
use Exception;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 商品評論
 *
 * @icon fa fa-circle-o
 */
class Comment extends Wanlshop
{
    
    /**
     * GoodsComment模型對象
     */
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\GoodsComment;
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 查看
     */
    public function index()
    {
        //當前是否為關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果發送的來源是Selectpage，則轉發到Selectpage
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

     * 評論詳情

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

		if ($row['shop_id'] !=$this->shop->id) {

		    $this->error(__('You have no permission'));

		}

    	$this->view->assign("row", $row);

        return $this->view->fetch();

    }

	

	/**

	 * 選擇鏈接

	 */

	public function select()

	{

	    if ($this->request->isAjax()) {

	        return $this->index();

	    }

	    return $this->view->fetch();

	}

	

	

	
}
