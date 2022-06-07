<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/dashboard/index.html";i:1608326198;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
	[v-cloak] { display: none }
	.bg-card-blue{
		background: linear-gradient(-125deg, #57bdbf, #2f9de2);
		color: #ffffff;
	}
	.bg-card-red{
		background: linear-gradient(-125deg, #ff7d7d, #fb2c95);
		color: #ffffff;
	}
	.bg-card-violet {
	    background: linear-gradient(-113deg, #c543d8, #925cc3);
		color: #ffffff;
	}
	.bg-card-primary {
	    background: linear-gradient(-141deg, #ecca1b, #f39526);
		color: #ffffff;
	}
	.wanlcard .small-box,.panel{
		border-radius: 10px;
	}
	.wanlcard .small-box > .inner{
		padding: 15px 22px;
	}
	.wanlcard .small-box > .inner p:last-child{
		font-size: 12px;
	}
	.wanlcard .small-box p{
		font-size: 14px;
		margin: 10px 0;
	}
	.wanlcard .small-box h3{
		font-weight: 100;
	}
	.wanlcard .small-box .icon{
		color: rgba(255, 255, 255, 0.16);
		right: 22px;
	}
	
	.small-box .icon{
		font-size: 80px;
	}
	
	.panel-statistics h3 {
	    font-weight: 500;
	    font-size: 14px;
	    color: #333;
		margin-top: 9.2px;
	}
	
	.panel-statistics h4{
		color: #666;
		font-weight: 400;
		font-size: 14px;
	}
	.panel-btn{
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-top: -9px;
	}
	.wanl-order .panel{
		background: linear-gradient(-125deg, #57bdbf, #2f9de2);
	}
	.wanl-order .panel h3{
		font-weight: 500;
	}
	.wanl-order .panel h3, .wanl-order .panel h4{
		color: #ffffff;
	}
	.wanl-order .pull-left .fa{
		color: #ffffff;
		font-size: 30px;
	}
	.wanllist .panel-statistics h4 {
	    color: #555;
	    font-weight: bold;
	    font-size: 18px;
	}
	.wanllist .panel-statistics thead{
		color: #777777;
	}
	.vertical{
		vertical-align: middle;
	}
	
	.table > thead > tr > th, 
	.table > thead > tr > td, 
	.table > tbody > tr > th, 
	.table > tbody > tr > td
	{
		padding: 12px 0;
		font-weight: initial;
	}
	
	.table > tbody > tr > td:first-child {
		color: #666666;
	}
</style>
<div class="row wanlcard">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-card-blue">
            <div class="inner">
				<p>店铺</p>
                <h3><?php echo $totalShop; ?></h3>
                <p>商城店铺总数量</p>
            </div>
            <div class="icon">
                <i class="fa fa-sitemap"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-card-red">
            <div class="inner">
    			<p>商品</p>
    			<h3><?php echo $totalGoods; ?></h3>
    			<p>商城店铺商品总和</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
        </div>
    </div>
	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-card-violet">
	        <div class="inner">
				<p>会员</p>
	            <h3><?php echo $totalUser; ?></h3>
	            <p>平台注册会员总数</p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-user-circle"></i>
	        </div>
	    </div>
	</div>
	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-card-primary">
	        <div class="inner">
				<p>今日会员</p>
	            <h3><?php echo $totalDayUser; ?></h3>
	            <p>今日新增用户数量</p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-user"></i>
	        </div>
	    </div>
	</div>
</div>
<!-- 资金 -->
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3" style="margin-bottom:15px;">
                <div class="panel panel-default panel-intro panel-statistics">
                    <div class="panel-body">
                        <h3>平台总流水</h3>
                        <h4>￥<?php echo sprintf('%.2f',$MoneyPaySum); ?></h4>
                    </div>
                </div>
            </div>
			<div class="col-xs-3" style="margin-bottom:15px;">
			    <div class="panel panel-default panel-intro panel-statistics">
			        <div class="panel-body">
			            <h3>今日订单金额</h3>
			            <h4>￥<?php echo sprintf('%.2f',$MoneyLogDayPay); ?></h4>
			        </div>
			    </div>
			</div>
            <div class="col-xs-3" style="margin-bottom:15px;">
                <div class="panel panel-default panel-intro panel-statistics">
                    <div class="panel-body">
                        <h3>今日充值金额</h3>
                        <h4>￥<?php echo sprintf('%.2f',$MoneyLogDayRecharge); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xs-3" style="margin-bottom:15px;">
                <div class="panel panel-default panel-intro panel-statistics">
                    <div class="panel-body">
                        <h3>待处理提现</h3>
						<div class="panel-btn">
							<h4><?php echo $initiateWithdraw; ?> 个</h4>
							<a class="label label-success addtabsit" href="wanlshop/withdraw?ref=addtabs">处理</a>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 百度图标 -->
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="panel">
            <div class="panel-body">
                <div id="echarts_order" style="height: 360px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;" _echarts_instance_="ec_1605807574556"><div style="position: relative; width: 416px; height: 360px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="416" height="360" style="position: absolute; left: 0px; top: 0px; width: 416px; height: 360px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div style="position: absolute; display: none; border-style: solid; white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s, top 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgba(50, 50, 50, 0.7); border-width: 0px; border-color: rgb(51, 51, 51); border-radius: 4px; color: rgb(255, 255, 255); font: 14px/21px &quot;Microsoft YaHei&quot;; padding: 5px; left: 372px; top: 280px; pointer-events: none;">21:00<br>订单数 : 0 个 <br>订单额 : 0 元</div></div>
                <a href="javascript:" class="btn btn-refresh hidden" data-type="sale">订单统计</a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="row">
			<div class="wanl-order">
				<div class="col-xs-6" style="margin-bottom:15px;">
				    <div class="panel panel-default panel-intro panel-statistics">
				        <div class="panel-body">
							<div class="pull-left">
								<i class="fa fa-coffee"></i>
							</div>
							<div class="pull-right text-right">
								<h3>待付款</h3>
								<h4><?php echo $paidOrder; ?> 单</h4>
							</div>
				        </div>
				    </div>
				</div>
				<div class="col-xs-6" style="margin-bottom:15px;">
				    <div class="panel panel-default panel-intro panel-statistics">
				        <div class="panel-body">
							<div class="pull-left">
								<i class="fa fa-truck"></i>
							</div>
							<div class="pull-right text-right">
								<h3>待发货</h3>
								<h4><?php echo $deliveredOrder; ?> 单</h4>
							</div>
				        </div>
				    </div>
				</div>
				<div class="col-xs-6" style="margin-bottom:15px;">
				    <div class="panel panel-default panel-intro panel-statistics">
				        <div class="panel-body">
							<div class="pull-left">
								<i class="fa fa-cube"></i>
							</div>
				            <div class="pull-right text-right">
				            	<h3>待收货</h3>
				            	<h4><?php echo $receivedOrder; ?> 单</h4>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="col-xs-6" style="margin-bottom:15px;">
				    <div class="panel panel-default panel-intro panel-statistics">
				        <div class="panel-body">
							<div class="pull-left">
								<i class="fa fa-cart-arrow-down"></i>
							</div>
							<div class="pull-right text-right">
								<h3>售后订单</h3>
								<h4><?php echo $totalRefund; ?> 单</h4>
							</div>
				        </div>
				    </div>
				</div>
			</div>
			<div class="col-xs-6" style="margin-bottom:15px;">
			    <div class="panel panel-default panel-intro panel-statistics">
			        <div class="panel-body">
			            <h3>总订单数</h3>
			            <h4><?php echo $totalOrder; ?> 单</h4>
			        </div>
			    </div>
			</div>
			<div class="col-xs-6" style="margin-bottom:15px;">
			    <div class="panel panel-default panel-intro panel-statistics">
			        <div class="panel-body">
			            <h3>在售sku总量</h3>
			            <h4><?php echo $totalSku; ?> 个</h4>
			        </div>
			    </div>
			</div>
			<div class="col-xs-6" style="margin-bottom:15px;">
			    <div class="panel panel-default panel-intro panel-statistics">
			        <div class="panel-body">
			            <h3>商品总访客数</h3>
			            <h4><?php echo $totalGoodsViews; ?> 次</h4>
			        </div>
			    </div>
			</div>
			<div class="col-xs-6" style="margin-bottom:15px;">
			    <div class="panel panel-default panel-intro panel-statistics">
			        <div class="panel-body">
			            <h3>评论数量</h3>
			            <h4><?php echo $totalComment; ?> 个</h4>
			        </div>
			    </div>
			</div>
        </div>
    </div>
</div>
<!-- 列表 -->
<div class="row wanllist">
	<div class="col-xs-12 col-sm-4">
	    <div class="panel panel-default panel-intro panel-statistics">
	        <div class="panel-body">
	            <h4>TOP10 销量</h4>
	            <table class="table" style="width:100%">
	                <thead>
	                <tr>
	                    <th class="text-left">商品名称</th>
	                    <th class="text-right" width="50px">销量</th>
	                </tr>
	                </thead>
	                <tbody>
	                	<?php if(is_array($goodsTopList) || $goodsTopList instanceof \think\Collection || $goodsTopList instanceof \think\Paginator): if( count($goodsTopList)==0 ) : echo "<tr><td colspan='2' class='text-center'>暂无数据</td></tr>" ;else: foreach($goodsTopList as $key=>$item): ?>
	                	<tr>
	                		<td class="vertical text-left">
								<?php echo $key+1; ?>. <?php echo $item['title']; ?>
	                		</td>
	                		<td class="vertical text-right">
	                			<?php echo $item['sales']; ?>
	                		</td>
	                	</tr>
	                	<?php endforeach; endif; else: echo "<tr><td colspan='2' class='text-center'>暂无数据</td></tr>" ;endif; ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
    <div id="wanlshop" v-cloak>
    	<div class="col-xs-12 col-sm-4">
    	    <div class="panel panel-default panel-intro panel-statistics">
    	        <div class="panel-body">
    	            <h4>新申请店铺</h4>
    	            <table class="table" style="width:100%">
    	                <thead>
    	                <tr>
    						<th align="left">店铺名</th>
    						<th class="text-center">类型</th>
							<th class="text-center">状态</th>
    						<th width="96px" class="text-center">操作</th>
    	                </tr>
    	                </thead>
    	                <tbody>
    						<tr v-for="(item, index) in shopAuthList"  :key="index">
    							<td class="vertical text-left" @click="shopDetails(index)">
    								{{item.shopname}}
    							</td>
    							<td class="vertical text-center">
    								{{shopState[item.state]}}
    							</td>
								<td class="vertical text-center">
									{{shopVerify[item.verify]}}
								</td>
    							<td class="vertical text-right">
    								<span class="btn btn-xs btn-success btn-editone" @click="shopAgree(index)"> <i class="fa fa-check"></i> </span>
    								<span class="btn btn-xs btn-danger btn-editone" @click="shopRefuse(index)"> <i class="fa fa-times"></i> </span>
    								<span class="btn btn-xs btn-info btn-editone" @click="shopDetails(index)"> <i class="fa fa-eye"></i> </span>
    							</td>
    						</tr>
							<tr><td colspan='4' class='text-center' v-if="shopAuthList.length == 0">暂无数据</td></tr>
    					</tbody>
    	            </table>
    	        </div>
    	    </div>
    	</div>
    	<div class="col-xs-12 col-sm-4">
    	    <div class="panel panel-default panel-intro panel-statistics">
    	        <div class="panel-body">
    	            <h4>介入退款</h4>
    	            <table class="table" style="width:100%">
    	                <thead>
    	                <tr>
    	                    <th>订单号</th>
    						<th class="text-center">金额</th>
    						<th class="text-center">状态</th>
    	                    <th width="96px" class="text-center">操作</th>
    	                </tr>
    	                </thead>
    	                <tbody>
    	                	<tr v-for="(item, index) in refundList" :key="index">
    	                		<td class="vertical text-left" @click="refundDetails(index)">
    	                			{{item.pay.order_no}}
    	                		</td>
    							<td class="vertical text-center">
    								{{item.price}}
    							</td>
    	                		<td class="vertical text-center">
    	                			{{refundState[item.state]}}
    	                		</td>
    	                		<td class="vertical text-right">
    								<span class="btn btn-xs btn-info btn-editone" @click="refundDetails(index)"> <i class="fa fa-eye"></i> </span>
    								<span class="btn btn-xs btn-success btn-editone" @click="refundAgree(index)"> <i class="fa fa-check"></i> </span>
    								<span class="btn btn-xs btn-danger btn-editone" @click="refundRefuse(index)"> <i class="fa fa-times"></i> </span>
    	                		</td>
    	                	</tr>
							<tr><td colspan='4' class='text-center' v-if="refundList.length == 0">暂无数据</td></tr>
    	                </tbody>
    	            </table>
    	        </div>
    	    </div>
    	</div>
    </div>
</div>

<div class="wanlshop" style="height: 20px;"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
