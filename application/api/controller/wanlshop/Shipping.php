<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
/**
 * WanlShop地址接口
 */
class Shipping extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    
     /**
     * 物流地址接口
     *
     * @ApiTitle    (物流地址)
     * @ApiSummary  (物流地址)
     * @ApiMethod   (POST)
     * @ApiRoute    (api/wanlshop/shipping/index)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token,默认值wanlshop")
     * @ApiParams   (name="sid", type="string", required=true, description="物流单号")
     * @ApiParams   (name="oid", type="string", required=true, description="订单号")
     * @ApiReturnParams   (name="code", type="integer", required=true, sample="10000")
     * @ApiReturnParams   (name="msg", type="string", required=true, sample="返回成功")
     * @ApiReturnParams   (name="data", type="object", sample="}", description="扩展数据返回")
     * @ApiReturn   ({
        'code':'1',
        'mesg':'返回成功'
     * })
     */
    public function index()
    {
        $data = json_decode( file_get_contents('php://input'),true );
        
        // if(empty($data['token'])){
        //     exit(json_encode([
    	   //     'msg'   =>  '返回失败，签名缺少',
    	   //     'code'  =>  0
    	   // ]));
        // }
        
        if(empty($data['sid'])){
            exit(json_encode([
    	        'msg'   =>  'error miss sid',
    	        'code'  =>  0
    	    ]));
        }
        
        if(empty($data['oid'])){
            exit(json_encode([
    	        'msg'   =>  'error miss oid',
    	        'code'  =>  0
    	    ]));
        }
        
        /*
            拿订单ID，去更新
        */
        $row = model('app\index\model\wanlshop\Order')
            ->where(['order_no' => $data['oid']])
            ->find();
        if(!empty($row)){
            model('app\index\model\wanlshop\Order')
            ->where(['order_no' => $data['oid']])
            ->update([
                'express_no'=>$data['sid']
            ]);
        }
	    exit(json_encode([
	        'msg'   =>  'success',
	        'code'  =>  1
	    ]));
    }

}
