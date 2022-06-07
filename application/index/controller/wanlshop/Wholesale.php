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
class Wholesale extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    protected $searchFields = 'title';
    
    /**
     * Wholesale模型對象
     * @var \app\index\model\wanlshop\Wholesale
     */
    protected $model = null;
    
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\Wholesale;
        $this->shopid = -1;
        
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
        //if ($this->request->isAjax()) {
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
                
            if($offset>$total){
                $offset = $total-10;
            }
    
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
            if($limit==0)$limit=10;
            $page       = ceil($offset/$limit)+1;
            $page_total = ceil($total/$limit);
            
            
            
            if($offset>0){
               $preoffset = ($page-2)*$limit;
               if($preoffset<0){
                   $preoffset = 0;
               }
            }else{
               $preoffset = 0;
            }
            if($offset>=($page_total-1)*$limit){
               $nexoffset = ($page_total-1)*$limit;
            }else{
               $nexoffset = ($page)*$limit;
            }
            
            if($page < 3){
                $j_start = 1;
                $j_end = $page_total > 4 ? 5 : $page_total;
            }else{
                $j_start = $page - 2;
                $j_end = $page_total-$page >= 2 ? $page+2 : $page_total;
            }
            
            // 類目
            $tree = Tree::instance();
    		// 1.0.2升級 過濾隱藏
            $tree->init(model('app\index\model\wanlshop\Category')->where(['type' => 'goods', 'isnav' => 1])->field('id,pid,name')->order('weigh asc,id asc')->select());
            $Category = $tree->getTreeArray(0);
            $Category = json_decode(json_encode($Category),true);
            
            
            
            
            foreach($Category as $k1=>$v1){
                $Category[$k1]['allid'] = $v1['id'];
                foreach($v1['childlist'] as $k2=>$v2){
                    $Category[$k1]['allid'] = $Category[$k1]['allid'].','.$v2['id'];
                    $Category[$k1]['childlist'][$k2]['allid'] = $v2['id'];
                    foreach($v2['childlist'] as $k3=>$v3){
                        $Category[$k1]['allid'] = $Category[$k1]['allid'].','.$v3['id'];
                        $Category[$k1]['childlist'][$k2]['allid'] = $Category[$k1]['childlist'][$k2]['allid'].','.$v3['id'];
                        $Category[$k1]['childlist'][$k2]['childlist'][$k3]['allid'] = $v3['id'];
                    }
                }
            }
            $this->view->assign('category', $Category);
            //var_dump($Category);exit;
            
            $filter = isset($_GET['filter'])?$_GET['filter']:'';
            $one   = '';$two   = '';$three = '';$Category1 = [];$Category2 = [];$categoryname = '';
            if(!empty($filter)){
                $filterarr = json_decode($filter,true);
                $categoryname = isset($filterarr['category.id'])?$filterarr['category.id']:'';
                //var_dump($categoryname);exit;
                if(!empty($categoryname)){
                    foreach($Category as $k1=>$v1){
                        if($v1['id'] == $categoryname){
                            $one   = $v1['id'];
                            $two   = '';
                            $three = '';
                            $Category1 = isset($v1['childlist'])?$v1['childlist']:'';
                            $Category2 = [];
                            break;
                        }else{
                            foreach($v1['childlist'] as $k2=>$v2){
                                if($v2['id'] == $categoryname){
                                    $one   = $v1['id'];
                                    $two   = $v2['id'];
                                    $three = '';
                                    $Category1 = $v1['childlist'];
                                    $Category2 = isset($v2['childlist'])?$v2['childlist']:'';
                                    break;
                                }else{
                                    foreach($v2['childlist'] as $k3=>$v3){
                                        if($v3['id'] == $categoryname){
                                            $one   = $v1['id'];
                                            $two   = $v2['id'];
                                            $three = $v3['id'];
                                            $Category1 = $v1['childlist'];
                                            $Category2 = $v2['childlist'];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->view->assign("one", $one);
            $this->view->assign("two", $two);
            $this->view->assign("three", $three);
            $this->view->assign("category1", $Category1);
            $this->view->assign("category2", $Category2);
            
            
            $this->view->assign("categoryname", $categoryname);
            
            $status = $this->request->get("status", 0);
            
            $this->view->assign("status", $status);
            
            $this->view->assign("page", $page);
            $this->view->assign("page_total", $page_total);
            $this->view->assign("preoffset", $preoffset);
            $this->view->assign("nexoffset", $nexoffset);
            $this->view->assign("j_start", $j_start);
            $this->view->assign("j_end", $j_end);
            $this->view->assign("limit", $limit);
            $this->view->assign("filter", $filter);
            
            $this->view->assign("result", $result);
            //return json($result);
        //}
        return $this->view->fetch();
    }
    
    public function goindex()
    {
        $offset = $this->request->post("offset");
        if($offset<1){$offset=1;}
        $order  = $this->request->get("order");
        $op     = $this->request->get("op");
        $filter = $this->request->get("filter");
        $url = '/index/wanlshop.wholesale/index.html?order='.$order.'&offset='.(($offset-1)*10).'&limit=10&op='.$op.'&filter='.$filter;
        $url = htmlspecialchars_decode($url);
        Header("Location:$url");exit;
    }
    
    /**
     * 查看
     */
    public function index1()
    {
        // 類目
            $tree = Tree::instance();
    
    		// 1.0.2升級 過濾隱藏
            $tree->init(model('app\index\model\wanlshop\Category')->where(['type' => 'goods', 'isnav' => 1])->field('id,pid,name')->order('weigh asc,id asc')->select());
            $arrddd = $tree->getTreeArray(0);
            $this->view->assign('channelList', $tree->getTreeArray(0));
            var_dump(json_decode(json_encode($arrddd),true));exit;
        //當前是否為關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags']);
        //if ($this->request->isAjax()) {
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
            var_dump($result);exit;
            $this->view->assign("result", $result);
            //return json($result);
        //}
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

				empty($params['spuItem'])?$this->error(__('記入してください：販売情報-製品属性')):'';

	            $result = false;

	            Db::startTrans();

	            try {

	                $spudata = isset($params['spu'])?$params['spu']:$this->error(__('販売情報を入力してください-製品属性'));

	                $spuItem = isset($params['spuItem'])?$params['spuItem']:$this->error(__('販売情報-製品属性-製品仕様を入力してください'));

	                // 獲取自增ID

	                $this->model->shop_id = $this->shopid;

	                $this->model->brand_id = $params['brand_id'];

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

					if(!model('app\index\model\wanlshop\WholeSpu')->allowField(true)->saveAll($spu)){

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

					if(!model('app\index\model\wanlshop\WholeSku')->allowField(true)->saveAll($sku)){

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

	    $shop_id = $this->shopid;

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
     * 導入
     */
    public function import($ids = null)
    {
        $this->request->filter(['']);
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($row['shop_id'] != $this->shopid) {
            $this->error(__('You have no permission'));
        }
        
        $skuItem = model('app\index\model\wanlshop\WholeSku')
		->where(['goods_id' => $ids, 'state' => 0])
		->field('id,difference,price,market_price,wholesale_price,stock,weigh,sn,sales,state')
		->select();
		
		$spudata = model('app\index\model\wanlshop\WholeSpu')->all(['goods_id' => $ids]);
        
        $this->model = new \app\index\model\wanlshop\Goods;
        
        $night = strtotime(date('Y-m-d', time()));
        $day   = strtotime(date('Y-m-d', time()))+86400;//86400为一天的秒数
        
        $wholesalecount = $this->model
                ->where('shop_id='.$this->shop->id.' and wholesale_id!=0 and createtime<'.$day.' and createtime>'.$night)
                ->count();
        /*if ($wholesalecount>20) { 
            $this->error('毎日最大20個のアイテムを棚に置くことができます');
        }*/
        
        $wholesale = $this->model
                ->where('shop_id='.$this->shop->id.' and wholesale_id='.$row['id'])
                ->select();
        
        if (!empty($wholesale)) {
            $this->error('あなたはすでにリストしています');
        }
        $result = false;
        Db::startTrans();
        try {
            //$spudata = isset($params['spu'])?$params['spu']:$this->error(__('請填寫銷售信息-產品屬性'));
            //$spuItem = isset($params['spuItem'])?$params['spuItem']:$this->error(__('請填寫銷售信息-產品屬性-產品規格'));
            // 獲取自增ID
            $DD  = 1.2+mt_rand(0,400)/1000;
            
            $DD2 = 0.88+mt_rand(0,20)/1000;
            
            $this->model->shop_id = $this->shop->id;
            $this->model->wholesale_id = $row['id'];
            //$this->model->brand_id = $row['brand_id'];
            
            $this->model->brand = $row['brand'];
            
            $this->model->category_id = $row['category_id'];
			if(isset($row['attribute'])){
				$this->model->category_attribute = json_encode($row['attribute'], JSON_UNESCAPED_UNICODE);
			}
            $this->model->title = $row['title'];
            $this->model->image = $row['image'];
            $this->model->images = $row['images'];
            $this->model->description = $row['description'];
            $this->model->stock = $row['stock'];
            $this->model->status = $row['status'];
            $this->model->content = $row['content'];
            $this->model->shop_category_id = $row['shop_category_id'];
            
            $wholesale_price = 0;
            foreach ($skuItem as $vo) {
                $wholesale_price = ($wholesale_price<$vo['wholesale_price'])?$vo['wholesale_price']:$wholesale_price;
    		}
            
            //$this->model->price = sprintf("%.2f",$wholesale_price*$DD);
            $this->model->price = sprintf("%.2f",$wholesale_price/$DD2);
            $this->model->wholesaleprice = sprintf("%.2f",$wholesale_price);
            $this->model->maxprice = sprintf("%.2f",$wholesale_price/0.88);
            //empty($row['wholesale_price'])?sprintf("%.2f",$wholesale_price*1.2):sprintf("%.2f",$row['wholesale_price']*1.2);
            //var_dump($this->model->price);exit;  sprintf("%.2f",$num);
            $this->model->freight_id = $row['freight_id'];
            if($this->model->save()){
            	$result = true;
            }
			// 寫入SPU
			$spu = [];
			
			foreach ($spudata as $vo) {
			    $spu[] = [
			        'goods_id'	=> $this->model->id,
			        'name'		=> $vo['name'],
			        'item'		=> $vo['item']
			    ];
			}
			
			if(!model('app\index\model\wanlshop\GoodsSpu')->allowField(true)->saveAll($spu)){
				$result == false;
			}
            $suk = [];
            
            //var_dump($DD);exit;
    		foreach ($skuItem as $vo) {
    		    $suk[] = [
			        'goods_id' 		=> $this->model->id,
			        'difference' 	=> $vo['difference'],
			        'market_price' 	=> sprintf("%.2f",(($vo['wholesale_price'])/$DD2)*$DD),//$vo['market_price'],
			        'price' 		=> sprintf("%.2f",($vo['wholesale_price'])/$DD2),//$vo['price'],
			        'wholesale_price' 	=> $vo['wholesale_price'],
			        'stock' 		=> $vo['stock'],
			        'weigh' 		=> $vo['weigh'],
			        'sn' 			=> $vo['sn'],
			    ];
    		}
    		if(!model('app\index\model\wanlshop\GoodsSku')->allowField(true)->saveAll($suk)){
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
            $this->success('正常にリストされました');
        } else {
            $this->error(__('No rows were inserted'));
        }
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
        if ($row['shop_id'] != $this->shopid) {
            $this->error(__('You have no permission'));
        }

		// 查詢SKU

		$skuItem = model('app\index\model\wanlshop\WholeSku')

			->where(['goods_id' => $ids, 'state' => 0])

			->field('id,difference,price,market_price,wholesale_price,stock,weigh,sn,sales,state')

			->select();

        if ($this->request->isPost()) {

            $params = $this->request->post("row/a");
            if ($params) {

				// 判斷產品屬性是否存在

				empty($params['spuItem'])?$this->error(__('記入してください：販売情報-製品属性')):'';
                $result = false;
                Db::startTrans();
                try {

					$spudata = isset($params['spu'])?$params['spu']:$this->error(__('販売情報を入力してください-製品属性'));

					$spuItem = isset($params['spuItem'])?$params['spuItem']:$this->error(__('販売情報-製品属性-製品仕様を入力してください'));

					// 寫入表單

					$data = $params;

					if(isset($data['attribute'])){

						$data['category_attribute'] = json_encode($data['attribute'], JSON_UNESCAPED_UNICODE);

					}

					$data['price'] = min($data['price']);
                    $result = $row->allowField(true)->save($data);

					// 刪除原來數據,重新寫入SPU

					model('app\index\model\wanlshop\WholeSpu')

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

					if(!model('app\index\model\wanlshop\WholeSpu')->allowField(true)->saveAll($spu)){

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

					if(!model('app\index\model\wanlshop\WholeSku')->allowField(true)->saveAll($oldsku)){

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

					if(!model('app\index\model\wanlshop\WholeSku')->allowField(true)->saveAll($sku)){

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

		$spuData = model('app\index\model\wanlshop\WholeSpu')->all(['goods_id' => $ids]);

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
        
        $row['images'] = explode(",", $row['images']);
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
            $this->model->where('shop_id', '=', $this->shopid);
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

        $this->model->where('shop_id', '=', $this->shopid);

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
        $this->model->where('shop_id', '=', $this->shopid);
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
                    $this->model->where('shop_id', '=', $this->shopid);
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
