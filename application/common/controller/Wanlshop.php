<?php
namespace app\common\controller;
use app\common\library\Auth;



use think\Config;
use think\Controller;
use think\Hook;
use think\Lang;
use think\Loader;
use think\Validate;
use fast\Tree; //1.0.2升级




/**
 * 前台控制器基类
 */
class Wanlshop extends Controller
{

    /**
     * 布局模板
     * @var string
     */
    protected $layout = 'wanlshop';

    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = [];

    /**
     * 权限Auth
     * @var Auth
     */
    protected $auth = null;

	

	/**------------------------------------------------------------

	 * 快速搜索时执行查找的字段

	 */

	protected $searchFields = 'id';

	

	/**

	 * 是否是关联查询

	 */

	protected $relationSearch = false;

	

	/**

	 * 数据限制字段

	 */

	protected $dataLimitField = 'shop_id';

	

	/**

	 * Selectpage可显示的字段

	 */

	protected $selectpageFields = '*';

	//---------------------------------------------------------------


    public function _initialize()
    {
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        $modulename = $this->request->module();
        $controllername = Loader::parseName($this->request->controller());
        $actionname = strtolower($this->request->action());

        // 如果有使用模板布局
        if ($this->layout) {
            $this->view->engine->layout('layout/' . $this->layout);
        }
        $this->auth = Auth::instance();

		

        // token
        $token = $this->request->server('HTTP_TOKEN', $this->request->request('token', \think\Cookie::get('token')));
		// 页面
        $path = str_replace('.', '/', $controllername) . '/' . $actionname;

		

		// 定义是否Dialog请求

		!defined('IS_DIALOG') && define('IS_DIALOG', input("dialog") ? true : false);

		

		
        // 设置当前请求的URI
        $this->auth->setRequestUri($path);
        // 检测是否需要验证登录
        if (!$this->auth->match($this->noNeedLogin)) {
            //初始化
            $this->auth->init($token);
            //检测是否登录
            if (!$this->auth->isLogin()) {
                $this->error(__('Please login first'), 'index/user/login');
            }
            // 判断是否需要验证权限
            if (!$this->auth->match($this->noNeedRight)) {
                // 判断控制器和方法判断是否有对应权限
                if (!$this->auth->check($path)) {
                    $this->error(__('You have no permission'));
                }
            }

			$this->shopauth = \app\index\model\wanlshop\Auth::get(['user_id' => $this->auth->id]);

			if($this->shopauth){

				switch ($this->shopauth->verify) {

				    case 0:

						$this->error(__('審核信息尚未完善'),'index/wanlshop/entry');

				    case 1:

						$this->error(__('店鋪尚未提交審核'),'index/wanlshop/entry');

					case 2:

						$this->error(__('店鋪正在審核中'),'index/wanlshop/entry');

					case 4:

						$this->error(__('開通店鋪未通過'),'index/wanlshop/entry');

				}

			}else{

				$this->error(__('尚未開通店鋪'),'index/wanlshop/entry');

			}

        } else {
            // 如果有传递token才验证是否登录状态
            if ($token) {
                $this->auth->init($token);
            }
        }
		$this->shop = \app\index\model\wanlshop\Shop::get(['user_id' => $this->auth->id]);

		if($this->shop->status=='hidden'){

			$this->error(__('店鋪異常，請聯系客服'));

		}

		

		// 用户

		$this->view->assign('user', $this->auth->getUser());

		$this->view->assign('auth', $this->auth);

		// 店铺

		

		

		$this->view->assign('shop', $this->shop);
        // 语言检测
        $lang = strip_tags($this->request->langset());
        $site = Config::get("site");
        $upload = \app\common\model\Config::upload();

        // 上传信息配置后
        Hook::listen("upload_config_init", $upload);
		// 获取配置

		$wanlshop = get_addon_config('wanlshop');

        // 配置信息
        $config = [
            'site'           => array_intersect_key($site, array_flip(['name', 'cdnurl', 'version', 'timezone', 'languages'])),

			'socketurl'      => $wanlshop['ini']['socketurl'],

			'document'		 => $wanlshop['config']['shop_document'], //文档

			'qun'			 => $wanlshop['config']['shop_qun'], //QQ群

            'upload'         => $upload,
            'modulename'     => $modulename,
            'controllername' => $controllername,
            'actionname'     => $actionname,
            'jsname'         => 'frontend/' . str_replace('.', '/', $controllername),
            'moduleurl'      => rtrim(url("/{$modulename}", '', false), '/'),

            'language'       => $lang
        ];
        $config = array_merge($config, Config::get("view_replace_str"));

        Config::set('upload', array_merge(Config::get('upload'), $upload));

        // 配置信息后
        Hook::listen("config_init", $config);
        // 加载当前控制器语言包
        $this->loadlang($controllername);

		

        $this->assign('site', $site);
        $this->assign('config', $config);
    }

    /**
     * 加载语言文件
     * @param string $name
     */
    protected function loadlang($name)
    {
        Lang::load(APP_PATH . $this->request->module() . '/lang/' . $this->request->langset() . '/' . str_replace('.', '/', $name) . '.php');
    }

    /**
     * 渲染配置信息
     * @param mixed $name  键名或数组
     * @param mixed $value 值
     */
    protected function assignconfig($name, $value = '')
    {
        $this->view->config = array_merge($this->view->config ? $this->view->config : [], is_array($name) ? $name : [$name => $value]);
    }

    /**
     * 刷新Token
     */
    protected function token()
    {
        $token = $this->request->post('__token__');

        //验证Token
        if (!Validate::is($token, "token", ['__token__' => $token])) {
            $this->error(__('Token verification error'), '', ['__token__' => $this->request->token()]);
        }

        //刷新Token
        $this->request->token();
    }

	

	/**

	 * 排除前台提交过来的字段

	 * @param $params

	 * @return array

	 */

	protected function preExcludeFields($params)

	{

	    if (is_array($this->excludeFields)) {

	        foreach ($this->excludeFields as $field) {

	            if (key_exists($field, $params)) {

	                unset($params[$field]);

	            }

	        }

	    } else {

	        if (key_exists($this->excludeFields, $params)) {

	            unset($params[$this->excludeFields]);

	        }

	    }

	    return $params;

	}

	

	/**

	 * 生成查询所需要的条件,排序方式

	 * @param mixed   $searchfields   快速查询的字段

	 * @param boolean $relationSearch 是否关联查询

	 * @return array

	 */

	protected function buildparams($searchfields = null, $relationSearch = null)

	{

	    $searchfields = is_null($searchfields) ? $this->searchFields : $searchfields;

	    $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;

	    $search = $this->request->get("search", '');

	    $filter = $this->request->get("filter", '');

	    $op = $this->request->get("op", '', 'trim');

	    $sort = $this->request->get("sort", !empty($this->model) && $this->model->getPk() ? $this->model->getPk() : 'id');

	    $order = $this->request->get("order", "DESC");

	    $offset = $this->request->get("offset", 0);

	    $limit = $this->request->get("limit", 0);

	    $filter = (array)json_decode($filter, true);

	    $op = (array)json_decode($op, true);

	    $filter = $filter ? $filter : [];

	    $where = [];

	    $tableName = '';

	    if ($relationSearch) {

	        if (!empty($this->model)) {

	            $name = \think\Loader::parseName(basename(str_replace('\\', '/', get_class($this->model))));

	            $name = $this->model->getTable();

	            $tableName = $name . '.';

	        }

	        $sortArr = explode(',', $sort);

	        foreach ($sortArr as $index => & $item) {

	            $item = stripos($item, ".") === false ? $tableName . trim($item) : $item;

	        }

	        unset($item);

	        $sort = implode(',', $sortArr);

	    }

		// 过滤排除

		switch (Loader::parseName($this->request->controller()))

		{

			case 'wanlshop.attachment':

				$where[] = [$tableName . 'user_id', 'in', $this->auth->id];

				break;  
			case 'wanlshop.wholesale':
			     $status = $this->request->get("status", 0);
			    if($status=='1'||$status=='2'){
			        $wholesalearr = model('app\index\model\wanlshop\Goods')->where(['shop_id' => $this->shop->id])
        			->field('wholesale_id')
        			->select();
        			$res = '';
    			    foreach($wholesalearr as $k=>$v){
    			        if($k==0){
    			            $res = $v['wholesale_id'];
    			        }else{
    			            $res = $res.','.$v['wholesale_id'];
    			        }
    			    }
			    }
			    if($status==1){
    			    $where[] = [$tableName . 'id', 'in', $res];
			    }else if($status==2){
			        $where[] = [$tableName . 'id', 'not in', $res];
			    }
				break;

			case 'wanlshop.icon':

				

				break;

			default:

				$where[] = [$tableName . $this->dataLimitField, 'in', $this->shop->id];

		}

		

	    if ($search) {

	        $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);

	        foreach ($searcharr as $k => &$v) {

	            $v = stripos($v, ".") === false ? $tableName . $v : $v;

	        }

	        unset($v);

			$arrSearch = [];

			foreach (explode(" ", $search) as $ko) {

				$arrSearch[] = '%'.$ko.'%';

			}

	        $where[] = [implode("|", $searcharr), "LIKE", $arrSearch];

	    }

		

	    foreach ($filter as $k => $v) {

	        $sym = isset($op[$k]) ? $op[$k] : '=';

	        if (stripos($k, ".") === false) {

	            $k = $tableName . $k;

	        }

	        $v = !is_array($v) ? trim($v) : $v;
	        

            if($k=='fa_wanlshop_order.state'&&$v==8){
                $where[] = ['fa_wanlshop_order.wholesale_id', '<>', '0'];
            }else{
                
	        $sym = strtoupper(isset($op[$k]) ? $op[$k] : $sym);

	        switch ($sym) {

	            case '=':

	            case '<>':

	                $where[] = [$k, $sym, (string)$v];

	                break;

	            case 'LIKE':

	            case 'NOT LIKE':

	            case 'LIKE %...%':

	            case 'NOT LIKE %...%':

	                $where[] = [$k, trim(str_replace('%...%', '', $sym)), "%{$v}%"];

	                break;

	            case '>':

	            case '>=':

	            case '<':

	            case '<=':

	                $where[] = [$k, $sym, intval($v)];

	                break;

	            case 'FINDIN':

	            case 'FINDINSET':

	            case 'FIND_IN_SET':

	                $where[] = "FIND_IN_SET('{$v}', " . ($relationSearch ? $k : '`' . str_replace('.', '`.`', $k) . '`') . ")";

	                break;

	            case 'IN':

	            case 'IN(...)':

	            case 'NOT IN':

	            case 'NOT IN(...)':

	                $where[] = [$k, str_replace('(...)', '', $sym), is_array($v) ? $v : explode(',', $v)];

	                break;

	            case 'BETWEEN':

	            case 'NOT BETWEEN':

	                $arr = array_slice(explode(',', $v), 0, 2);

	                if (stripos($v, ',') === false || !array_filter($arr)) {

	                    continue 2;

	                }

	                //当出现一边为空时改变操作符

	                if ($arr[0] === '') {

	                    $sym = $sym == 'BETWEEN' ? '<=' : '>';

	                    $arr = $arr[1];

	                } elseif ($arr[1] === '') {

	                    $sym = $sym == 'BETWEEN' ? '>=' : '<';

	                    $arr = $arr[0];

	                }

	                $where[] = [$k, $sym, $arr];

	                break;

	            case 'RANGE':

	            case 'NOT RANGE':

	                $v = str_replace(' - ', ',', $v);

	                $arr = array_slice(explode(',', $v), 0, 2);

	                if (stripos($v, ',') === false || !array_filter($arr)) {

	                    continue 2;

	                }

	                //当出现一边为空时改变操作符

	                if ($arr[0] === '') {

	                    $sym = $sym == 'RANGE' ? '<=' : '>';

	                    $arr = $arr[1];

	                } elseif ($arr[1] === '') {

	                    $sym = $sym == 'RANGE' ? '>=' : '<';

	                    $arr = $arr[0];

	                }

	                $where[] = [$k, str_replace('RANGE', 'BETWEEN', $sym) . ' time', $arr];

	                break;

	            case 'LIKE':

	            case 'LIKE %...%':

	                $where[] = [$k, 'LIKE', "%{$v}%"];

	                break;

	            case 'NULL':

	            case 'IS NULL':

	            case 'NOT NULL':

	            case 'IS NOT NULL':

	                $where[] = [$k, strtolower(str_replace('IS ', '', $sym))];

	                break;

	            default:

	                break;

	        }

            }
	    }

	    $where = function ($query) use ($where) {

	        foreach ($where as $k => $v) {

	            if (is_array($v)) {

	                call_user_func_array([$query, 'where'], $v);

	            } else {

	                $query->where($v);

	            }

	        }

	    };

		// dump($where);exit;

	    return [$where, $sort, $order, $offset, $limit];

	}

	

	/**

	 * Selectpage的实现方法

	 *

	 * 当前方法只是一个比较通用的搜索匹配,请按需重载此方法来编写自己的搜索逻辑,$where按自己的需求写即可

	 * 这里示例了所有的参数，所以比较复杂，实现上自己实现只需简单的几行即可

	 *

	 */

	protected function selectpage()

	{

	    //设置过滤方法

	    $this->request->filter(['strip_tags', 'htmlspecialchars']);

	

	    //搜索关键词,客户端输入以空格分开,这里接收为数组

	    $word = (array)$this->request->request("q_word/a");

	    //当前页

	    $page = $this->request->request("pageNumber");

	    //分页大小

	    $pagesize = $this->request->request("pageSize");

	    //搜索条件

	    $andor = $this->request->request("andOr", "and", "strtoupper");

	    //排序方式

	    $orderby = (array)$this->request->request("orderBy/a");

	    //显示的字段

	    $field = $this->request->request("showField");

	    //主键

	    $primarykey = $this->request->request("keyField");

	    //主键值

	    $primaryvalue = $this->request->request("keyValue");

	    //搜索字段

	    $searchfield = (array)$this->request->request("searchField/a");

	    //自定义搜索条件

	    $custom = (array)$this->request->request("custom/a");

	    //是否返回树形结构

	    $istree = $this->request->request("isTree", 0);

	    $ishtml = $this->request->request("isHtml", 0);

	    if ($istree) {

	        $word = [];

	        $pagesize = 99999;

	    }

	    $order = [];

	    foreach ($orderby as $k => $v) {

	        $order[$v[0]] = $v[1];

	    }

	    $field = $field ? $field : 'name';

	

	    //如果有primaryvalue,说明当前是初始化传值

	    if ($primaryvalue !== null) {

	        $where = [$primarykey => ['in', $primaryvalue]];

	    } else {

	        $where = function ($query) use ($word, $andor, $field, $searchfield, $custom) {

	            $logic = $andor == 'AND' ? '&' : '|';

	            $searchfield = is_array($searchfield) ? implode($logic, $searchfield) : $searchfield;

	            foreach ($word as $k => $v) {

	                $query->where(str_replace(',', $logic, $searchfield), "like", "%{$v}%");

	            }

	            if ($custom && is_array($custom)) {

	                foreach ($custom as $k => $v) {

	                    if (is_array($v) && 2 == count($v)) {

	                        $query->where($k, trim($v[0]), $v[1]);

	                    } else {

	                        $query->where($k, '=', $v);

	                    }

	                }

	            }

	        };

	    }

	    $this->model->where($this->dataLimitField, 'in', $this->shop->id);

	    $list = [];

	    $total = $this->model->where($where)->count();

	    if ($total > 0) {

	        $this->model->where($this->dataLimitField, 'in', $this->shop->id);

	        $datalist = $this->model->where($where)

	            ->order($order)

	            ->page($page, $pagesize)

	            ->field($this->selectpageFields)

	            ->select();

	        foreach ($datalist as $index => $item) {

	            unset($item['password'], $item['salt']);

	            $list[] = [

	                $primarykey => isset($item[$primarykey]) ? $item[$primarykey] : '',

	                $field      => isset($item[$field]) ? $item[$field] : '',

	                'pid'       => isset($item['pid']) ? $item['pid'] : 0

	            ];

	        }

	        if ($istree && !$primaryvalue) {

	            $tree = Tree::instance();

	            $tree->init(collection($list)->toArray(), 'pid');

	            $list = $tree->getTreeList($tree->getTreeArray(0), $field);

	            if (!$ishtml) {

	                foreach ($list as &$item) {

	                    $item = str_replace('&nbsp;', ' ', $item);

	                }

	                unset($item);

	            }

	        }

	    }

	    //这里一定要返回有list这个字段,total是可选的,如果total<=list的数量,则会隐藏分页按钮

	    return json(['list' => $list, 'total' => $total]);

	}
}
