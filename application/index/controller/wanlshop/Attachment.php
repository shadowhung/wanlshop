<?php
// 2020年2月17日21:41:44
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;

/**
 * 附件管理
 *
 * @icon fa fa-circle-o
 * @remark 主要用於管理上傳到又拍雲的數據或上傳至本服務的上傳數據
 */
class Attachment extends Wanlshop
{

    /**
     * @var \app\common\model\Attachment
     */
    protected $model = null;
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    public function _initialize()

    {

        parent::_initialize();

        $this->model = model('Attachment');

        $this->view->assign("mimetypeList", \app\common\model\Attachment::getMimetypeList());

    }

    

    /**

     * 查看

     */

    public function index()

    {

        //設置過濾方法

        $this->request->filter(['strip_tags']);

        if ($this->request->isAjax()) {

            $mimetypeQuery = [];

            $filter = $this->request->request('filter');

            $filterArr = (array)json_decode($filter, true);

            if (isset($filterArr['mimetype']) && preg_match("/[]\,|\*]/", $filterArr['mimetype'])) {

                $this->request->get(['filter' => json_encode(array_diff_key($filterArr, ['mimetype' => '']))]);

                $mimetypeQuery = function ($query) use ($filterArr) {

                    $mimetypeArr = explode(',', $filterArr['mimetype']);

                    foreach ($mimetypeArr as $index => $item) {

                        if (stripos($item, "/*") !== false) {

                            $query->whereOr('mimetype', 'like', str_replace("/*", "/", $item) . '%');

                        } else {

                            $query->whereOr('mimetype', 'like', '%' . $item . '%');

                        }

                    }

                };

            }

    

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model

                ->where($mimetypeQuery)

                ->where($where)

                ->order($sort, $order)

                ->count();

    

            $list = $this->model

                ->where($mimetypeQuery)

                ->where($where)

                ->order($sort, $order)

                ->limit($offset, $limit)

                ->select();

            $cdnurl = preg_replace("/\/(\w+)\.php$/i", '', $this->request->root());

            foreach ($list as $k => &$v) {

                $v['fullurl'] = ($v['storage'] == 'local' ? $cdnurl : $this->view->config['upload']['cdnurl']) . $v['url'];

            }

            unset($v);

            $result = array("total" => $total, "rows" => $list);

    

            return json($result);

        }

        return $this->view->fetch();

    }

    

    /**

     * 選擇附件

     */

    public function select()

    {

        if ($this->request->isAjax()) {

            return $this->index();

        }

        return $this->view->fetch();

    }

    

    /**

     * 刪除附件

     * @param array $ids

     */

    public function del($ids = "")

    {

        if ($ids) {

            \think\Hook::add('upload_delete', function ($params) {

                $attachmentFile = ROOT_PATH . '/public' . $params['url'];

                if (is_file($attachmentFile)) {

                    @unlink($attachmentFile);

                }

            });

            $attachmentlist = $this->model->where('id', 'in', $ids)->select();

            foreach ($attachmentlist as $attachment) {

                \think\Hook::listen("upload_delete", $attachment);

                $attachment->delete();

            }

            $this->success();

        }

        $this->error(__('Parameter %s can not be empty', 'ids'));

    }
}
