<?php
// 2020年2月17日22:04:21
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use think\Db;
use Exception;
use think\exception\PDOException;
use think\exception\ValidateException;
use fast\Tree;

/**
 * 產品管理
 * @internal
 */
class Goods extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    protected $searchFields = 'title';
    
    /**
     * Goods模型對象
     * @var \app\index\model\wanlshop\Goods
     */
    protected $model = null;
    
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\Goods;
        // 類目
        $tree = Tree::instance();

		// 1.0.2升級 過濾隱藏
        $tree->init(model('app\index\model\wanlshop\Category')->where(['type' => 'goods', 'isnav' => 1])->field('id,pid,name')->order('weigh asc,id asc')->select());
        $this->assignconfig('channelList', $tree->getTreeArray(0));
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("stockList", $this->model->getStockList());
        $this->view->assign("specsList", $this->model->getSpecsList());
        $this->view->assign("distributionList", $this->model->getDistributionList());
        $this->view->assign("activityList", $this->model->getActivityList());
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
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果發送的來源是Selectpage，則轉發到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with(['category','shopsort'])
                ->where($where)
                ->order($sort, $order)
                ->count();
    
            $list = $this->model
                ->with(['category','shopsort'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            foreach ($list as $row) {
                $row->getRelation('category')->visible(['name']);
                $row->getRelation('shopsort')->visible(['name']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
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
    
    /**
     * 倉庫中的商品
     */
    public function stock()
    {
        return $this->view->fetch('wanlshop/goods/index');
    }
    
    /**
     * 添加
     */

	public function add()

	{

		//設置過濾方法

		$this->request->filter(['']);

	    if ($this->request->isPost()) {

	        $params = $this->request->post("row/a");

	        if ($params) {

				// 判斷產品屬性是否存在

				empty($params['spuItem'])?$this->error(__('改善してください：販売情報-製品コンテンツ')):'';

	            $result = false;

	            Db::startTrans();

	            try {

	                $spudata = isset($params['spu'])?$params['spu']:$this->error(__('販売情報を記入してください-製品の内容'));

	                $spuItem = isset($params['spuItem'])?$params['spuItem']:$this->error(__('販売情報-製品内容-製品仕様を記入してください'));

	                // 獲取自增ID

	                $this->model->shop_id = $this->shop->id;

	                //$this->model->brand_id = $params['brand_id'];
	                
	                $this->model->brand = $params['brand'];

	                $this->model->category_id = $params['category_id'];

					if(isset($params['attribute'])){

						$this->model->category_attribute = json_encode($params['attribute'], JSON_UNESCAPED_UNICODE);

					}

	                $this->model->title = $params['title'];

	                $this->model->image = $params['image'];

	                $this->model->images = $params['images'];

	                $this->model->description = $params['description'];

	                $this->model->stock = $params['stock'];

	                $this->model->status = $params['status'];

	                $this->model->content = $params['content'];

	                $this->model->shop_category_id = $params['shop_category_id'];

	                $this->model->price = min($params['price']);

	                $this->model->freight_id = $params['freight_id'];

	                if($this->model->save()){

	                	$result = true;

	                }

					// 寫入SPU

					$spu = [];

					foreach (explode(",", $spudata) as $key => $value) {

					    $spu[] = [

					        'goods_id'	=> $this->model->id,

					        'name'		=> $value,

					        'item'		=> $spuItem[$key]

					    ];

					}

					if(!model('app\index\model\wanlshop\GoodsSpu')->allowField(true)->saveAll($spu)){

						$result == false;

					}

					// 寫入SKU

					$sku = [];

					foreach ($params['sku']  as $key => $value) {

					    $sku[] = [

					        'goods_id' 		=> $this->model->id,

					        'difference' 	=> $value,

					        'market_price' 	=> $params['market_price'][$key],

					        'price' 		=> $params['price'][$key],

					        'stock' 		=> $params['stocks'][$key],

					        'weigh' 		=> $params['weigh'][$key]!=''?$params['weigh'][$key] : 0,

					        'sn' 			=> $params['sn'][$key]!=''?$params['sn'][$key] : 'wanl_'.time()

					    ];

					}

					if(!model('app\index\model\wanlshop\GoodsSku')->allowField(true)->saveAll($sku)){

						$result == false;

					}

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

	    $shop_id = $this->shop->id;
	    
	    $this->model1 = new \app\index\model\wanlshop\ShopSort;
	    $tree = Tree::instance();
        $tree->init(collection($this->model1->where('shop_id', $shop_id)->order('weigh desc,id desc')->select())->toArray(), 'pid');
        $this->channelList = $tree->getTreeList($tree->getTreeArray(0), 'name');
        
        if(empty($this->channelList)){
            $params1['shop_id']  = $shop_id;
            $params1['name']     = '個別の分類はありません';
            $params1['pid']      = 0;
            $params1['image']    = '/uploads/20210112/375bbf2c271dd04d69c2e19c0d42f446.png';
            $params1['status']   = 'normal';
            $result1 = false;
            Db::startTrans();
            try {
                $result1 = $this->model1->allowField(true)->save($params1);
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
            if ($result1 == false) {
                $this->error(__('No rows were inserted'));
            }
        }
        
        $this->model2 = new \app\index\model\wanlshop\ShopFreight;
        $freight = model('app\index\model\wanlshop\ShopFreight')->where('shop_id',$shop_id)->count();
        if(empty($freight)){
                $result2 = false;
                Db::startTrans();
                try {
					$this->model2->shop_id    = $shop_id;
					$this->model2->name       = '送料無料';
					$this->model2->delivery   = 5;
					$this->model2->isdelivery = 1;
					if($this->model2->save()){
						$result2 = true;
					}
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
                if ($result2 == false) {
                    $this->error(__('No rows were inserted'));
                }
        }

		// 判斷是否存在品牌

		$row['brand'] = model('app\index\model\wanlshop\Brand')->where(['state' => 1])->count();

		// 判斷是否有店鋪分類

		$row['shopsort'] = model('app\index\model\wanlshop\ShopSort')->where('shop_id',$shop_id)->count();

		// 判斷是否有運費模板

		$row['freight'] = model('app\index\model\wanlshop\ShopFreight')->where('shop_id',$shop_id)->count();

		// 判斷是否有寄件人信息

		$row['config'] = model('app\index\model\wanlshop\ShopConfig')->where('shop_id',$shop_id)->find();

		// 打開方式

		$this->assignconfig("isdialog", IS_DIALOG);

		$this->view->assign("row", $row);

		return $this->view->fetch();

	}

    
    /**
     * 編輯
     */
    public function edit($ids = null)
    {

		//設置過濾方法

		$this->request->filter(['']);
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($row['shop_id'] != $this->shop->id) {
            $this->error(__('You have no permission'));
        }
		// 查詢SKU

		$skuItem = model('app\index\model\wanlshop\GoodsSku')

			->where(['goods_id' => $ids, 'state' => 0])

			->field('id,difference,price,market_price,stock,weigh,sn,sales,state')

			->select();

        if ($this->request->isPost()) {
            
            if ($row['wholesale_id'] != 0) {
                $this->error('卸売商品の変更は許可されていません');
            }

            $params = $this->request->post("row/a");
            if ($params) {

				// 判斷產品屬性是否存在

				empty($params['spuItem'])?$this->error(__('改善してください：販売情報-製品コンテンツ')):'';
                $result = false;
                Db::startTrans();
                try {

					$spudata = isset($params['spu'])?$params['spu']:$this->error(__('販売情報を記入してください-製品の内容'));

					$spuItem = isset($params['spuItem'])?$params['spuItem']:$this->error(__('販売情報-製品内容-製品仕様を記入してください'));

					// 寫入表單

					$data = $params;

					if(isset($data['attribute'])){

						$data['category_attribute'] = json_encode($data['attribute'], JSON_UNESCAPED_UNICODE);

					}
					
					//var_dump($data['price']);exit;
					$maxprice      = $data['price'];

					$data['price'] = min($data['price']);
					$maxprice      = max($maxprice);
					if($row['wholesale_id']!=0&&$row['maxprice']!=0&&$maxprice>$row['maxprice']){
					    echo '{"code":0,"msg":"小売価格は卸売価格より12％高くすることはできません","data":"","url":"","wait":3}';exit;
					}
                    $result = $row->allowField(true)->save($data);

					// 刪除原來數據,重新寫入SPU

					model('app\index\model\wanlshop\GoodsSpu')

						->where('goods_id','in',$ids)

						->delete();

					$spu = [];

					foreach (explode(",", $spudata) as $key => $value) {

					    $spu[] = [

					        'goods_id' => $ids,

					        'name' => $value,

					        'item' => $spuItem[$key]

					    ];

					}

					if(!model('app\index\model\wanlshop\GoodsSpu')->allowField(true)->saveAll($spu)){

						$result == false;

					}

					//標記舊版SKU數據

					$oldsku = [];

					foreach ($skuItem as $value) {

						$oldsku[] = [

							'id' => $value['id'],

							'state' => 1

						];

					}

					if(!model('app\index\model\wanlshop\GoodsSku')->allowField(true)->saveAll($oldsku)){

						$result == false;

					}

					// 寫入SKU

					$sku = [];

					foreach ($params['sku'] as $key => $value) {

					    $sku[] = [

					        'goods_id' => $ids,

					        'difference' => $value,

					        'market_price' => $params['market_price'][$key],

					        'price' => $params['price'][$key],

					        'stock' => $params['stocks'][$key],

					        'weigh' => $params['weigh'][$key]!=''?$params['weigh'][$key] : 0,

					        'sn' => $params['sn'][$key]!=''?$params['sn'][$key] : 'wanl_'.time()

					    ];

					}

					if(!model('app\index\model\wanlshop\GoodsSku')->allowField(true)->saveAll($sku)){

						$result == false;

					}

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

		$spuData = model('app\index\model\wanlshop\GoodsSpu')->all(['goods_id' => $ids]);

		$suk = [];

		foreach ($skuItem as $vo) {

		    $suk[] = explode(",", $vo['difference']);

		}

		$spu = [];

		foreach ($spuData as $vo) {

		    $spu[] = $vo['name'];

		}

		$spuItem = [];

		foreach ($spuData as $vo) {

		    $spuItem[] = explode(",", $vo['item']);

		}

		$skulist = [];

		foreach ($skuItem as $vo) {

		    $skulist[$vo['difference']] = $vo;

		}

        $this->assignconfig('spu', $spu);
        $this->assignconfig('spuItem', $spuItem);
        $this->assignconfig('sku', $suk);
        $this->assignconfig('skuItem', $skulist);
        $this->assignconfig('categoryId', $row['category_id']);
        $this->assignconfig('attribute', json_decode($row['category_attribute']));
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    
    /**
     * 添加類目屬性
     */
    public function attribute()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->request("id");
            $list  = model('app\index\model\wanlshop\Attribute')
                ->where('category_id', $id)
                ->select();
            $this->success('検索に成功', '', $list);
        }
        $this->error(__('Parameter %s can not be empty', ''));
    }
    
    /**
     * 回收站
     */
    public function recyclebin()
    {
        //設置過濾方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->onlyTrashed()
                ->where($where)
                ->order($sort, $order)
                ->count();
    
            $list = $this->model
                ->onlyTrashed()
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
    
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
        return $this->view->fetch();
    }
    
    /**
     * 刪除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $this->model->where('shop_id', '=', $this->shop->id);
            $list = $this->model->where($pk, 'in', $ids)->select();
    
            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
    
    /**

     * 真實刪除

     */

    public function destroy($ids = "")

    {

        $pk = $this->model->getPk();

        $this->model->where('shop_id', '=', $this->shop->id);

        if ($ids) {

            $this->model->where($pk, 'in', $ids);

        }

        $count = 0;

        Db::startTrans();

        try {

            $list = $this->model->onlyTrashed()->select();

            foreach ($list as $k => $v) {

                $count += $v->delete(true);

            }

            Db::commit();

        } catch (PDOException $e) {

            Db::rollback();

            $this->error($e->getMessage());

        } catch (Exception $e) {

            Db::rollback();

            $this->error($e->getMessage());

        }

        if ($count) {

            $this->success();

        } else {

            $this->error(__('No rows were deleted'));

        }

        $this->error(__('Parameter %s can not be empty', 'ids'));

    }
    
    /**
     * 還原
     */
    public function restore($ids = "")
    {
        $pk = $this->model->getPk();
        $this->model->where('shop_id', '=', $this->shop->id);
        if ($ids) {
            $this->model->where($pk, 'in', $ids);
        }
        $count = 0;
        Db::startTrans();
        try {
            $list = $this->model->onlyTrashed()->select();
            foreach ($list as $index => $item) {
                $count += $item->restore();
            }
            Db::commit();
        } catch (PDOException $e) {
            Db::rollback();
            $this->error($e->getMessage());
        } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if ($count) {
            $this->success();
        }
        $this->error(__('No rows were updated'));
    }
    
    /**
     * 批量更新
     */
    public function multi($ids = "")
    {
        $ids = $ids ? $ids : $this->request->param("ids");
        if ($ids) {
            if ($this->request->has('params')) {
                parse_str($this->request->post("params"), $values);
                // $values = $this->auth->isSuperAdmin() ? $values : array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                if ($values) {
                    $this->model->where('shop_id', '=', $this->shop->id);
                    $count = 0;
                    Db::startTrans();
                    try {
                        $list = $this->model->where($this->model->getPk(), 'in', $ids)->select();
                        foreach ($list as $index => $item) {
                            $count += $item->allowField(true)->isUpdate(true)->save($values);
                        }
                        Db::commit();
                    } catch (PDOException $e) {
                        Db::rollback();
                        $this->error($e->getMessage());
                    } catch (Exception $e) {
                        Db::rollback();
                        $this->error($e->getMessage());
                    }
                    if ($count) {
                        $this->success();
                    } else {
                        $this->error(__('No rows were updated'));
                    }
                } else {
                    $this->error(__('You have no permission'));
                }
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
}
