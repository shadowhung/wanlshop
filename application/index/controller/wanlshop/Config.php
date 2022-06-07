<?php
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use think\Exception;

/**
 * 系統配置
 *
 * @icon   fa fa-cogs
 * @remark 可以在此增改系統的變量和分組,也可以自定義分組和變量,如果需要刪除請從數據庫中刪除
 */
class Config extends Wanlshop
{
	

    /**
     * @var \app\common\model\Config
     */
	protected $noNeedLogin = '';

	protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('app\index\model\wanlshop\ShopConfig');

		$this->view->assign("typeList", $this->model->getTypeList());
    }

    /**
     * 查看
     */
    public function index($type = '')
    {
        $row = $this->model->get(['shop_id' => $this->shop->id]);

		if(!$row){

			$this->model->shop_id = $this->shop->id;

			$this->model->save();

		}

		if ($this->request->isPost()) {

		    $params = $this->request->post("row/a");

			$result = false;

			$result = $row->save($params,['id' => 1]);

			if ($result !== false) {

			    $this->success();

			} else {

			    $this->error(__('No rows were inserted'));

			}

		}

		$this->view->assign('type', $type);

        $this->view->assign('row', $row);
        return $this->view->fetch();
    }

   
   

}
