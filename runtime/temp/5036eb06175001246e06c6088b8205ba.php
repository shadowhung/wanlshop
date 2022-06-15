<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:94:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/wholeorder/invoice.html";i:1608486590;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                
<div id="print_html">
	<link href="/assets/css/backend.css?v=1581391093" rel="stylesheet">
	<style type="text/css">
		h3{
			margin-bottom: 40px;
		}
		#print_html{
			font-size: 11px!important;
			overflow: hidden;
		}
		.table-head>tbody>tr>th,
		.table-head>tbody>tr>td {
			border: 0px;
			padding: 5px;
			line-height: 1;
		}
		.table>tbody>tr>th,
		.table>tbody>tr>td {
			font-size: 12px;
		}
		.table>thead>tr>th{
			font-size: 12px;
		}
		.wanlpay span{
			margin-left: 10px;
		}
	</style>

	<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
		<h3 align="center">商品发货单</h3>
		<table class="table table-head">
			<tbody>
				<tr>
					<td>用户名：<?php echo $order['user']['username']; ?></td>
					<td colspan="2">姓名：<?php echo $order['address']['name']; ?></td>
					<td style="text-align: right;">订单号：<?php echo $order['order_no']; ?></td>
				</tr>
				<tr>
					<td>地址：<?php echo $order['address']['address']; ?></td>
					<td colspan="2">手机号：<?php echo $order['address']['mobile']; ?></td>
					<td style="text-align: right;">下单时间：<?php echo datetime($order['createtime']); ?></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>商品名称</th>
					<th>商家编码</th>
					<th>购买规格</th>
					<th>数量</th>
					<th>商品单价</th>
					<th>快递费用</th>
					<th>优惠</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($order['ordergoods']) || $order['ordergoods'] instanceof \think\Collection || $order['ordergoods'] instanceof \think\Paginator): $i = 0; $__LIST__ = $order['ordergoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo $goods['title']; ?></td>
						<td><?php echo $goods['goods_sku_sn']; ?></td>
						<td><?php echo $goods['difference']; ?></td>
						<td><?php echo $goods['number']; ?></td>
						<td>￥ <?php echo $goods['price']; ?></td>
						<td>￥ <?php echo $goods['freight_price']; ?></td>
						<td>￥ <?php echo $goods['discount_price']; ?></td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<tr>
					<td colspan="7">
						<div class="wanlpay" align="right">
							
							<p>总数量：<?php echo $order['pay']['number']; ?></p>
							<p>实际支付：<?php echo $order['pay']['actual_payment']; ?></p>
							<p><span>商品金额：<?php echo $order['pay']['order_price']; ?></span>
							<span>总运费：<?php echo $order['pay']['freight_price']; ?></span>
							<span>优惠金额：<?php echo $order['pay']['discount_price']; ?></span>
							<span>总金额：<?php echo $order['pay']['price']; ?></span></p>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div style="margin-bottom: 50px;"> </div>
		<div style="page-break-after: always;"></div>
	<?php endforeach; endif; else: echo "" ;endif; ?>

</div>

<div class="form-group layer-footer">
	<label class="control-label col-xs-12 col-sm-1"></label>
	<div class="col-xs-12 col-sm-10">
		<div class="btn btn-success btn-embossed"> 打印发货单 </div>
	</div>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
