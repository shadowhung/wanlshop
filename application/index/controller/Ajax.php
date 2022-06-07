<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Lang;

/**
 * Ajax異步請求接口
 * @internal
 */
class Ajax extends Frontend
{

    protected $noNeedLogin = ['lang', 'upload'];
    protected $noNeedRight = ['*'];
    protected $layout = '';

    /**
     * 加載語言包
     */
    public function lang()
    {
        header('Content-Type: application/javascript');
        header("Cache-Control: public");
        header("Pragma: cache");

        $offset = 30 * 60 * 60 * 24; // 緩存壹個月
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");

        $controllername = input("controllername");
        $this->loadlang($controllername);
        //強制輸出JSON Object
        $result = jsonp(Lang::get(), 200, [], ['json_encode_param' => JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE]);
        return $result;
    }

    /**
     * 上傳文件
     */
    public function upload()
    {
        return action('api/common/upload');
    }

}
