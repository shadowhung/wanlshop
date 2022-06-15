<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/order/detail.html";i:1608326198;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <style type="text/css">
	.content {
		padding: 25px 20px;
	}

	/* 订单详情 */
	.order-detail .order-block {
		height: 31px;
		line-height: 31px;
		background: #e8edf0;
		border-radius: 13px;
		font-size: 14px;
		text-align: center;
		position: relative;
		margin-bottom: 50px;
	}

	.order-detail .order-block:before,
	.order-detail .order-block:after {
		content: "";
		position: absolute;
		z-index: 2;
		left: 0;
		top: 0;
		bottom: 0;
		border-radius: 13px;
		background: #18bc9c;
	}

	.order-detail .order-block:after {
		background: #4dc7af;
		z-index: 1;
	}

	.order-detail .order-block.progress-1:before {
		width: 0;
	}

	.order-detail .order-block.progress-1:after {
		width: 20%;
	}

	.order-detail .order-block.progress-2:before {
		width: 20%;
	}

	.order-detail .order-block.progress-2:after {
		width: 40%;
	}

	.order-detail .order-block.progress-3:before {
		width: 40%;
	}

	.order-detail .order-block.progress-3:after {
		width: 60%;
	}

	.order-detail .order-block.progress-4:before {
		width: 60%;
	}

	.order-detail .order-block.progress-4:after {
		width: 80%;
	}

	.order-detail .order-block.progress-5:before {
		width: 100%;
	}

	.order-detail .order-block.progress-5:after {
		width: 100%;
	}

	.order-detail .order-block.progress-5 li:nth-child(5) {
		color: #fff;
	}

	.order-detail .order-block li {
		width: 20%;
		float: left;
		list-style-type: none;
		border-radius: 13px;
		position: relative;
		z-index: 3;
	}

	.order-detail .order-block .tip {
		font-size: 12px;
		padding-top: 10px;
		color: #717171;
	}

	.order-detail .order-block.progress-1 li:nth-child(1),
	.order-detail .order-block.progress-2 li:nth-child(1),
	.order-detail .order-block.progress-3 li:nth-child(1),
	.order-detail .order-block.progress-4 li:nth-child(1),
	.order-detail .order-block.progress-5 li:nth-child(1) {
		color: #fff;
	}

	.order-detail .order-block.progress-2 li:nth-child(2),
	.order-detail .order-block.progress-3 li:nth-child(2),
	.order-detail .order-block.progress-4 li:nth-child(2),
	.order-detail .order-block.progress-5 li:nth-child(2) {
		color: #fff;
	}

	.order-detail .order-block.progress-3 li:nth-child(3),
	.order-detail .order-block.progress-4 li:nth-child(3),
	.order-detail .order-block.progress-5 li:nth-child(3) {
		color: #fff;
	}

	.order-detail .order-block.progress-4 li:nth-child(4),
	.order-detail .order-block.progress-5 li:nth-child(4) {
		color: #fff;
	}

	.order-detail .td__order-price {
		width: 200px;
		display: inline-block;
	}

	.order-head {
		width: 100%;
		padding: 12px 20px;
		margin-top: 60px;
		/* margin-bottom: 20px; */
		/* border-bottom: 1px solid #eef1f5; */
	}

	.order-head:not(:first-child) {
		margin-top: 0;
	}

	.order-head .title {
		position: relative;
		font-size: 1.5rem;
		color: #333;
	}

	.order-head .title::before {
		content: '';
		position: absolute;
		width: 4px;
		height: 14px;
		background: #18bc9c;
		top: 4px;
		left: -12px;
	}

	.table-responsive .table>tbody>tr>td {
		text-align: center;
		vertical-align: middle;
		color: #676767;
	}

	.ordertext {
		margin: 0 30px;
	}

	.table-bordered {
		border: 1px solid #e8edf0;
	}

	.table-bordered>thead>tr>th,
	.table-bordered>tbody>tr>th,
	.table-bordered>tfoot>tr>th,
	.table-bordered>thead>tr>td,
	.table-bordered>tbody>tr>td,
	.table-bordered>tfoot>tr>td {
		border: 1px solid #e8edf0;
	}

	.table thead tr {
		background: #f8f9fb;
	}

	.order_price span {
		width: 70px;
		display: inline-block;
		text-align: right;
	}
</style>
<div class="order-detail">
	<ul class="order-block progress-<?php echo $row['state']; ?>">
		<li>
			<span>下单时间</span>
			<div class="tip"><?php echo !empty($row['createtime'])?datetime($row['createtime']):''; ?></div>
		</li>
		<li>
			<span>付款</span>
			<div class="tip"><?php echo !empty($row['paymenttime'])?datetime($row['paymenttime']):''; ?></div>
		</li>
		<li>
			<span>发货</span>
			<div class="tip"><?php echo !empty($row['delivertime'])?datetime($row['delivertime']):''; ?></div>
		</li>
		<li>
			<span>收货</span>
			<div class="tip"><?php echo !empty($row['taketime'])?datetime($row['taketime']):''; ?></div>
		</li>
		<li>
			<span>完成</span>
			<div class="tip"><?php echo !empty($row['dealtime'])?datetime($row['dealtime']):''; ?></div>
		</li>
	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">商品信息</div>
			<div class="panel-body">
				<p><span>订单号：</span><small><?php echo $row['order_no']; ?></small> <span style="margin-left: 30px;">买家：</span><small><?php echo $row['user']['nickname']; ?></small><strong></strong></p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">
								<div class="th-inner">商品编码</div>
							</th>
							<th class="text-center">
								<div class="th-inner">主图</div>
							</th>
							<th class="text-center">
								<div class="th-inner">商品名称</div>
							</th>
							<th class="text-center">
								<div class="th-inner">购买规格</div>
							</th>
							<th class="text-center">
								<div class="th-inner">数量</div>
							</th>
							<th class="text-center">
								<div class="th-inner">单价</div>
							</th>
							<!-- <th class="text-center"><div class="th-inner">总价</div></th> -->
							<!-- <th class="text-center">
								<div class="th-inner">运费</div>
							</th>
							<th class="text-center">
								<div class="th-inner">优惠</div>
							</th> -->
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($row['ordergoods']) || $row['ordergoods'] instanceof \think\Collection || $row['ordergoods'] instanceof \think\Paginator): $i = 0; $__LIST__ = $row['ordergoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<tr>
							<td><?php echo $vo['goods_sku_sn']; ?></td>
							<td><a href="javascript:"><img class="img-sm img-center" src="<?php echo htmlentities(cdnurl($vo['image'])); ?>"></a></td>
							<td><strong><?php echo $vo['title']; ?></strong></td>
							<td><?php echo $vo['difference']; ?></td>
							<td><?php echo $vo['number']; ?></td>
							<td><?php echo $vo['price']; ?></td>
							<!-- <td><?php echo $vo['price']*$vo['number']; ?></td> -->
							<!-- <td><?php echo $vo['freight_price']; ?></td>
							<td><?php echo $vo['discount_price']; ?></td> -->
						</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="9" style="text-align: right;">
								<span class="ordertext">运费（<?php switch($row['freight_type']): case "0": ?>运费叠加<?php break; case "1": ?>以最低结算<?php break; case "2": ?>以最高结算<?php break; endswitch; ?>）：<samp class="text-red">￥<?php echo $row['pay']['freight_price']; ?></samp> </span>
								<span class="ordertext">优惠金额：<samp class="text-red">￥<?php echo $row['pay']['discount_price']; ?></samp> </span>
								<span class="ordertext">实际支付：<samp class="text-red">￥<?php echo $row['pay']['price']; ?></samp></span>
							</th>
						</tr>
					</tfoot>
				</table>
				<div style="color: #333;">
					<p style="margin-bottom: 15px;">支付方式：
						<?php switch($row['pay']['pay_type']): case "0": ?><span class="label label-info"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; case "1": ?><span class="label label-warning"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; case "2": ?><span class="label label-primary"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; case "3": ?><span class="label label-success"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; case "4": ?><span class="label label-success"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; case "5": ?><span class="label label-danger"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; case "6": ?><span class="label label-warning"><?php echo htmlentities($row['pay']['pay_type_text']); ?></span><?php break; endswitch; ?>
					</p>
					<p style="margin-bottom: 15px;">交易状态：
						<?php switch($row['state']): case "0": ?><span class="label label-info"><?php echo htmlentities($row['state_text']); ?></span><?php break; case "1": ?><span class="label label-warning"><?php echo htmlentities($row['state_text']); ?></span><?php break; case "2": ?><span class="label label-primary"><?php echo htmlentities($row['state_text']); ?></span><?php break; case "3": ?><span class="label label-success"><?php echo htmlentities($row['state_text']); ?></span><?php break; case "4": ?><span class="label label-success"><?php echo htmlentities($row['state_text']); ?></span><?php break; case "5": ?><span class="label label-danger"><?php echo htmlentities($row['state_text']); ?></span><?php break; case "6": ?><span class="label label-warning"><?php echo htmlentities($row['state_text']); ?></span><?php break; endswitch; ?>
					</p>
					<?php if($row['coupon_id'] != '0'): ?>
						<p>优惠折扣：<?php echo $row['coupon']['name']; ?>
						</p>
					<?php endif; ?>
					<p>配送方式：<small><?php echo !empty($row['express_name'])?$row['express_name']: '未发货'; ?></small></p>
					<?php if(!(empty($row['remarks']) || (($row['remarks'] instanceof \think\Collection || $row['remarks'] instanceof \think\Paginator ) && $row['remarks']->isEmpty()))): ?>
						<p>买家留言：<?php echo $row['remarks']; ?></small></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php if($row['state'] != 7): if($row['state'] >= 2): ?>
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">收货地址</div>
			<div class="panel-body">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>收货人</td>
							<td><?php echo $row['address']['name']; ?></td>
						</tr>
						<tr>
							<td>联系电话</td>
							<td><?php echo $row['address']['mobile']; ?></td>
						</tr>
						<tr>
							<td>收货地址</td>
							<td><?php echo $row['address']['address']; ?>-<?php echo $row['address']['address_name']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">付款信息</div>
			<div class="panel-body">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>交易号</td>
							<td><?php echo $row['pay']['pay_no']; ?></td>
						</tr>
						<tr>
							<td>支付方式</td>
							<td><?php echo $row['pay']['pay_type_text']; ?></td>
						</tr>
						<tr>
							<td>交易订单号</td>
							<td><?php echo $row['pay']['trade_no']; ?></td>
						</tr>
						<tr>
							<td>付款状态</td>
							<td><?php echo $row['pay']['pay_state_text']; ?></td>
						</tr>
						<tr>
							<td>付款时间</td>
							<td><?php echo $row['paymenttime_text']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; if($row['state'] >= 3): ?>
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">发货状态</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">
								<div class="th-inner">快递公司</div>
							</th>
							<th class="text-center">
								<div class="th-inner">快递号</div>
							</th>
							<th class="text-center">
								<div class="th-inner">发货状态</div>
							</th>
							<th class="text-center">
								<div class="th-inner">物流信息</div>
							</th>
							<th class="text-center">
								<div class="th-inner">更新时间</div>
							</th>
							<th class="text-center">
								<div class="th-inner">操作</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $row['express_name']; ?></td>
							<td><?php echo $row['express_no']; ?></td>
							<td><?php echo $kuaidi['status']; ?></td>
							<td><?php echo $kuaidi['context']; ?></td>
							<td><?php echo $kuaidi['time']; ?></td>
							<td><a href="javascript:;" class="btn btn-xs btn-info btn-selected kuaidisub" data-id="<?php echo $row['id']; ?>" data-toggle="tooltip" data-original-title="查看物流"><i class="fa fa-eye"></i></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; endif; ?>
</div>





<div class="hide layer-footer">
	<label class="control-label col-xs-12 col-sm-2"></label>
	<div class="col-xs-12 col-sm-8">
		<button type="reset" class="btn btn-primary btn-embossed btn-close" onclick="Layer.closeAll();"><?php echo __('Close'); ?></button>
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
