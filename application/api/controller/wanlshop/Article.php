<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop文章接口
 */
class Article extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
	
    /**
     * 獲取指定文章列表
     *
     * @ApiSummary  (WanlShop 獲取文章列表)
     * @ApiMethod   (POST)
	 * 
	 * @param string $type 文章類型
	 * @param string $list_rows 每頁數量
	 */
    public function getList()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$type = $this->request->post('type');
			$where['status'] = 'normal';
			$config = get_addon_config('wanlshop');
			if($type == 'help'){
				$where['category_id'] = $config['config']['help_category'];
			}
			if($type == 'new'){
				$where['category_id'] = $config['config']['new_category'];
			}
			if($type == 'sys'){
				$where['category_id'] = $config['config']['sys_category'];
			}
			$data = model('app\api\model\wanlshop\Article')
				->where($where)
				->field('id,title,description,image,images,flag,views,createtime')
				->order('createtime desc')
				->paginate();
			
			$this->success('成功を返す', $data);
		}
		$this->error(__('違法なリクエスト'));
        
    }
    
	
    /**
     * 獲取內容詳情
     *
     * @ApiSummary  (WanlShop 獲取內容詳情)
     * @ApiMethod   (POST)
     * 
	 * @param string $id 文章ID
     */
    public function details()
    {
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$id = $this->request->get('id');
		$id ? $id : ($this->error(__('Invalid parameters')));
		$row = model('app\api\model\wanlshop\Article')
			->where(['id' => $id])
			->find();

		// 1.0.5升級

		if(!$row){

			$this->error(__('何も見つかりません'));

		}
		// 點擊 +1
		$row->setInc('views');
		$this->success('成功を返す', $row);
    }
    
	
	/**
	 * 獲取廣告詳情
	 *
	 * @ApiSummary  (WanlShop 獲取內容詳情)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 文章ID
	 */
	public function adDetails($id = null)
	{
		$row = model('app\api\model\wanlshop\Advert')->get($id);

		// 1.0.5升級

		if(!$row){

			$this->error(__('何も見つかりません'));

		}
		// 點擊 +1
		$row->setInc('views');
		$this->success('成功を返す', $row);
	}
	
}
