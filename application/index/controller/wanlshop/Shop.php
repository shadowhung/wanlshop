<?php

namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use think\Db;
use Exception;
use think\exception\PDOException;
use think\exception\ValidateException;

use fast\Tree;

/**
 * 店鋪管理
 * @internal
 */
class Shop extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * Shop模型對象
     */
    protected $model = null;
    
    public function _initialize()
    {
        parent::_initialize();
        
        
        $this->model = new \app\index\model\wanlshop\Shop;
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
        
        $this->view->assign("typeList", $this->model->getTypeList());
        $tree = Tree::instance();
        $category = new \app\index\model\wanlshop\Category;// 類目
        $tree->init(collection($category->where(['type' => 'goods'])->order('weigh desc,id desc')->field('id,pid,type,name,name_spacer')->select())->toArray(), 'pid');
        $this->assignconfig('pageCategory', $tree->getTreeList($tree->getTreeArray(0), 'name_spacer'));
    }
    
    /**
     * 類目管理
     */
    public function index()
    {
        return $this->view->fetch('wanlshop/page/index');
    }

	
    /**

     * 品牌管理

     */

    public function brand()

    {

		$this->view->assign("stateList", model('app\index\model\wanlshop\Brand')->getStateList());

        return $this->view->fetch('wanlshop/brand/index');

    }
    
    /**
     * 店鋪資料
     */
    public function profile($ids = null)
    {
        $row = $this->model->get($this->shop->id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷用戶權限
        if ($row['user_id'] !=$this->auth->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $result = false;
                Db::startTrans();
                try {
                    if($row['shopname']!=$params['shopname']){
                        $params['isedit'] = 1;
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
    
    
    
     /**
     * 店鋪資料
     */
    public function invitation($ids = null)
    {
        $row = $this->model->get($this->shop->id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷用戶權限
        if ($row['user_id'] !=$this->auth->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isPost()) {
            
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    

    /**
     * 圖片空間
     */
    public function attachment()
    {
        $attachment = model('Attachment');
        $this->view->assign("picCount", $attachment->where('user_id', $this->auth->id)->count());
        $size = $attachment->where('user_id', $this->auth->id)->sum('filesize');
        $units = array('K','Kb','M','G','T');
        $i = 0;
        for (; $size>=1024 && $i<count($units); $i++) {
            $size /= 1024;
        }
        $this->view->assign("picSum", round($size, 2).$units[$i]);

		$this->view->assign("mimetypeList", \app\common\model\Attachment::getMimetypeList());
        return $this->view->fetch('wanlshop/attachment/index');
    }
    
    /**
     * 類目管理
     */
    public function category()
    {
        return $this->view->fetch('wanlshop/shopsort/index');
    }
    
    /**
     * 服務
     */
    public function service()
    {
        if ($this->request->isAjax()) {
            $where['status'] = 'normal';
            $total = model('app\index\model\wanlshop\ShopService')->where($where)->count();
            $list = model('app\index\model\wanlshop\ShopService')->where($where)->select();
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
    }

	
}
