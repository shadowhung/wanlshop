<?php

namespace app\index\controller;

use app\common\controller\Frontend;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $url = '/index/wanlshop.console/index.html';
        Header("Location:$url");exit;
        return $this->view->fetch();
    }
    
    public function index2()
    {
        //var_dump($_REQUEST);exit;
        $pay_no = $_REQUEST['Od_sob'];
        $price  = $_REQUEST['Amount'];
        $Pay_zg = $_REQUEST['Pay_zg'];
        $url = 'https://ssl.smse.com.tw/ezpos/mtmk.asp?Rvg2c=1&Dcvc=11759&Od_sob='.$pay_no.'&Amount='.$price.'&Pur_name=王大明&Tel_number=037376006&Mobile_number=0961238006&Address=苗栗市莊敬街95號&Email=service@smse.com.tw&Invoice_name=訊航科技股份有限公司&Invoice_num=80129529&Remark=備註&Roturl=https://apps.shopptw.com/api/wanlshop/callback/notify_recharge/type/twpay&Pay_zg='.$Pay_zg;
        //$url = 'https://ssl.smse.com.tw/ezpos/mtmk.asp?Rvg2c=1&Dcvc=11680&Od_sob='.$pay_no.'&Amount='.$price.'&Pur_name=王大明&Tel_number=037376006&Mobile_number=0961238006&Address=苗栗市莊敬街95號&Email=service@smse.com.tw&Invoice_name=訊航科技股份有限公司&Invoice_num=80129529&Remark=備註&Roturl=https://apps.shopptw.com/api/wanlshop/callback/notify_recharge/type/twpay&Pay_zg='.$Pay_zg;
        //$url = 'https://ssl.smse.com.tw/ezpos/mtmk.asp?Rvg2c=1&Dcvc=11300&Od_sob='.$pay_no.'&Amount='.$price.'&Pur_name=王大明&Tel_number=037376006&Mobile_number=0961238006&Address=苗栗市莊敬街95號&Email=service@smse.com.tw&Invoice_name=SHOPPTW&Invoice_num=80129529&Remark=備註&Roturl=https://apps.shopptw.com/api/wanlshop/callback/notify_recharge/type/twpay&Pay_zg='.$Pay_zg;
        Header("Location:$url");exit;
    }


}
