<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/order/index.html";i:1617810796;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <div class="alert alert-success-light">
	<i class="fa fa-warning"></i> 重要提示：后台订单列表仅供查看，如需发货、或修改订单信息请到商家后台操作！<a target="_blank" href="/index/wanlshop.console">进入商家后台</a>
</div>

<div class="panel panel-default panel-intro">

	<div class="panel-heading">

		<?php echo build_heading(null,FALSE); ?>

		<ul class="nav nav-tabs" data-field="state">

			<li class="active"><a href="#t-all" data-value="" data-toggle="tab"><?php echo __('All'); ?></a></li>

			<?php if(is_array($stateList) || $stateList instanceof \think\Collection || $stateList instanceof \think\Paginator): if( count($stateList)==0 ) : echo "" ;else: foreach($stateList as $key=>$vo): ?>

			<li><a href="#t-<?php echo $key; ?>" data-value="<?php echo $key; ?>" data-toggle="tab"><?php echo $vo; ?></a></li>

			<?php endforeach; endif; else: echo "" ;endif; ?>

		</ul>

	</div>

	<div class="panel-body">

		<div id="myTabContent" class="tab-content">

			<div class="tab-pane fade active in" id="one">

				<div class="widget-body no-padding">

					<div id="toolbar" class="toolbar">

						<?php echo build_toolbar('refresh,delete'); ?>

						<!-- <a class="btn btn-info btn-disabled disabled btn-selected" href="javascript:;"><i class="fa fa-leaf"></i> 批量 打印发货单</a>

						<a class="btn btn-success btn-disabled disabled btn-selected" href="javascript:;"><i class="fa fa-leaf"></i> 批量 打印运单</a>

						<a class="btn btn-info btn-disabled disabled btn-selected" href="javascript:;"><i class="fa fa-leaf"></i> 批量发货</a> -->

						<a class="btn btn-warning btn-recyclebin btn-dialog <?php echo $auth->check('wanlshop/order/recyclebin')?'':'hide'; ?>" href="wanlshop/order/recyclebin" title="<?php echo __('Recycle bin'); ?>"><i class="fa fa-recycle"></i> <?php echo __('Recycle bin'); ?></a>

					</div>

					<table id="table" class="table table-striped table-bordered table-hover table-nowrap" width="100%"></table>

				</div>

			</div>



		</div>

	</div>

</div>

<style type="text/css">

	.wanl_order_list{

		margin-bottom: 15px;

	}

	.wanl_order_list .detail{

		

	}

	.fix-108{

		width: 108px;

		text-align: center;

	}

	.text-left{

		text-align: left;

	}

	.text-right{

		text-align: right;

	}

	.wanl_order_list .table>thead{

		background: #f1f4f6;

	}

	.bootstrap-table .table,

	.bootstrap-table .table>thead>tr>th{

		border-bottom: 1px solid #f1f1f1;

	}

	.table-bordered{

		border: 1px solid #f1f1f1;

	}

	.table-bordered > thead > tr > th, 

	.table-bordered > tbody > tr > td {

		border: 1px solid #f1f1f1;

		border-bottom: 0;

	}

	.table-bordered > thead > tr > th, label{

		margin-bottom: 0;

		font-weight: normal;

	}

	.table-bordered > tbody td.empty{

		border-top: 0;

	}

	.table-bordered > tbody td.conceal{

		border-left: 0 ;

		border-right: 0 ;

	}

	.table-bordered > tbody td.conceal.fix-108{

	}

	/* 产品 */

	.wanl_order_list p{

		margin-bottom: 4px;

	}

	.wanl_order_list .item {

		display: flex;

		margin: 10px;

	}

	

	.wanl_order_list .item .order_img {

		flex-shrink: 0;

	}

	.wanl_order_list .item .order_info {

		width: 90%;

		margin-left: 10px;

		margin-top: 2px;

	}

	.wanl_order_list .item .order_info .sku {

		color: #9e9e9e;

	}

	.wanl_order_list .operation a{

		color: #565656;

	}

</style>

<script type="text/html" id="itemtpl">

	<% if(i == 0){ %>

		<div class="col-sm-12" style="margin-bottom: 15px;">

			<table class="table table-bordered table-striped table-hover table-nowrap">

			   <thead>

				   <tr>
				   
				        <th class="fix-108"><div class="th-inner">
				        <input name="checkbox" data-id="0" onchange="selectAll()" id="order_0" type="checkbox" />全选
				        </div>
				        </th>

						<th class="text-center"><div class="th-inner">商品</div></th>

						<th class="fix-108"><div class="th-inner">单价</div></th>

						<th class="fix-108"><div class="th-inner">数量</div></th>

						<th class="fix-108"><div class="th-inner">买家</div></th>

						<th class="fix-108"><div class="th-inner">实际支付</div></th>

						<th class="fix-108"><div class="th-inner">状态</div></th>

						<!-- <th class="fix-108"><div class="th-inner">操作</div></th> -->

				   </tr>

			   </thead>

			</table>

		</div>

	<% } %>

	<div class="wanl_order_list col-sm-12">

		<table class="table table-bordered table-hover ">

			<thead>

				<tr>

					<th colspan="7">

						<div class="th-inner">

							<input name="checkbox" data-id="<%=item.id%>" data-value="<%=item.id%>" value="<%=item.id%>" id="order_<%=item.id%>" type="checkbox" /> 

							<label for="order_<%=item.id%>">订单号：<%=item.order_no%></label>

							<label style="margin-left:60px;" for="order_<%=item.id%>">创建时间：<%=Moment(item.createtime*1000).format("YYYY-MM-DD HH:mm:ss")%></label>

							<a href="javascript:;" style="margin-left:60px;" class="searchit text-primary" data-toggle="tooltip" title="" data-field="shop.shopname" data-value="<%=item.shop.shopname%>" data-original-title="点击搜索 <%=item.shop.shopname%>"> <i class="fa fa-shopping-cart"></i> 商家名：<%=item.shop.shopname%> (商家ID：<%=item.shop.id%> 电话：<%=item.puserid.mobile%>)</a>
							
							<% if(item.wholesale_id!=0){%>
                            <span style="color:red;">(批發訂單)</span>
                            <% }%>
                            <% if(item.user.isshua==1){%>
                            <span style="color:red;">(刷单)</span>
                            <% }%>

						</div>

					</th>

				</tr>			   

			</thead>

			<tbody>

			

					<% var labelarr = ['primary', 'success', 'info', 'danger', 'warning', 'muted']; %>

				    <tr>

				    	<td class="conceal">

							

				    	</td>

				    	

						

				    	<td class="fix-108">

				    		<p style="margin-bottom:5px;">

				    			<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="user.nickname" data-value="<%=item.user.nickname%>" data-original-title="点击搜索 <%=item.user.nickname%>"><%=item.user.nickname%>(<%=item.user.username%>)</a>
				    			<% if(item.user.isshua==1){%>
                            <span style="color:red;">(刷单)</span>
                            <% }%>

				    		</p>

				    	</td>

						

						<td class="fix-108 operation">

							<% if(item.state == 1){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[4]%>"><i class="fa fa-circle"></i> <%=item.state_text%> </span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<% }else if(item.state == 2){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[0]%>"><i class="fa fa-circle"></i> <%=item.state_text%></span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<% }else if(item.state == 3){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[2]%>"><i class="fa fa-circle"></i> <%=item.state_text%></span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<p><a href="javascript:;" class="kuaidisub" data-id="<%=item.id%>">查看物流</a> </p>

							<% }else if(item.state == 4){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[1]%>"><i class="fa fa-circle"></i> <%=item.state_text%></span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<p><a href="javascript:;" class="kuaidisub" data-id="<%=item.id%>">查看物流</a> </p>

							<% }else if(item.state == 5){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[0]%>"><i class="fa fa-circle"></i> <%=item.state_text%></span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<p><a href="javascript:;" class="kuaidisub" data-id="<%=item.id%>">查看物流</a> </p>

							<% }else if(item.state == 6){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[3]%>"><i class="fa fa-circle"></i> <%=item.state_text%></span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<p><a href="javascript:;" class="kuaidisub" data-id="<%=item.id%>">查看物流</a> </p>

							<p><a href="javascript:;" class="comment" data-id="<%=item.id%>">查看评论</a> </p>

							<% }else if(item.state == 7){ %>

							<p>

								<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="state" data-value="<%=item.state%>" data-original-title="点击搜索 <%=item.state_text%>">

									<span class="text-<%=labelarr[5]%>"><i class="fa fa-circle"></i> <%=item.state_text%></span>

								</a>

							</p>

							<p><a href="javascript:;" class="detail" data-id="<%=item.id%>">订单详情</a> </p>

							<p><a href="javascript:;" class="kuaidisub" data-id="<%=item.id%>">查看物流</a> </p>

							<% } %>

						</td>

						

					

				    </tr>

			

			</tbody>

		</table>

	</div>

</script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
