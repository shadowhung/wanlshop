<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:95:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/wholeorder/delivery.html";i:1608486588;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
	#c-express_name{
		width: 300px;
		display: block;
	}
	.control-label span{
		font-weight: normal;
		color: #777;
	}
</style>
<form id="edit-form" role="form" data-toggle="validator" method="POST" action="">
	<div class="form-group">
		<label for="shopname" class="control-label">快递公司:</label>
		<select id="c-express_name" name="row[express_name]" class="form-control" data-rule="required">
			<option value="">请选择快递公司</option>
			<?php if(is_array($kuaidiList) || $kuaidiList instanceof \think\Collection || $kuaidiList instanceof \think\Paginator): $i = 0; $__LIST__ = $kuaidiList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['code']; ?>"><?php echo $vo['name']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select> 
	</div>

	<div class="form-group">
		<label for="shopname" class="control-label">快递单:</label>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>订单号</th>
					<th>状态</th>
					<th>姓名</th>
					<th>手机</th>
					<th>地区</th>
					<th>快递单号</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
				<tr>
					<th style="text-align: center; vertical-align: middle;" scope="row"><?php echo $order['id']; ?></th>
					<td style="text-align: center; vertical-align: middle;"><?php echo $order['order_no']; ?></td>
					<td style="vertical-align: middle;"><span class="text-blue"><?php echo $order['state_text']; ?></span></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo $order['address']['name']; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo $order['address']['mobile']; ?></td>
					<td style="vertical-align: middle;"><?php echo $order['address']['address']; ?></td>
					<td style="text-align: center; vertical-align: middle;">
						<input type="hidden" name="row[order][id][]" value="<?php echo $order['id']; ?>">
						<input id="c-express_no" data-rule="required" class="form-control" name="row[order][express_no][]" type="text" value="">
					</td>
				</tr>
				<?php endforeach; endif; else: echo "" ;endif; if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
				<tr>
					<th style="text-align: center; vertical-align: middle;" scope="row"><?php echo $order['id']; ?></th>
					<td style="text-align: center; vertical-align: middle;"><?php echo $order['order_no']; ?></td>
					<td style="vertical-align: middle;"><span class="text-blue"><?php echo $order['state_text']; ?></span></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo $order['address']['name']; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo $order['address']['mobile']; ?></td>
					<td style="vertical-align: middle;"><?php echo $order['address']['address']; ?></td>
					<td style="text-align: center; vertical-align: middle;"><input class="form-control" type="text" value="" placeholder="此订单不可发货 填单" disabled></td>
				</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>

	<!-- <div class="form-group">
		<label for="shopname" class="control-label">设置订单: <span>（开启后将所选订单设置为发货）</span></label>
		<p><?php echo Form::switcher('row[setorder]', '0', ['color'=>'info']); ?></p>
	</div> -->

	<div class="form-group layer-footer">
		<label class="control-label col-xs-12 col-sm-1"></label>
		<div class="col-xs-12 col-sm-10">
			<button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
			<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
		</div>
	</div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
