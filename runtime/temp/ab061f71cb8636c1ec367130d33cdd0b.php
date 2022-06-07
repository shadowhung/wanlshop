<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/client/app.html";i:1608326198;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
	<i class="fa fa-warning"></i> 温馨提示：如不搭建【APP客户端】则不用配置此页，如要搭建请完善此页，点击【更新】后系统将更新客户端配置文件，更新完请在【客户端配置】重新生成源码导入HBuilder X
</div>
<div class="panel panel-default panel-intro">
	<div class="panel-heading">
		<div class="panel-lead"><em>APP客户端</em>用于App客户端参数配置和本地一键打包安卓 & 苹果应用</div>
	</div>
	<div class="panel-body">
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="ini">
				<div class="widget-body no-padding">
					<form id="ini-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">
					    <?php echo token(); ?>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">配置项</th>
									<th width="85%">参数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>应用名称</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][name]', $wanlshop['ini']['name'], ['data-rule'=>'required','data-tip'=>'请填写应用名称','placeholder'=>'应用名称，同等于app名称']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>UrlSchemes</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][urlschemes]', $wanlshop['ini']['urlschemes'], ['data-rule'=>'required','data-tip'=>'请填写UrlSchemes','placeholder'=>'可以理解为http打开页面，自定义UrlSchemes，在网页中拉起APP，如：wanlshop']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>应用包名</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][package_name]', $wanlshop['ini']['package_name'], ['data-rule'=>'required','data-tip'=>'请填写应用包名','placeholder'=>'包名一般域名倒序，如com.def.abc']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td>
										<button type="submit" class="btn btn-success btn-embossed"><?php echo __('更新'); ?></button>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</td>
									<td></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	@media (max-width: 375px) {
		.edit-form tr td input {
			width: 100%;
		}

		.edit-form tr th:first-child,
		.edit-form tr td:first-child {
			width: 20%;
		}

		.edit-form tr th:nth-last-of-type(-n+2),
		.edit-form tr td:nth-last-of-type(-n+2) {
			display: none;
		}
	}

	.edit-form table>tbody>tr td a.btn-delcfg {
		visibility: hidden;
	}

	.edit-form table>tbody>tr:hover td a.btn-delcfg {
		visibility: visible;
	}
</style>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
